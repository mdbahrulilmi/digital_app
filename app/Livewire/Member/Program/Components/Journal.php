<?php

namespace App\Livewire\Member\Program\Components;

use App\Models\Journal as JournalModel;
use App\Models\TaskSubmission;
use Livewire\Component;

class Journal extends Component
{
    
    public $selectedSubmission = null;
    public $showTaskModal = false;

    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function openTaskDetail($submissionId)
    {
        $this->selectedSubmission = TaskSubmission::find($submissionId);
        $this->showTaskModal = true;
    }

    public function closeTaskModal()
    {
        $this->showTaskModal = false;
        $this->selectedSubmission = null;
    }

    public function render()
    {
        $memberId = auth('member')->id();

         $journalsLog = JournalModel::with('programSchedule.program')
            ->where('member_id', $memberId)
            ->program($this->slug)
            ->latest()
            ->get();

        return view('livewire.member.program.components.journal', [
            'journalsLog' => $journalsLog
        ])->layout('layouts.program');
    }
}