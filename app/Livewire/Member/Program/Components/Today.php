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

    public function render()
    {
        $schedules = ProgramSchedule::where('program_id', $this->program->id)
            ->whereDate('date', Carbon::today())
            ->get();

        return view('livewire.member.program.components.today', [
            'schedules' => $schedules
        ])->layout('layouts.program');
    }
}