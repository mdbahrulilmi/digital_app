<?php

namespace App\Livewire\Member\Program\Components;

use App\Models\Program;
use App\Models\Product;
use Livewire\Component;

class Material extends Component
{
    public $slug;
    public $showModal = false;
    public $selectedProduct = null;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function openProduct($productId)
    {
        $this->selectedProduct = Product::find($productId);

        if ($this->selectedProduct && $this->selectedProduct->digital_assets) {
            $this->selectedProduct->decoded_asset = json_decode(
                $this->selectedProduct->digital_assets,
                true
            );
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedProduct = null;
    }

    public function render()
    {
        $program = Program::where('slug', $this->slug)
            ->with(['schedules.programProducts.product'])
            ->firstOrFail();

        $products = $program->schedules
            ->flatMap(fn($schedule) => $schedule->programProducts)
            ->map(fn($pp) => $pp->product)
            ->filter()
            ->unique('id');

        return view('livewire.member.program.components.material', [
            'products' => $products
        ])->layout('layouts.program');
    }
}