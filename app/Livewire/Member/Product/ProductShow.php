<?php

namespace App\Livewire\Member\Product;

use Livewire\Component;

class ProductShow extends Component
{
    public function render()
    {
        return view('livewire.member.product.product-show')->layout('layouts.member');
    }
}
