<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\LandingPage;

class Page extends Component
{
    public $landingPage;
    public $sections = [];
    public $slug; 

    public function mount($slug = null)
    {
        $this->slug = $slug;

        $query = LandingPage::with([
            'sections' => function ($q) {
                $q->where('is_visible', true)
                ->orderBy('sort_order');
            },
            'sections.components' => function ($q) {
                $q->where('is_visible', true)
                ->orderBy('sort_order');
            }
        ]);

        if (empty($slug)) {
            $this->landingPage = $query
                ->where('home', 1)
                ->where('status', 'published')
                ->first();
        } else {
            $this->landingPage = $query
                ->where('slug', $slug)
                ->where('status', 'published')
                ->first();
        }

        if (!$this->landingPage) {
            abort(404);
        }

        $this->sections = $this->landingPage->sections;
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
                'type'  => $type,
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