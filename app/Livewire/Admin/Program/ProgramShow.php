<?php

namespace App\Livewire\Admin\Program;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\Program;
use App\Models\Product;
use App\Models\ProgramSchedule;

class ProgramShow extends Component
{
    use WithPagination;

    public $program;
    public $zoomLinks = [];
    public $selectedProducts = [];
    public $searchProduct = '';
    public $searchMember = '';
    
    public $startDate;
    public $endDate;
    public $schedules = [];

    public function mount($id)
    {
       $this->program = Program::findOrFail($id);
        $this->startDate = $this->program->start_date;
        $this->endDate = $this->program->end_date;
        

        $savedSchedules = ProgramSchedule::where('program_id', $id)->get();
        foreach ($savedSchedules as $schedule) {
            $this->schedules[$schedule->date][] = $schedule->product_id;
        }
        $this->zoomLinks = $this->program->zooms->map(function ($zoom) {
            return [
                'id'         => $zoom->id,
                'date'       => $zoom->date,
                'start_time' => $zoom->start_time
                    ? Carbon::parse($zoom->start_time)->format('H:i')
                    : '',
                'end_time'   => $zoom->end_time
                    ? Carbon::parse($zoom->end_time)->format('H:i')
                    : '',
                'url'        => $zoom->url,
            ];
        })->toArray();
    }

    public function getDatesProperty()
    {
        if (!$this->startDate || !$this->endDate) return [];

        $dates = [];
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        
        while ($start <= $end) {
            $dates[] = $start->copy();
            $start->addDay();
        }
        return $dates;
    }

    public function addProductSlot($date)
    {
        // Tambah slot kosong untuk tanggal tersebut
        $this->schedules[$date][] = ''; 
    }

    public function removeProductSlot($date, $index)
    {
        unset($this->schedules[$date][$index]);
        $this->schedules[$date] = array_values($this->schedules[$date]);
    }

    public function addZoomField()
    {
        $this->zoomLinks[] = [
            'id'         => null,
            'date'       => '',
            'start_time' => '',
            'end_time'   => '',
            'url'        => '',
        ];
    }

    public function removeZoomField($index) 
    {
        unset($this->zoomLinks[$index]);
        $this->zoomLinks = array_values($this->zoomLinks);
    }

   public function saveZooms()
    {
        $this->validate([
            'zoomLinks.*.date' => 'required|date',
            'zoomLinks.*.start_time' => 'required',
            'zoomLinks.*.end_time' => 'required',
            'zoomLinks.*.url' => 'required|url',
        ], [
            'zoomLinks.*.date.required' => 'Tanggal wajib diisi.',
            'zoomLinks.*.date.date' => 'Format tanggal tidak valid.',

            'zoomLinks.*.start_time.required' => 'Jam mulai wajib diisi.',
            'zoomLinks.*.end_time.required' => 'Jam selesai wajib diisi.',

            'zoomLinks.*.url.required' => 'Link Zoom wajib diisi.',
            'zoomLinks.*.url.url' => 'Format URL tidak valid.',
        ]);

        $keepIds = [];

        foreach ($this->zoomLinks as $link) {

            if (empty($link['url'])) {
                continue;
            }

            if (!empty($link['id'])) {

                $zoom = $this->program->zooms()->find($link['id']);

                if ($zoom) {
                    $zoom->update([
                        'date' => $link['date'],
                        'start_time' => $link['start_time'],
                        'end_time' => $link['end_time'],
                        'url' => $link['url'],
                    ]);

                    $keepIds[] = $zoom->id;
                }

            } else {

                $zoom = $this->program->zooms()->create([
                    'date' => $link['date'],
                    'start_time' => $link['start_time'],
                    'end_time' => $link['end_time'],
                    'url' => $link['url'],
                ]);

                $keepIds[] = $zoom->id;
            }
        }

        $this->program->zooms()
            ->whereNotIn('id', $keepIds)
            ->delete();

        // 🔥 RELOAD DI SINI (SEKALI SAJA)
        $this->reloadZooms();

        session()->flash('message', 'Data berhasil disimpan!');
    }

    public function reloadZooms()
    {
        $this->zoomLinks = $this->program->zooms()
            ->get()
            ->map(function ($zoom) {
                return [
                    'id' => $zoom->id,
                    'date' => $zoom->date,
                    'start_time' => $zoom->start_time,
                    'end_time' => $zoom->end_time,
                    'url' => $zoom->url,
                ];
            })
            ->toArray();
    }

    public function saveSettings()
    {   
        session()->flash('message', 'Pengaturan berhasil disimpan!');
    }

    public function saveSchedule()
    {
        $existing = ProgramSchedule::where('program_id', $this->program->id)
            ->get()
            ->keyBy(fn($item) => $item->date . '-' . $item->product_id);

        $keepIds = [];

        foreach ($this->schedules as $date => $products) {

            foreach ($products as $productId) {

                if (!$productId) {
                    continue;
                }

                $key = $date . '-' . $productId;

                if (isset($existing[$key])) {
                    $keepIds[] = $existing[$key]->id;
                } else {
                    $schedule = ProgramSchedule::create([
                        'program_id' => $this->program->id,
                        'product_id' => $productId,
                        'date'       => $date,
                    ]);

                    $keepIds[] = $schedule->id;
                }
            }
        }

        ProgramSchedule::where('program_id', $this->program->id)
            ->whereNotIn('id', $keepIds)
            ->delete();

        session()->flash('message', 'Jadwal Materi berhasil disimpan!');
    }

    public function render()
    {
        $allProducts = Product::where('title', 'like', '%' . $this->searchProduct . '%')->get();
        $membersQuery = $this->program->members();
    
        if (!empty($this->searchMember)) {
            $membersQuery->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchMember . '%')
                ->orWhere('email', 'like', '%' . $this->searchMember . '%');
            });
        }
        $section = \App\Models\LandingPage::where('program_id', $this->program->id)
                               ->whereNull('program_page_id')
                               ->first();
        $subPages =  \App\Models\LandingPage::where('program_page_id', $section->id)->get();
            
        return view('livewire.admin.program.show', [
            'allProducts' => Product::all(),
            'members' => $this->program->members()->paginate(10),
            'section' => $section,
            'subPages' => $subPages
            
        ]);
    }
}