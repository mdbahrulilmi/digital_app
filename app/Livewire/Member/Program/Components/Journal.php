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

        $journalsLog = \App\Models\Journal::where('journals.member_id', $memberId)
            ->leftJoin('task_submissions', function($join) use ($memberId) {
                $join->on('journals.program_schedule_id', '=', 'task_submissions.program_schedule_id')
                    ->where('task_submissions.member_id', '=', $memberId);
            })
            ->select('journals.*', 'task_submissions.file_path', 'task_submissions.comment')
            ->orderBy('journals.created_at', 'DESC')
            ->get();

        return view('livewire.member.program.components.journal', [
            'journalsLog' => $journalsLog
        ])->layout('layouts.program');
    }
}