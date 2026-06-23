<?php

namespace App\Livewire\Admin\Program\Components;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Program;
use App\Models\Product;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\ProgramSchedule;

class ProgramScheduleTask extends Component
{
    public Program $program;

    public $startDate;
    public $endDate;
    public $selectedDate;
    public $schedules = [];
    public $tasks = [];
    public $uploadRequired = false;
    public $allProducts = [];
    public $uploadSettings = [];    

    public function mount(Program $program)
    {
        $this->program = $program;

        $this->allProducts = Product::select(
            'id',
            'title'
        )->get();

        $this->startDate = $program->start_date;
        $this->endDate = $program->end_date;

        $this->selectedDate = now()->between(
            $this->startDate,
            $this->endDate
        )
        ? now()->format('Y-m-d')
        : $this->startDate;

        $this->loadSchedules();
        $this->loadTasks();
    }

    public function updatedSelectedDate()
    {
        logger('selected date changed');
    }

    private function loadSchedules()
    {
        $savedSchedules = ProgramSchedule::with('programProducts') 
            ->where('program_id', $this->program->id)
            ->get();

        foreach ($savedSchedules as $schedule) {
            // Ambil array product_id dari tabel pivot/relasi
            $this->schedules[$schedule->date] = $schedule->programProducts->pluck('product_id')->toArray();
            $this->uploadSettings[$schedule->date]['upload'] = (bool) $schedule->upload_required;
        }
    }

    private function saveSchedules()
    {
        $keepScheduleIds = [];

        foreach ($this->schedules as $date => $productIds) {
            $schedule = ProgramSchedule::updateOrCreate(
                ['program_id' => $this->program->id, 'date' => $date],
                ['upload_required' => $this->uploadSettings[$date]['upload'] ?? false]
            );

            $keepScheduleIds[] = $schedule->id;

            // 2. Update Produk untuk jadwal ini
            \App\Models\ProgramProduct::where('program_schedule_id', $schedule->id)->delete();
            foreach ($productIds as $productId) {
                if (empty($productId)) continue;
                \App\Models\ProgramProduct::create([
                    'program_schedule_id' => $schedule->id,
                    'product_id'          => $productId
                ]);
            }
        }

        // 3. Hapus jadwal yang sudah tidak ada di form
        ProgramSchedule::where('program_id', $this->program->id)
            ->whereNotIn('id', $keepScheduleIds)
            ->delete();
    }

    private function loadTasks()
    {
        $scheduleIds = \App\Models\ProgramSchedule::where('program_id', $this->program->id)
            ->pluck('id');
        $savedTasks = Task::whereIn('program_schedule_id', $scheduleIds)->get();

        foreach ($savedTasks as $task) {
            $date = $task->schedule->date; 

            $this->tasks[$date][] = [
                'id'   => $task->id,
                'task' => $task->task
            ];
        }
    }

    public function getDatesProperty()
    {
        $dates = [];

        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);

        while ($start <= $end) {
            $dates[] = $start->copy();
            $start->addDay();
        }

        return $dates;
    }

    // ==================
    // PRODUCT SCHEDULE
    // ==================

    public function addProductSlot($date)
    {
        $this->schedules[$date][] = '';
    }

    public function removeProductSlot($date, $index)
    {
        unset($this->schedules[$date][$index]);

        $this->schedules[$date] =
            array_values($this->schedules[$date]);
    }

    // ==================
    // TASK
    // ==================

    public function addTaskSlot($date)
    {
        if (!isset($this->tasks[$date])) {
            $this->tasks[$date] = [];
        }

        $this->tasks[$date][] = [
            'id' => null,
            'title' => ''
        ];
    }

    public function removeTaskSlot($date, $index)
    {
        if (!isset($this->tasks[$date][$index])) {
            return;
        }

        unset($this->tasks[$date][$index]);

        $this->tasks[$date] =
            array_values($this->tasks[$date]);
    }

    // ==================
    // SAVE
    // ==================

    public function save()
    {
        $this->saveSchedules();
        $this->saveTasks();

        session()->flash(
            'message',
            'Schedule & Task berhasil disimpan'
        );
    }

    public function getMemberSubmissions($dateKey)
    {
        $scheduleIds = ProgramSchedule::where('program_id', $this->program->id)
        ->where('date', $dateKey)
        ->pluck('id');

        if ($scheduleIds->isEmpty()) {
            return collect();
        }

        return \App\Models\TaskSubmission::with('member')
            ->whereIn('program_schedule_id', $scheduleIds)
            ->get();
    }

    private function saveTasks()
    {
        $keepTaskIds = [];

        foreach ($this->tasks as $date => $taskList) {
            $schedule = ProgramSchedule::where('program_id', $this->program->id)
                                    ->where('date', $date)->first();
            if (!$schedule) continue;

            foreach ($taskList as $taskData) {
                if (empty($taskData['task'])) continue;

                $task = Task::updateOrCreate(
                    ['id' => $taskData['id'] ?? null],
                    [
                        'program_schedule_id' => $schedule->id,
                        'task'               => $taskData['task']
                    ]
                );
                $keepTaskIds[] = $task->id;
            }
        }

        Task::whereIn('program_schedule_id', ProgramSchedule::where('program_id', $this->program->id)->pluck('id'))
            ->whereNotIn('id', $keepTaskIds)
            ->delete();
    }

    public function render()
    {
        logger([
            'tasks_dates' => count($this->tasks),
            'schedule_dates' => count($this->schedules),
            'products' => count($this->allProducts),
        ]);

        return view(
            'livewire.admin.program.components.material'
        );
    }
}