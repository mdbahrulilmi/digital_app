<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\LandingPage;

class Page extends Component
{
    // 1. Deklarasikan properti public agar bisa diakses langsung di View Blade
    public $landingPage;
    public $sections = [];
    public $slug; 

    public function mount($slug = null)
    {
        $this->slug = $slug;

        // Jika slug kosong/null, berarti sedang mengakses halaman utama (localhost:8000)
        if (empty($slug)) {
            $this->landingPage = LandingPage::where('home', 1) // Sesuaikan jika biner 1
                ->where('status', 'published')
                ->first();
        } else {
            $this->landingPage = LandingPage::where('slug', $slug)
                ->where('status', 'published')
                ->first();
        }

        if (!$this->landingPage) {
            abort(404, 'Halaman tidak ditemukan');
        }

        $this->sections = $this->landingPage->sections()
            ->where('is_visible', true)
            ->get();
    }

    public function addToCart($id, $name, $price, $type)
    {
        if ($type === 'checkout_program') {

            session()->forget('cart');

            session()->put('cart', [
                'program_'.$id => [
                    'id'    => $id,
                    'name'  => $name,
                    'qty'   => 1,
                    'price' => $price,
                    'type'  => 'program',
                ]
            ]);

            $this->redirect(route('public.checkout'), navigate: true);
            return;
        }
        $cart = session()->get('cart', []);
        $cartKey = $type . '_' . $id; 

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty']++;
        } else {
            $cart[$cartKey] = [
                'id'    => $id,
                'name'  => $name,
                'qty'   => 1,
                'price' => $price,
                'type'  => $type, // Simpan tipenya
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
        session()->flash('success', 'Berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.public.page')
            ->layout('layouts.public', [
                'landingPage' => $this->landingPage
            ]);
    }
}