<?php

namespace App\Livewire\Public;

use Livewire\Component;

class Cart extends Component
{
    public $cart = [];
    public $totalPrice = 0;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
        
        $this->totalPrice = 0;
        foreach ($this->cart as $item) {
            $this->totalPrice += $item['price'] * $item['qty'];
        }
    }

    public function incrementQty($sectionId)
    {
        if (isset($this->cart[$sectionId])) {
            $this->cart[$sectionId]['qty']++;
            session()->put('cart', $this->cart);
            $this->loadCart();

            // 🔥 Tambahkan ini: Biar badge angka di atas ikut bertambah/sinkron
            $this->dispatch('cartUpdated'); 
        }
    }

    public function decrementQty($sectionId)
    {
        if (isset($this->cart[$sectionId]) && $this->cart[$sectionId]['qty'] > 1) {
            $this->cart[$sectionId]['qty']--;
            session()->put('cart', $this->cart);
            $this->loadCart();

            // 🔥 Tambahkan ini: Biar badge angka di atas ikut berkurang
            $this->dispatch('cartUpdated'); 
        } elseif (isset($this->cart[$sectionId]) && $this->cart[$sectionId]['qty'] == 1) {
            $this->removeItem($sectionId);
        }
    }

    public function removeItem($sectionId)
    {
        if (isset($this->cart[$sectionId])) {
            unset($this->cart[$sectionId]);
            session()->put('cart', $this->cart);
            $this->loadCart();

            // 🔥 Tambahkan ini: Biar badge angka langsung berkurang drastis sesuai item yang dihapus
            $this->dispatch('cartUpdated'); 

            session()->flash('success', 'Produk berhasil dihapus dari keranjang.');
        }
    }

    public function render()
    {
        return view('livewire.public.cart')
            ->layout('layouts.public',[
                'title' => 'Halaman Keranjang'
            ]);
    }
}