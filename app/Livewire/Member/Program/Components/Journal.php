<?php

namespace App\Livewire\Member\Program\Components;

use App\Models\Journal as JournalModel;
use Livewire\Component;

class Journal extends Component
{
    
    public $selectedSubmission = null;
    public $showTaskModal = false;

    public function openTaskDetail($submissionId)
    {
        $this->selectedSubmission = \App\Models\TaskSubmission::find($submissionId);
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

        $journalsLog = JournalModel::where(
            'member_id',
            $memberId
        )
        ->latest()
        ->get();

        return view('livewire.member.program.components.journal', [
            'journalsLog' => $journalsLog
        ])->layout('layouts.program');
    }
}