<?php

namespace App\Livewire\Member\Program;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProgramList extends Component
{
    public function render()
    {
        $member = Auth::guard('member')->user();

        $programs = $member->programs()->latest()->get();

        return view('livewire.member.program.program-list', [
            'programs' => $programs
        ])->layout('layouts.member');
    }
}