<?php

namespace App\Livewire\Payment;

use Livewire\Component;
use App\Models\Order;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class Success extends Component
{
    public $orderId;

    public function mount()
    {
        $this->orderId = request()->query('order_id');
        
        $order = Order::where('order_id', $this->orderId)->first();

        if ($order && $order->status === 'paid') {
            $member = Member::where('whatsapp', $order->customer_whatsapp)->first();
            
            if ($member && !Auth::guard('member')->check()) {
                Auth::guard('member')->login($member);
            }
        }
    }

    public function render()
    {
        return view('livewire.payment.success')->layout('layouts.public');
    }
}
