<?php

namespace App\Livewire\Member\Program;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProgramList extends Component
{
    public function render()
    {
        $member = Auth::guard('member')->user();
        $today = now()->startOfDay();

        return view('livewire.member.program.program-list', [
            'activePrograms' => $member->programs()
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->orderBy('end_date')
                ->get(),

            'upcomingPrograms' => $member->programs()
                ->whereDate('start_date', '>', $today)
                ->orderBy('start_date')
                ->get(),

            'finishedPrograms' => $member->programs()
                ->whereDate('end_date', '<', $today)
                ->latest('end_date')
                ->get(),
        ])->layout('layouts.member');
    }
}