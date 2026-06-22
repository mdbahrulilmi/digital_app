<?php

namespace App\Livewire\Member\Program\Components;

use App\Models\Program;
use App\Models\ProgramSchedule;
use Livewire\Component;
use Illuminate\Support\Carbon;

class Today extends Component
{
    public $slug;
    public $program;
    public $selectedProduct = null;
    public $showModal = false;
    public $showUploadModal = false;
    public $selectedTask = null;
    public $journalContent = '';

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->program = Program::where('slug', $slug)->firstOrFail();
    }

    public function openProduct($productId)
    {
        $isEnrolled = $this->program->members()->where('member_id', auth('member')->id())->exists();

        if (!$isEnrolled) {
            session()->flash('error', 'Anda tidak terdaftar dalam program ini.');
            return;
        }

        $this->selectedProduct = \App\Models\Product::find($productId);
    
        if ($this->selectedProduct && $this->selectedProduct->digital_assets) {
            $this->selectedProduct->decoded_asset = json_decode($this->selectedProduct->digital_assets, true);
        }
        
        $this->showModal = true;
        $this->dispatch('modal-opened');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedProduct = null;
    }

    public function openUploadModal($taskId)
    {
        $this->selectedTask = \App\Models\Task::find($taskId);
        $this->showUploadModal = true;
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->selectedTask = null;
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

    public function render()
    {
        $today = Carbon::today()->format('Y-m-d');
        $schedules = ProgramSchedule::with(['product', 'tasks'])
            ->where('program_id', $this->program->id)
            ->whereDate('date', $today)
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            })
            ->map(function ($items, $date) {
                return (object) [
                    'date' => $date,
                    'materials' => $items->pluck('product')->filter(), 
                    'tasks' => $items->flatMap->tasks->unique('id'),
                ];
            })
            ->values();

        return view('livewire.member.program.components.today', [
            'schedules' => $schedules
        ])->layout('layouts.program');
    }
}