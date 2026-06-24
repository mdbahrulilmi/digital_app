<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Product;

class PublicProductShow extends Component
{
    public $product = [];

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)->firstOrFail();
    }

    public function buyNow()
    {
        session()->forget('cart');
        
        session()->put('cart', [
            'product_' . $this->product->id => [
                'id'    => $this->product->id,
                'name'  => $this->product->title,
                'qty'   => 1,
                'price' => $this->product->price,
                'type'  => 'product',
            ]
        ]);

        return $this->redirect(route('public.checkout'), navigate: true);
    }

    public function render()
    {
        return view('livewire.public.product-show')
            ->layout('layouts.public');
    }
}
