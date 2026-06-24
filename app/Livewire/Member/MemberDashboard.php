<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\OrderItem;
use App\Models\Program;
use App\Models\Product;
use App\Models\LandingPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
                $p->jurnal_count = \App\Models\Journal::where('member_id', $member->id)
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

        $itemDibeli = \App\Models\OrderItem::whereHas('order', function($q) use ($member) {
            $q->where('customer_whatsapp', $member->whatsapp)
              ->where('status', 'paid');
        })
        ->get();

        $programDibeliIds = $itemDibeli->whereNotNull('program_id')->pluck('program_id');
        $produkDibeliIds = $itemDibeli->whereNotNull('product_id')->pluck('product_id');
        
        $this->programs = Program::where('status', 'active')
            ->whereNotIn('id', $programDibeliIds)
            ->latest()
            ->take(3)
            ->get();

        $this->products = Product::where('status', 'active')
            ->whereNotIn('id', $produkDibeliIds)
            ->latest()
            ->take(3)
            ->get();

        $this->blogs = \App\Models\LandingPage::where('blog', 1)
            ->where('status', 'published')
            ->with(['sections' => function($query) {
                $query->where('type', 'image')->orderBy('sort_order', 'asc');
            }])
            ->latest()
            ->take(3)
            ->get();

        
        $programQuery = OrderItem::query()
            ->whereHas('order', function ($q) use ($member) {
                $q->where('customer_whatsapp', $member->whatsapp)
                ->where('status', 'paid')
                ->where('type', 'program');
            });

        $productQuery = OrderItem::query()
            ->whereHas('order', function ($q) use ($member) {
                $q->where('customer_whatsapp', $member->whatsapp)
                ->where('status', 'paid')
                ->where('type', 'product');
            });

        $programSelesai = (clone $programQuery)
            ->whereHas('program', function ($q) use ($today) {
                $q->whereDate('end_date', '<', $today);
            })->count();
        $totalProgram = (clone $programQuery)->count();
        $totalProduct = (clone $productQuery)->count();

        $this->stats = [
            'streak'          => $this->streak,
            'program_selesai' => $programSelesai,
            'total_program'   => $totalProgram,
            'total_produk'    => $totalProduct
        ];
    }

    private function hitungStreak($memberId)
    {
        $dates = \App\Models\Journal::where('member_id', $memberId)
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
            'stats' => $this->stats
        ])->layout('layouts.member');
    }
}