<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class ProductShow extends Component
{
    public $product;

    public function mount($id)
    {
        // Mengambil data produk berdasarkan ID yang dikirim
        $this->product = Product::findOrFail($id);
    }

    public function downloadAsset()
    {
        // 1. (Opsional) Cek proteksi di sini jika diperlukan, misal:
        // if (!auth()->user()->hasPurchased($this->product->id)) {
        //     session()->flash('error', 'Anda harus membeli produk ini terlebih dahulu.');
        //     return;
        // }

        $path = $this->product->digital_assets;

        // 2. Pastikan path file tidak kosong dan filenya benar-benar ada di disk local
        if ($path && Storage::disk('local')->exists($path)) {
            
            // Mengambil ekstensi file asli (misal: pdf, zip)
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            
            // Membersihkan nama produk untuk dijadikan nama file saat didownload
            $safeName = str($this->product->name)->slug() . '-asset.' . $extension;

            // 3. Trigger download langsung dari storage internal aman
            return Storage::disk('local')->download($path, $safeName);
        }

        // Jika file tidak ditemukan di server
        session()->flash('error', 'File digital asset tidak ditemukan atau belum diunggah.');
    }

    public function render()
    {
        return view('livewire.product.product-show');
    }
}