<?php

namespace App\Livewire\Public\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class CartBadge extends Component
{
    // Kita buat pendengarnya eksplisit me-refresh dirinya sendiri
    #[On('cartUpdated')]
    public function updateBadge()
    {
        // Kosongkan saja, ini memicu komponen untuk render ulang otomatis
    }

    public function render()
    {
        return view('livewire.public.components.cart-badge');
    }
}