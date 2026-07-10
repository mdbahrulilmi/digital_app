<?php

namespace App\Livewire\Member\Riwayat;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class RiwayatList extends Component
{
    use WithPagination;

    public function render()
    {
        $member = Auth::guard('member')->user();

        $purchases = Order::where('customer_whatsapp', $member->whatsapp)
            ->latest()
            ->paginate(10);

        return view('livewire.member.riwayat.riwayat-list', [
            'purchases' => $purchases
        ])->layout('layouts.member');
    }
}
