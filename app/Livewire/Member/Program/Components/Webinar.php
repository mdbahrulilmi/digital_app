<?php

namespace App\Livewire\Member\Program\Components;

use App\Models\Zoom;
use App\Models\Program;
use Livewire\Component;

class Webinar extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $program = Program::where('slug', $this->slug)->firstOrFail();
        
        $allSessions = Zoom::where('program_id', $program->id)
            ->orderBy('date', 'asc')
            ->get();
            
        $sessions = $allSessions->groupBy('status');

        return view('livewire.member.program.components.webinar', [
            'sessions' => $sessions
        ])->layout('layouts.program');
    }
}