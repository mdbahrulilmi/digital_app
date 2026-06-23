<?php

namespace App\Livewire\Member\Program\Components;

use App\Models\Journal as JournalModel;
use Livewire\Component;

class Journal extends Component
{
    public function render()
    {
        $journalsLog = JournalModel::where('member_id', auth('member')->id())
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('livewire.member.program.components.journal', [
            'journalsLog' => $journalsLog
        ])->layout('layouts.program');
    }
}