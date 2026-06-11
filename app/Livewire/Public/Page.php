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

        // 2. Ambil kriteria sections yang hanya is_visible = true di sini
        $this->sections = $this->landingPage->sections()
            ->where('is_visible', true)
            ->get();
    }

    public function addToCart($sectionId, $productName, $price)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$sectionId])) {
            $cart[$sectionId]['qty']++;
        } else {
            $cart[$sectionId] = [
                'name'  => $productName,
                'qty'   => 1,
                'price' => $price,
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
        session()->flash('success', 'Produk berhasil ditambahkan!');
    }

    public function render()
    {
        // 3. Fungsi render sekarang sangat bersih, tinggal melempar properti class ke layout
        return view('livewire.public.page')
            ->layout('layouts.public', [
                'landingPage' => $this->landingPage
            ]);
    }
}