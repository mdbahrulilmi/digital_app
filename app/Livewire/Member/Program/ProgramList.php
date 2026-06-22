<?php

namespace App\Livewire\Member\Program;

use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProgramList extends Component
{
    public function render()
    {
        $member = Auth::guard('member')->user();
        $orderItems = OrderItem::whereHas('order', function ($query) use ($member) {
                $query->where('customer_whatsapp', $member->whatsapp);
            })
            ->where('type', 'program')
            ->where('status', 'paid')
            ->with('program')
            ->get();

        return view('livewire.member.program.program-list', [
            'orderItems' => $orderItems
        ])->layout('layouts.member');
    }
}