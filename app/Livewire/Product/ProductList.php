<?php

namespace App\Livewire\Product;

use App\Models\Media;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ProductList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filterStatus = '';

    // Properti pencarian khusus untuk Media Picker di dalam modal
    public $searchMedia = '';

    public $openModal = false;
    public $editMode = false;
    public $editingId = null;

    public $name;
    public $description;
    public $price;
    public $status = 'active';
    
    // DIGITAL ASSETS
    public $digital_assets;       // Menyimpan nama file/path lama
    public $digital_asset_file;   // Untuk upload file asset baru

    // IMAGE SOURCE SELECTION
    public $image_source = 'upload'; // upload|url|media
    public $image;
    public $image_url;
    public $media_id;
    public $existingImage;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required'],
            'image' => ['nullable', 'image', 'max:2048'],
            'image_url' => ['nullable', 'url'],
            'digital_asset_file' => ['nullable', 'file', 'max:10240'], // Maksimal 10MB
        ];
    }

    // Reset pagination ketika keyword pencarian berubah
    public function updatingSearch()
    {
        $this->resetPage(); 
    }

    public function updatingSearchMedia()
    {
        $this->resetPage('mediaPage');
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->openModal = true;
    }

    public function edit($id)
    {
        $this->resetForm();
        $product = Product::findOrFail($id);

        $this->editingId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->digital_assets = $product->digital_assets;
        $this->status = $product->status;

        $this->image_source = $product->image_source ?? 'upload';
        $this->existingImage = $product->image;

        if ($this->image_source === 'url') {
            $this->image_url = $product->image;
        }

        if ($this->image_source === 'media') {
            $this->media_id = $product->image;
        }

        $this->editMode = true;
        $this->openModal = true;
    }

    public function selectMedia($url)
    {
        // Fungsi pembantu saat user memilih gambar dari Media Library
        $this->media_id = $url;
    }

    public function save()
    {
        $this->validate();

        $imageValue = $this->existingImage;

        // 1. Handle Image Source
        switch ($this->image_source) {
            case 'upload':

            if ($this->image) {

                $mimeType = $this->image->getMimeType();

                if (str_starts_with($mimeType, 'image/')) {
                    $type = 'image';
                    $directory = 'media/images';
                } elseif (str_starts_with($mimeType, 'video/')) {
                    $type = 'video';
                    $directory = 'media/videos';
                } else {
                    $this->addError(
                        'image',
                        'Tipe file tidak didukung.'
                    );
                    return;
                }

                $path = $this->image->store(
                    $directory,
                    'public'
                );

                $storagePath = '/storage/' . $path;

                Media::create([
                    'name' => $this->name ?: \Illuminate\Support\Str::random(10),
                    'file' => $storagePath,
                    'type' => $type,
                    'size' => $this->image->getSize(),
                ]);

                $imageValue = $storagePath;
            }

            break;
            case 'url':
                $imageValue = $this->image_url;
                break;
            case 'media':
                $imageValue = $this->media_id;
                break;
        }

        // 2. Handle Digital Asset File
        $digitalAssetValue = $this->digital_assets;
        if ($this->digital_asset_file) {
            $digitalAssetValue = $this->digital_asset_file->store('digital_assets', 'local'); 
            // Disarankan menggunakan disk 'local' atau 'private' agar tidak bisa diakses publik langsung
        }

        Product::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'image_source' => $this->image_source,
                'image' => $imageValue,
                'digital_assets' => $digitalAssetValue,
                'status' => $this->status,
            ]
        );

        session()->flash(
            'message',
            $this->editMode ? 'Produk berhasil diperbarui' : 'Produk berhasil ditambahkan'
        );

        $this->openModal = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Produk berhasil dihapus');
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->name = null;
        $this->description = null;
        $this->price = null;
        $this->digital_assets = null;
        $this->digital_asset_file = null;
        $this->status = 'active';
        $this->image_source = 'upload';
        $this->image = null;
        $this->image_url = null;
        $this->media_id = null;
        $this->existingImage = null;
        $this->searchMedia = '';
    }

    public function render()
    {
        // Query untuk Produk (Main Pagination)
        $products = Product::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(12, ['*'], 'page'); // Menggunakan pointer default 'page'

        // Query untuk Media Library (Custom Multiple Pagination)
        $mediaItems = Media::query()
            ->when($this->searchMedia, fn ($q) => $q->where('name', 'like', '%' . $this->searchMedia . '%'))
            ->latest()
            ->paginate(8, ['*'], 'mediaPage'); // Menggunakan pointer 'mediaPage' agar tidak tabrakan

        return view('livewire.product.list', [
            'products' => $products,
            'mediaItems' => $mediaItems,
        ]);
    }
}