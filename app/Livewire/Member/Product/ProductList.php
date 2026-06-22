<?php

namespace App\Livewire\Member\Product;

use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductList extends Component
{
    public function render()
    {
        $member = Auth::guard('member')->user();
        
        $orderItems = OrderItem::whereHas('order', function ($query) use ($member) {
                $query->where('customer_whatsapp', $member->whatsapp)
                ->where('status', 'paid');
            })
            ->where('type', 'product')
            ->with('product')
            ->get();

        return view('livewire.member.product.product-list', [
            'orderItems' => $orderItems
        ])->layout('layouts.member');
    }
}