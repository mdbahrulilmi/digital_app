<?php

namespace App\Livewire\Admin\Program;

use App\Models\Program;
use App\Models\LandingPage;
use App\Models\Product;
use App\Models\Media;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\SlugGenerator;
use App\Traits\MediaHandler;
use App\Traits\LandingPageHandler;

class ProgramList extends Component
{
    use WithPagination, WithFileUploads, SlugGenerator, MediaHandler, LandingPageHandler;

    public $openModal = false;
    public $editMode = false;
    public $editingId = null;
    
    public $search = '';
    public $searchMedia = '';
    public $filterHasProducts = '';

    public $title;     
    public $slug;
    public $description;
    public $start_date;
    public $end_date;
    public $price;
    public $status;


    public $image_source = 'upload';
    public $image;
    public $image_url;
    public $media_id;
    public $existingImage;

    public $selectedProducts = [];

    protected function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required','string', 'unique:programs,slug,' . ($this->editingId ?? 'NULL')],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'image' => ['nullable', 'image', 'max:2048'],
            'image_url' => ['nullable', 'url']
        ];
    }

    public function updatedTitle($value)
    {
        $this->slug = $this->generateUniqueSlug($value, Program::class);
    }

    public function updatingSearch() 
    { 
        $this->resetPage(); 
    }

    public function updatingSearchMedia() 
    { 
        $this->resetPage('mediaPage'); 
    }

    public function create() {
        $this->resetForm();
        $this->openModal = true;
    }

    public function edit($id) {
        $this->resetForm();
        $program = Program::with('products')->findOrFail($id);
        
        $this->editingId = $program->id;
        $this->title = $program->title;
        $this->slug = $program->slug;
        $this->price = $program->price;
        $this->description = $program->description;
        $this->start_date = $program->start_date;
        $this->end_date = $program->end_date;
        $this->status = $program->status;
        
        $this->image_source = $program->image_source ?? 'upload';
        $this->existingImage = $program->image;

        if ($this->image_source === 'url') $this->image_url = $program->image;
        if ($this->image_source === 'media') $this->media_id = $program->image;

        $this->selectedProducts = $program->products->pluck('id')->toArray();
        $this->editMode = true;
        $this->openModal = true;
    }

    public function selectMedia($url) {
        $this->media_id = $url;
    }

    public function save() {
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

        $program = Program::updateOrCreate(
            ['id' => $this->editingId],
            [
                'title' => $this->title,
                'slug' => $this->slug,
                'price' => $this->price,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status,
                'image' => $imageValue,
                'image_source' => $this->image_source,
            ]
        );

        if (!$this->editMode) {
            LandingPage::create([
                'title'       => $this->title,
                'slug'        => $this->slug,
                'description' => 'Program ' . $this->title,
                'status'      => 'published',
                'program_id'  => $program->id,
            ]);
        }
        
        if ($this->editMode) {
            $newData = [
                'title'       => $this->title,
                'slug'        => $this->slug,
                'description' => $this->description,
                'price'       => $this->price,
                'image'       => $imageValue,
                'start_date'  => $this->start_date,
                'end_date'    => $this->end_date,
            ];

            $this->updateLandingPageSections(['program', 'program2'], [
            [
                'id_key'         => 'program_id', 
                'title_key'      => 'title', 
                'slug_key'       => 'slug', 
                'desc_key'       => 'description', 
                'price_key'      => 'price', 
                'image_key'      => 'image_url', 
                'start_date_key' => 'start_date', 
                'end_date_key'   => 'end_date'
            ],
            [
                'id_key'         => 'program_id_1', 
                'title_key'      => 'title_1', 
                'slug_key'       => 'slug_1', 
                'desc_key'       => 'description_1', 
                'price_key'      => 'price_1', 
                'image_key'      => 'image_url_1',
                'start_date_key' => 'start_date_1',
                'end_date_key'   => 'end_date_1'
            ],
            [
                'id_key'         => 'program_id_2', 
                'title_key'      => 'title_2', 
                'slug_key'       => 'slug_2', 
                'desc_key'       => 'description_2', 
                'price_key'      => 'price_2', 
                'image_key'      => 'image_url_2',
                'start_date_key' => 'start_date_2',
                'end_date_key'   => 'end_date_2'
            ]
        ], $this->editingId, $newData);
        }

        session()->flash('message', $this->editMode ? 'Program diperbarui!' : 'Program ditambahkan!');
        $this->openModal = false;
        $this->resetForm();
    }

    public function resetForm() {
        $this->editingId = null;
        $this->title = null;
        $this->slug =  null;
        $this->price = null; 
        $this->description = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->status = 'active';
        $this->image = $this->image_url = $this->existingImage = null;
        $this->image_source = 'upload';
        $this->media_id = null;
        $this->selectedProducts = [];
        $this->searchMedia = '';
        $this->editMode = false;
    }

    public function delete($id)
    {
        $program = Program::findOrFail($id);
        LandingPage::where('program_id', $id)->delete();
        $program->delete();
        session()->flash('message', 'Produk berhasil dihapus');
    }

    public function render() 
    {
        $query = Program::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->filterHasProducts === 'with_products', fn($q) => $q->has('products'))
            ->when($this->filterHasProducts === 'no_products', fn($q) => $q->doesntHave('products'));

        $mediaItems = Media::query()
            ->when($this->searchMedia, fn ($q) => $q->where('name', 'like', '%' . $this->searchMedia . '%'))
            ->latest()
            ->paginate(8, ['*'], 'mediaPage');

        return view('livewire.admin.program.list', [
            'programs' => $query->latest()->paginate(12),
            'allProducts' => Product::all(),
            'mediaItems' => $mediaItems
        ]);
    }
}