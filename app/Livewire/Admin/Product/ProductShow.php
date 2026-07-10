<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class ProductShow extends Component
{
    public $product;

    public function mount($id)
    {
        $this->product = Product::findOrFail($id);
    }

    public function downloadAsset()
    {
        $digitalAssets = is_string($this->product->digital_assets) 
            ? json_decode($this->product->digital_assets, true) 
            : $this->product->digital_assets;

        if (isset($digitalAssets['type']) && $digitalAssets['type'] === 'link') {
            $url = $digitalAssets['url'] ?? '#';
            return redirect()->away($url);
        }

        $path = $digitalAssets['path'] ?? null;

        if ($path && Storage::disk('public')->exists($path)) {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $safeTitle = str($this->product->title)->slug() . '-asset.' . $extension;
            return Storage::disk('public')->download($path, $safeTitle);
        }

        session()->flash('error', 'Aset tidak ditemukan atau link tidak valid.');
    }

    public function render()
    {
        return view('livewire.admin.product.show');
    }
}