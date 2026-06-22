<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MemberDashboard extends Component
{
    public $stats = [];
    public $jadwalHariIni = [];
    public $infoStats = [];
    public $showPasswordModal = false;
    public $newPassword;

    public function mount()
    {
        $member = Auth::guard('member')->user();

        if (Hash::check($member->whatsapp, $member->password) && !session()->has('ignore_password_change')) {
            $this->showPasswordModal = true;
        }

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