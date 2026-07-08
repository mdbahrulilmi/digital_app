<?php

namespace App\Livewire\Member\Components;

use Livewire\Component;

class AssetViewer extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }
    
    public function render()
    {
        return view('livewire.member.components.asset-viewer');
    }
}
