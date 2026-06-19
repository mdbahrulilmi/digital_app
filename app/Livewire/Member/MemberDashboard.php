<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MemberDashboard extends Component
{
    public $member;
    public $orders;

    public function mount()
    {
        $this->member = Auth::guard('member')->user();
        $this->orders = Order::where('customer_whatsapp', $this->member->whatsapp)
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.member.dashboard')->layout('layouts.member');
    }
}