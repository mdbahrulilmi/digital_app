<?php

namespace App\Livewire\Member\Product;

use Livewire\Component;

class ProductList extends Component
{
    public function render()
    {
        return view('livewire.member.product.product-list')->layout('layouts.member');
    }
}
