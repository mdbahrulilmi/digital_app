<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\OrderItem;
use App\Models\Program;
use App\Models\Product;
use App\Models\Journal;
use App\Models\LandingPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\ProgramProduct;

class MemberDashboard extends Component
{
    public $stats = [];
    public $jadwalHariIni = [];
    public $infoStats = [];
    
    public $programUtama;
    public $progresPersen = 0;
    public $streak = 0; 

    public $programs = [];
    public $products = [];
    public $blogs = [];
    
    public $showPasswordModal = false;
    public $newPassword;

    public $memberPrograms = [];
    public $totalMemberPrograms = 0;

    public function mount()
    {
        $member = Auth::guard('member')->user();

        if (Hash::check($member->whatsapp, $member->password) && !session()->has('ignore_password_change')) {
            $this->showPasswordModal = true;
        }

        $today = Carbon::today();

        $programUtama = $member->programs()
            ->where('status', 'active')
            ->withCount('schedules')
            ->get()
            ->map(function ($p) use ($member) {
                $p->jurnal_count = Journal::where('member_id', $member->id)
                    ->whereIn('program_schedule_id', $p->schedules->pluck('id'))
                    ->count();
                return $p;
            })
            ->sortByDesc('jurnal_count')
            ->first();

        $this->programUtama = $programUtama;

        if ($programUtama && $programUtama->schedules_count > 0) {
            $this->progresPersen = ($programUtama->jurnal_count / $programUtama->schedules_count) * 100;
        } else {
            $this->progresPersen = 0;
        }

        $this->streak = $this->hitungStreak($member->id);

       $programDibeliIds = $member->programs()
            ->pluck('programs.id');

        $produkDibeliIds = OrderItem::whereHas('order', function ($q) use ($member) {
            $q->where('customer_whatsapp', $member->whatsapp)
                ->where('status', 'paid');
        })
        ->where('type', 'product')
        ->pluck('product_id');

        $produkDariProgram = ProgramProduct::whereHas('schedule', function ($q) use ($programDibeliIds) {
            $q->whereIn('program_id', $programDibeliIds);
        })
        ->pluck('product_id');

        $excludeProductIds = $produkDibeliIds
        ->merge($produkDariProgram)
        ->unique();
        
        $this->programs = Program::where('status', 'active')
            ->whereNotIn('id', $programDibeliIds)
            ->latest()
            ->take(3)
            ->get();

        $this->products = Product::where('status', 'active')
            ->whereNotIn('id', $excludeProductIds)
            ->latest()
            ->take(3)
            ->get();
        
        $programQuery = $member->programs();

        $productQuery = OrderItem::whereHas('order', function ($q) use ($member) {
            $q->where('customer_whatsapp', $member->whatsapp)
                ->where('status', 'paid');
        })
        ->where('type', 'product');

        $programSelesai = (clone $programQuery)
            ->whereDate('end_date', '<', $today)
            ->count();
            
        $totalProgram = (clone $programQuery)->count();
        $totalProduct = (clone $productQuery)->count();

        $today = now()->startOfDay();

        $this->memberPrograms = $member->programs()
            ->where('status', 'active')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->withCount('schedules')
            ->get()
            ->map(function ($program) use ($member) {

                $journalCount = Journal::where('member_id', $member->id)
                    ->whereIn('program_schedule_id', $program->schedules->pluck('id'))
                    ->count();

                $program->progress = $program->schedules_count > 0
                    ? round(($journalCount / $program->schedules_count) * 100)
                    : 0;

                return $program;

            })
            ->sortByDesc('progress')
            ->take(3);
        
        $this->totalMemberPrograms = $member->programs()
            ->where('status', 'active')
            ->count();

        $this->stats = [
            'streak'          => $this->streak,
            'program_selesai' => $programSelesai,
            'total_program'   => $totalProgram,
            'total_produk'    => $totalProduct
        ];
    }

    private function hitungStreak($memberId)
    {
        $dates = Journal::where('member_id', $memberId)
            ->selectRaw('DATE(created_at) as date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date');

        $streak = 0;
        $currentDate = Carbon::today();

        foreach ($dates as $date) {
            if (Carbon::parse($date)->isSameDay($currentDate) || Carbon::parse($date)->isSameDay($currentDate->copy()->subDay())) {
                $streak++;
                $currentDate->subDay();
            } else {
                break;
            }
        }
        return $streak;
    }

    public function closeModal()
    {
        $this->showPasswordModal = false;
        session()->put('ignore_password_change', true);
    }

    public function updatePassword()
    {
        $this->validate(['newPassword' => 'required|min:8']);
        
        $member = Auth::guard('member')->user();
        $member->password = Hash::make($this->newPassword);
        $member->save();
        
        $this->showPasswordModal = false;
        session()->forget('ignore_password_change');
        session()->flash('message', 'Password berhasil diubah!');
    }

    public function render()
    {
        return view('livewire.member.dashboard', [
            'stats' => $this->stats,
            'memberPrograms' => $this->memberPrograms,
            'totalMemberPrograms' => $this->totalMemberPrograms
        ])->layout('layouts.member');
    }
}