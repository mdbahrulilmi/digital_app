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
            ->orderBy('start_time', 'asc')
            ->get();

        $now = now();

        $sessions = [
            'live' => [],
            'soon' => [],
            'upcoming' => [],
            'past' => [],
        ];

        foreach ($allSessions as $session) {

            $start = \Carbon\Carbon::parse($session->date . ' ' . $session->start_time);
            $end   = \Carbon\Carbon::parse($session->date . ' ' . $session->end_time);

            if ($now->between($start, $end)) {
                $sessions['live'][] = $session;
                continue;
            }

            if ($now->gt($end)) {
                $sessions['past'][] = $session;
                continue;
            }

            $diffInHours = $now->diffInHours($start, false);

            if ($diffInHours <= 24) {
                $sessions['soon'][] = $session;
            } else {
                $sessions['upcoming'][] = $session;
            }
        }

        return view('livewire.member.program.components.webinar', [
            'sessions' => $sessions
        ])->layout('layouts.program');
    }
}