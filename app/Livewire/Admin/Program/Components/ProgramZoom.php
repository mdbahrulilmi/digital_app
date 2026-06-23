<?php

namespace App\Livewire\Admin\Program\Components;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Program;

class ProgramZoom extends Component
{
    public Program $program;

    public $zoomLinks = [];

    public function mount(Program $program)
    {
        $this->program = $program;

        $this->reloadZooms();
    }

    public function addZoomField()
    {
        $this->zoomLinks[] = [
            'id' => null,
            'title' => '',
            'date' => '',
            'start_time' => '',
            'end_time' => '',
            'url' => '',
            'recording_url' => '',
        ];
    }

    public function removeZoomField($index)
    {
        unset($this->zoomLinks[$index]);

        $this->zoomLinks =
            array_values($this->zoomLinks);
    }

    public function save()
    {
        $this->validate([
            'zoomLinks.*.title' => 'required',
            'zoomLinks.*.date' => 'required|date',
            'zoomLinks.*.start_time' => 'required',
            'zoomLinks.*.end_time' => 'required',
            'zoomLinks.*.url' => 'required|url',
        ]);

        $keepIds = [];

        foreach ($this->zoomLinks as $link) {

            if ($link['id']) {

                $zoom = $this->program
                    ->zooms()
                    ->find($link['id']);

                if ($zoom) {

                    $zoom->update($link);

                    $keepIds[] = $zoom->id;
                }

            } else {

                $zoom = $this->program
                    ->zooms()
                    ->create($link);

                $keepIds[] = $zoom->id;
            }
        }

        $this->program
            ->zooms()
            ->whereNotIn('id', $keepIds)
            ->delete();

        $this->reloadZooms();

        session()->flash(
            'message',
            'Jadwal Webinar berhasil disimpan'
        );
    }

    private function reloadZooms()
    {
        $this->zoomLinks =
            $this->program->zooms
            ->map(fn($zoom) => [
                'id' => $zoom->id,
                'title' => $zoom->title,
                'date' => $zoom->date,
                'start_time' => $zoom->start_time,
                'end_time' => $zoom->end_time,
                'url' => $zoom->url,
                'recording_url' => $zoom->recording_url,
            ])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.program.components.webinar');
    }
}