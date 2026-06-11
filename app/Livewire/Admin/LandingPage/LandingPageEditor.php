<?php

namespace App\Livewire\Admin\LandingPage;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LandingPage;
use App\Models\Media;
use App\Models\Product;
use App\Models\LandingPageSection;
use App\Livewire\Admin\LandingPage\Components\TextSection;
use App\Livewire\Admin\LandingPage\Components\ButtonSection;
use App\Livewire\Admin\LandingPage\Components\ImageSection;
use App\Livewire\Admin\LandingPage\Components\VideoSection;
use App\Livewire\Admin\LandingPage\Components\ScriptSection;
use App\Livewire\Admin\LandingPage\Components\ProductSection;

class LandingPageEditor extends Component
{
    use WithFileUploads;
    public $landingPageId; 
    public $openComponentModal = false;
    public $openEditModal = false;
    public $editingSectionId = null;
    public $editingSectionName = '';
    public $editingContent = [];

    public $mediaMethod = 'upload';
    public $selectedMediaId;
    public $newFile;
    public $imageFile;
    public $videoFile;

    protected $listeners = ['updateSectionsOrder'];

    public function mount($id)
    {
        $this->landingPageId = $id;
    }

    public function getLandingPageProperty()
    {
        return LandingPage::with(['sections' => function($query) {
            $query->orderBy('sort_order', 'asc');
        }])->find($this->landingPageId);
    }

    public function editContent($sectionId)
    {
        $this->editingSectionId = $sectionId;
        $section = LandingPageSection::findOrFail($sectionId);
        $this->editingSectionName = $section->name;
        $this->editingContent = [];

        switch ($section->type) {
           case 'text':
                $this->editingContent = TextSection::getForm($section);
                break;

            case 'image':
                $this->editingContent = ImageSection::getForm($section);
                break;

            case 'video':
                $this->editingContent = VideoSection::getForm($section);
                break;

            case 'button':
                $this->editingContent = ButtonSection::getForm($section);
            break;
            
            case 'script':
                $this->editingContent = ScriptSection::getForm($section);
            break;
            
            case 'product':
                $this->editingContent = ProductSection::getForm($section);
            break;
            
            case 'product2':
                $this->editingContent = ProductSection::get2Form($section);
            break;


            default:
                $this->editingContent = $section->content ?? [];
        }

        $this->openEditModal = true;    
        $this->mediaMethod = 'upload';
        $this->selectedMediaId = null;
        $this->newFile = null;
    }

    public function saveContent()
    {
        $section = $this->landingPage->sections()->findOrFail($this->editingSectionId);
        $isImage = $section->type === 'image';

        // ==================== JALUR 1: UPLOAD BARU ====================
        if ($this->mediaMethod === 'upload' && $this->newFile) {
            $rules = $isImage ? ['newFile' => 'image|max:2048'] : ['newFile' => 'mimetypes:video/mp4|max:20480'];
            $this->validate($rules);

            $folder = $isImage ? 'images' : 'videos';
            $path = $this->newFile->store('media/' . $folder, 'public');

            $storagePath = '/storage/' . $path;

            $mediaPusat = Media::create([
                'name' => $this->newFile->getClientOriginalName(),
                'file' => $storagePath,
                'type' => $this->newFile->getMimeType(),
                'size' => round($this->newFile->getSize() / 1024),
            ]);

            $this->editingContent[$isImage ? 'image_url' : 'video_url'] = $storagePath;
        }

        // ==================== JALUR 2: AMBIL DARI LIBRARY ====================
        elseif ($this->mediaMethod === 'library' && $this->selectedMediaId) {
            $media = Media::find($this->selectedMediaId);
            if ($media) {
                $this->editingContent[$isImage ? 'image_url' : 'video_url'] = $media->file;
            }
        }

        if ($section->type === 'product') {
            $this->editingContent = ProductSection::mutateBeforeSave($this->editingContent);
        }
        
        if ($section->type === 'product2') {
            $res = $this->editingContent = ProductSection::mutateBeforeSave2($this->editingContent);
        }

        // ==================== PROSES UPDATE AKHIR ====================
        $section->update([
            'content' => $this->editingContent,
             'name' => Str::limit(
                strip_tags(
                    $this->editingContent['text']
                    ?? $this->editingContent['title']
                    ?? ucfirst($section->type)
                ),
                35,
                '...'
            ),
            ]);

        $this->openEditModal = false;
        $this->landingPage->load('sections');
        $this->newFile = null;
        $this->selectedMediaId = null;
    }

    public function toggleVisibility($sectionId)
    {
        $section = LandingPageSection::where('landing_page_id', $this->landingPageId)->find($sectionId);
        if ($section) {
            $section->update([
                'is_visible' => !$section->is_visible
            ]);
        }
    }

    public function deleteSection($sectionId)
    {
        $section = LandingPageSection::where('landing_page_id', $this->landingPageId)->find($sectionId);
        if ($section) {
            $section->delete();
            $this->reorderSections();
        }
    }

    public function addSection($type)
    {
        $names = [
            'text' => 'Teks',
            'image' => 'Gambar',
            'video' => 'Video',
            'button' => 'Tombol',
            'product' => 'Produk',
            'product2' => 'Produk Grid',
            'script' => 'script',
        ];

        $nextOrder = LandingPageSection::where('landing_page_id', $this->landingPageId)->max('sort_order') + 1;

        $defaultContent = match($type) {
            'text' => ['text' => 'Ketik teks narasi Anda di sini.'],
            'video' => ['title' => 'Tonton Video Kami', 'video_url' => ''],
            'button' => ['title' => 'Tombol'],
            'product' => ProductSection::getDefault(),
            'product2' => ProductSection::get2Default(),
            'script' => ['script' => ''],
            default => []
        };

        LandingPageSection::create([
            'landing_page_id' => $this->landingPageId,
            'name' => $names[$type] ?? 'Seksi Baru',
            'type' => $type,
            'sort_order' => $nextOrder,
            'is_visible' => true,
            'content' => $defaultContent
        ]);

        $this->openComponentModal = false;
    }

    public function updateSectionsOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            LandingPageSection::where('landing_page_id', $this->landingPageId)
                ->where('id', $id)
                ->update(['sort_order' => $index + 1]);
        }
    }

    private function reorderSections()
    {
        $sections = LandingPageSection::where('landing_page_id', $this->landingPageId)->orderBy('sort_order', 'asc')->get();
        foreach ($sections as $index => $section) {
            $section->update(['sort_order' => $index + 1]);
        }
    }

    public function render()
    {
        return view('livewire.landing-page.editor', [
            'landingPage' => $this->landingPage,
            'mediaItems' => Media::latest()->get(),
            'products' => Product::latest()->get()
        ]);
    }
}