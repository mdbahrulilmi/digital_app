<?php

namespace App\Livewire\Member\Product;

use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductList extends Component
{
    public $search = '';
    public $filter = '';
    
    public function render()
    {
        $member = Auth::guard('member')->user();
        
        $orderItems = OrderItem::whereHas('order', function ($query) use ($member) {
            $query->where('customer_whatsapp', $member->whatsapp)
                ->where('status', 'paid');
        })
        ->where('type', 'product')
        ->when($this->search, function ($query) {
            $query->whereHas('product', function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->filter, function ($query) {
            $query->whereHas('product', function ($q) {
                $q->where('type', $this->filter);
            });
        })
        ->with('product')
        ->get();

        return view('livewire.member.product.product-list', [
            'orderItems' => $orderItems
        ])->layout('layouts.member');
    }
}