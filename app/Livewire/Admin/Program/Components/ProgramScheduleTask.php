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
        $savedSchedules = ProgramSchedule::where(
            'program_id',
            $this->program->id
        )->get();

        foreach ($savedSchedules as $schedule) {
            $this->schedules[$schedule->date][] = $schedule->product_id;
            $this->uploadSettings[$schedule->date]['upload'] = (bool) $schedule->upload_required;
        }

    }

    private function loadTasks()
    {
        $savedTasks = Task::where(
            'program_id',
            $this->program->id
        )->get();

        foreach ($savedTasks as $task) {

            $this->tasks[$task->date][] = [
                'id' => $task->id,
                'title' => $task->title
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

    private function saveSchedules()
    {
        $existing = ProgramSchedule::where('program_id', $this->program->id)
            ->get()
            ->keyBy(fn($item) => $item->date . '-' . $item->product_id);

        $keepIds = [];

        foreach ($this->schedules as $date => $products) {
            
            $isUploadEnabled = $this->uploadSettings[$date]['upload'] ?? false;

            foreach ($products as $productId) {
                if (!$productId) continue;

                $key = $date . '-' . $productId;

                $schedule = ProgramSchedule::updateOrCreate(
                    [
                        'program_id' => $this->program->id,
                        'product_id' => $productId,
                        'date' => $date
                    ],
                    [
                        'upload_required' => $isUploadEnabled 
                    ]
                );

                $keepIds[] = $schedule->id;
            }
        }

        ProgramSchedule::where('program_id', $this->program->id)
            ->whereNotIn('id', $keepIds)
            ->delete();
    }

    public function getMemberSubmissions($dateKey)
    {
        $taskIds = Task::where('program_id', $this->program->id)
            ->where('date', $dateKey)
            ->pluck('id');

        if ($taskIds->isEmpty()) {
            return collect();
        }

        return \App\Models\TaskSubmission::with('member')
            ->whereIn('task_id', $taskIds)
            ->get();
    }

    private function saveTasks()
    {
        $keepTaskIds = [];

        foreach ($this->tasks as $date => $taskList) {

            foreach ($taskList as $taskData) {

                if (empty($taskData['title'])) {
                    continue;
                }

                $task = Task::updateOrCreate(
                    [
                        'id' =>
                        $taskData['id'] ?? null
                    ],
                    [
                        'program_id' =>
                            $this->program->id,
                        'date' =>
                            $date,
                        'title' =>
                            $taskData['title']
                    ]
                );

                $keepTaskIds[] = $task->id;
            }
        }

        Task::where(
            'program_id',
            $this->program->id
        )
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