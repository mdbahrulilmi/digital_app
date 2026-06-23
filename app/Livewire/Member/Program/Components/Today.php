<?php

namespace App\Livewire\Member\Program\Components;

use App\Models\Product;
use App\Models\Program;
use App\Models\Journal;
use App\Models\ProgramSchedule;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;
use App\Models\TaskSubmission;

class Today extends Component
{
    use WithFileUploads;

    public $slug;
    public $program;
    public $selectedProduct = null;
    public $showModal = false;
    public $showUploadModal = false;
    public $selectedScheduleId = null;
    public $taskFile;
    public $journals;
    public $journalContents = [];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->program = Program::where('slug', $slug)->firstOrFail();
        $this->loadJournals();
    }

    public function openProduct($productId)
    {
        $isEnrolled = $this->program->members()
            ->where('member_id', auth('member')->id())
            ->exists();

        if (!$isEnrolled) {
            session()->flash('error', 'Anda tidak terdaftar dalam program ini.');
            return;
        }

        $this->selectedProduct = Product::find($productId);

        if ($this->selectedProduct && $this->selectedProduct->digital_assets) {
            $this->selectedProduct->decoded_asset = json_decode(
                $this->selectedProduct->digital_assets,
                true
            );
        }
        $this->showModal = true;

        $this->dispatch('modal-opened');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedProduct = null;
    }

    public function openUploadModal($scheduleId)
    {
        $this->selectedScheduleId = $scheduleId;
        $this->showUploadModal = true;
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->selectedScheduleId = null;
    }

    public function loadJournals()
    {
        $today = Carbon::today()->format('Y-m-d');
    
        $todayScheduleIds = ProgramSchedule::where('program_id', $this->program->id)
            ->where('date', $today)
            ->pluck('id');

        $journals = Journal::where('member_id', auth('member')->id())
            ->whereIn('program_schedule_id', $todayScheduleIds)
            ->get();

        foreach ($journals as $journal) {
            $this->journalContents[$journal->program_schedule_id] = $journal->entry;
        }
    }

    public function saveJournal($scheduleId = null) 
    {
        $today = Carbon::today()->format('Y-m-d');
        $entry = $this->journalContents[$scheduleId] ?? '';

        Journal::updateOrCreate(
            [
                'member_id' => auth('member')->id(),
                'program_schedule_id' => $scheduleId,
            ],
            [
                'entry' => $entry
            ]
        );

        session()->flash('message', 'Jurnal berhasil disimpan!');
    }

    public function submitTask()
    {
        $this->validate([
            'taskFile' => 'required|file|max:2048',
        ]);
        
        $member = auth('member')->user();
        $memberWhatsapp = $member->whatsapp ?? 'NO_WA'; 
        $programName = str_replace(' ', '_', $this->program->name);
        $dateCreated = now()->format('Ymd_His');

        $fileName = "{$memberWhatsapp}_{$programName}_{$dateCreated}." . $this->taskFile->getClientOriginalExtension();
        $path = $this->taskFile->storeAs('tasks', $fileName, 'public');

        \App\Models\TaskSubmission::updateOrCreate(
            [
                'member_id' => $member->id,
                'program_schedule_id' => $this->selectedScheduleId,
            ],
            [
                'file_path' => $path,
            ]
        );

        $this->closeUploadModal();
        session()->flash('message', 'Tugas berhasil disimpan!');
    }

    public function render()
    {
        $today = Carbon::today()->format('Y-m-d');
        
        $schedules = ProgramSchedule::with(['programProducts.product', 'tasks']) 
            ->where('program_id', $this->program->id)
            ->where('date', '=', $today) 
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            })
            ->map(function ($items) {
                $allMaterials = $items->flatMap(function($schedule) {
                    return $schedule->programProducts->map(fn($pp) => $pp->product);
                })->filter();

                return (object) [
                    'date' => $items->first()->date,
                    'schedules_id' => $items->first()->id,
                    'upload_required' => $items->first()->upload_required,
                    'materials' => $allMaterials,
                    'tasks' => $items->flatMap->tasks,
                ];
            });

        $submissions = TaskSubmission::where('member_id', auth('member')->id())
            ->get()
            ->keyBy('program_schedule_id');

        return view('livewire.member.program.components.today', [
            'schedules' => $schedules,
            'submissions' => $submissions
        ])->layout('layouts.program');
    }
}