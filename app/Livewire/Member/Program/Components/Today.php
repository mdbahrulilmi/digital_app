<?php

namespace App\Livewire\Member\Program\Components;

use App\Models\Program;
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
    public $journalContent = '';
    public $taskFile;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->program = Program::where('slug', $slug)->firstOrFail();
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

        $this->selectedProduct = \App\Models\Product::find($productId);

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

    public function saveJournal($scheduleId)
    {
        $this->validate([
            'journalContent' => 'required|min:5',
        ]);

        \App\Models\Journal::create([
            'program_schedule_id' => $scheduleId,
            'member_id' => auth('member')->id(),
            'content' => $this->journalContent,
        ]);

        $this->journalContent = ''; // Reset form
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
        
        $schedules = ProgramSchedule::with(['product', 'tasks'])
            ->where('program_id', $this->program->id)
            ->where('date', '=', $today) 
            ->orderBy('date', 'ASC')
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            })
            ->map(function ($items, $date) {
                return (object) [
                    'date' => $date,
                    'schedules_id' => $items->first()->id,
                    'materials' => $items->pluck('product')->filter(),
                    'tasks' => $items->flatMap->tasks->unique('id'),
                ];
            });

        // UBAH: KeyBy jadi program_schedule_id agar cocok dengan tombol di blade
        $submissions = TaskSubmission::where('member_id', auth('member')->id())
            ->get()
            ->keyBy('program_schedule_id');

        return view('livewire.member.program.components.today', [
            'schedules' => $schedules,
            'submissions' => $submissions
        ])->layout('layouts.program');
    }
}