<?php

namespace App\Livewire\Admin\Product;

use App\Models\Media;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\SlugGenerator;
use App\Traits\MediaHandler;
use App\Traits\LandingPageHandler;

class ProductList extends Component
{
    use WithPagination, WithFileUploads, SlugGenerator, MediaHandler, LandingPageHandler;

    public $search = '';
    public $filterStatus = '';

    public $searchMedia = '';

    public $openModal = false;
    public $editMode = false;
    public $editingId = null;

    public $title;
    public $slug;
    public $description;
    public $price;
    public $status = 'active';

    public $asset_source = 'upload';
    public $digital_assets;
    public $digital_asset_file;
    public $digital_asset_url;
    public $asset_type;

    public $image_source = 'upload';
    public $image;
    public $image_url;
    public $media_id;
    public $existingImage;

    protected function rules()
{
    return [
        'title'              => ['required', 'string', 'max:255'],
        'description'        => ['required', 'string'],
        'asset_type'         => ['required'],
        'slug'               => ['required', 'string', 'unique:products,slug,' . ($this->editingId ?? 'NULL')],
        'price'              => ['required', 'numeric', 'min:0'],
        'status'             => ['required'],
        'image'              => ['nullable', 'image', 'max:2048', 'required_without:image_url'],
        'image_url'          => ['nullable', 'url', 'required_without:image'],
        'asset_type'         => [
            'required_if:asset_source,upload', 
            'required_if:asset_source,link', 
            'in:file,video,audio,image'
        ],
        'digital_asset_file' => $this->asset_source === 'upload' 
            ? ['nullable', 'file'] 
            : ['nullable'],
            
        'digital_asset_url'  => $this->asset_source === 'link' 
            ? ['required', 'url'] 
            : ['nullable'],
    ];
}

    public function updatedTitle($value)
    {
        $this->slug = $this->generateUniqueSlug($value, Product::class);
    }

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
        $this->title = $product->title;
        $this->asset_source = $product->asset_source ?? 'upload';
        $this->asset_type = $product->type;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->digital_assets = $product->digital_assets;

        $asset = is_array($product->digital_assets)
            ? $product->digital_assets
            : json_decode($product->digital_assets, true);

        if ($this->asset_source === 'link') {
            $this->digital_asset_url = $asset['url'] ?? '';
        }
        
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
        $this->media_id = $url;
    }

    public function save()
    {
        $this->validate();

        $imageValue = $this->existingImage;

        switch ($this->image_source) {
        case 'upload':
            if ($this->image) {
                $imageValue = $this->uploadImageAsWebp($this->image);
                Media::create([
                    'title' => $this->title ?: \Illuminate\Support\Str::random(10),
                    'file'  => $imageValue,
                    'type'  => 'image',
                    'size'  => $this->image->getSize(),
                ]);
            }
            break;
        case 'url':
            $imageValue = $this->image_url;
            break;
        case 'media':
            $imageValue = $this->media_id;
            break;
        }

        $digitalAssetValue = $this->digital_assets;

        if ($this->asset_source === 'upload' && $this->digital_asset_file) {
            $file = $this->digital_asset_file;
            $path = $file->store('digital_assets', 'public');
            
            $extension = $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();
            
            $digitalAssetValue = json_encode([
                'name' => $name,
                'path' => $path,
                'type' => strtolower($extension),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }

        elseif ($this->asset_source === 'link' && $this->digital_asset_url) {
            $digitalAssetValue = json_encode([
                'type' => 'link',
                'url'  => $this->digital_asset_url,
            ]);
        }

        Product::updateOrCreate(
            ['id' => $this->editingId],
            [
                'title' => $this->title,
                'slug' => $this->slug,
                'type' => $this->asset_type,
                'description' => $this->description,
                'price' => $this->price,
                'image_source' => $this->image_source,
                'asset_source' => $this->asset_source,
                'image' => $imageValue,
                'digital_assets' => $digitalAssetValue,
                'status' => $this->status,
            ]
        );

        if ($this->editMode) {
            $newData = [
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'price' => $this->price,
                'image' => $imageValue
            ];

           $this->updateLandingPageComponents(['product', 'product2'], [
            [
                'id_key'         => 'product_id', 
                'title_key'      => 'title', 
                'slug_key'       => 'slug', 
                'desc_key'       => 'description', 
                'price_key'      => 'price', 
                'image_key'      => 'image_url'
            ],
            [
                'id_key'         => 'product_id_1', 
                'title_key'      => 'title_1', 
                'slug_key'       => 'slug_1', 
                'desc_key'       => 'description_1', 
                'price_key'      => 'price_1', 
                'image_key'      => 'image_url_1'
            ],
            [
                'id_key'         => 'product_id_2', 
                'title_key'      => 'title_2', 
                'slug_key'       => 'slug_2', 
                'desc_key'       => 'description_2', 
                'price_key'      => 'price_2', 
                'image_key'      => 'image_url_2'
            ]
        ], $this->editingId, $newData);
        }

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
        $this->title = null;
        $this->slug = null;
        $this->description = null;
        $this->price = null;
        $this->digital_assets = null;
        $this->digital_asset_file = null;
        $this->digital_asset_url = null;
        $this->asset_source = 'upload';
        $this->asset_type = null;
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
        $products = Product::query()
            ->when($this->search, fn ($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(12, ['*'], 'page');

        $mediaItems = Media::query()
            ->when($this->searchMedia, fn ($q) => $q->where('title', 'like', '%' . $this->searchMedia . '%'))
            ->latest()
            ->paginate(8, ['*'], 'mediaPage');

        return view('livewire.admin.product.list', [
            'products' => $products,
            'mediaItems' => $mediaItems,
        ]);
    }
}