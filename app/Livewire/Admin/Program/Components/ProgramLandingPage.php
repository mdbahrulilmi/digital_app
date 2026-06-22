<?php

namespace App\Livewire\Admin\Program\Components;

use Livewire\Component;
use App\Models\LandingPage;
use App\Models\Program;

class ProgramLandingPage extends Component
{
    public Program $program;

    public function mount(Program $program)
    {
        $this->program = $program;
    }

    public function render()
    {
        $section = LandingPage::where(
            'program_id',
            $this->program->id
        )
        ->whereNull('program_page_id')
        ->first();

        $subPages = [];

        if ($section) {

            $subPages = LandingPage::where(
                'program_page_id',
                $section->id
            )->get();
        }

        return view(
            'livewire.admin.program.components.landing-page',
            compact(
                'section',
                'subPages'
            )
        );
    }
}