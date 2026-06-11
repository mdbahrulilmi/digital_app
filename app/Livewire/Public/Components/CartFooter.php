<?php

namespace App\Livewire\Public\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class CartFooter extends Component
{

    #[On('cartUpdated')]
    public function refreshFooter()
    {

    }
    public function render()
    {
        return view('livewire.public.components.cart-footer');
    }
}
