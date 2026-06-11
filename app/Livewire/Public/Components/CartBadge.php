<?php

namespace App\Livewire\Public\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class CartBadge extends Component
{
    #[On('cartUpdated')]
    public function updateBadge()
    {
    }

    public function render()
    {
        return view('livewire.public.components.cart-badge');
    }
}