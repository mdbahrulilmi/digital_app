<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MemberDashboard extends Component
{
    public $stats = [];
    public $jadwalHariIni = [];
    public $infoStats = [];

    public function mount()
    {
        $member = Auth::guard('member')->user();
        $today = Carbon::today();

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

        $totalProgram = (clone $programQuery)->count();

        $programAktif = (clone $programQuery)
            ->whereHas('program', function ($q) {
                $q->where('status', 'active');
            })
            ->count();

        $programSelesai = (clone $programQuery)
            ->whereHas('program', function ($q) use ($today) {
                $q->whereDate('end_date', '<', $today);
            })
            ->count();

        $totalProduk = (clone $productQuery)->count();

        $this->stats = [
            'produk' => $totalProduk,
            'program_aktif' => $programAktif,
            'program_selesai' => $programSelesai,
            'total_program' => $totalProgram,
        ];

        $this->infoStats = [
            'aktif' => $member->programs()->where('status', 'active')->first(),
            'sesi_terakhir' => $member->schedules()->latest()->first(),
        ];

        $this->jadwalHariIni = $member->schedules()
            ->whereDate('date', $today)
            ->orderBy('date', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.member.dashboard', [
            'stats' => $this->stats
        ])->layout('layouts.member');
    }
}