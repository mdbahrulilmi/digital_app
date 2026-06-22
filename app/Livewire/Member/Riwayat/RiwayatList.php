<?php

namespace App\Livewire\Member\Riwayat;

use Livewire\Component;

class RiwayatList extends Component
{
    public function render()
    {
        return view('livewire.member.riwayat.riwayat-list')->layout('layouts.member');
    }
}
