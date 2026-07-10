<?php

namespace App\Livewire\Admin\Program;

use Livewire\Component;
use App\Models\Program;
use App\Models\ProgramProduct;
use App\Models\Product;

class ProgramShow extends Component
{
    public Program $program;
    
    public $totalMembers;
    public $uniqueProducts;
    public $activeDays;
    public $nextSession;

    public function mount($id)
    {
        $this->program = Program::findOrFail($id);
        $this->loadDashboardStats();
    }

    private function loadDashboardStats()
    {
        $today = now()->format('Y-m-d');
        
        $this->totalMembers = $this->program->members()->count();
    
        $this->uniqueProducts = ProgramProduct::whereHas('schedule', function($query) {
            $query->where('program_id', $this->program->id);
        })->distinct('product_id')->count('product_id');

        $this->activeDays = $this->program->schedules()
            ->where('date', '>=', $today)
            ->distinct('date')  
            ->count('date');

        $this->nextSession = $this->program->schedules()
            ->where('date', '>=', $today)
            ->orderBy('date', 'asc')
            ->first();
    }

    public function render()
    {
        return view('livewire.admin.program.show');
    }
}