<?php

namespace App\Livewire\Member\Program\Components;

use Livewire\Component;

class Journal extends Component
{
    public function render()
    {
        return view('livewire.member.program.components.journal')->layout('layouts.program');
    }
}
