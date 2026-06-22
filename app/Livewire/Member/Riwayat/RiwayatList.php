<?php

namespace App\Livewire\Member\Riwayat;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class RiwayatList extends Component
{
    public function render()
    {
        $member = Auth::guard('member')->user();

        $purchases = Order::where('customer_whatsapp', $member->whatsapp)
            ->with('items')
            ->latest()
            ->get();

        return view('livewire.member.riwayat.riwayat-list', [
            'purchases' => $purchases
        ])->layout('layouts.member');
    }
}
