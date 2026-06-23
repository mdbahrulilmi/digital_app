<?php

namespace App\Livewire\Member\Product;

use Livewire\Component;
use App\Models\Product;

class ProductShow extends Component
{
    public $slug;
    public $product;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::where('slug', $slug)->firstOrFail();
        
        if (!empty($this->product->digital_assets)) {
            $this->product->decoded_asset = json_decode($this->product->digital_assets, true);
        }
    }

    public function render()
    {
        return view('livewire.member.product.product-show', [
            'product' => $this->product
        ])->layout('layouts.member');
    }
}