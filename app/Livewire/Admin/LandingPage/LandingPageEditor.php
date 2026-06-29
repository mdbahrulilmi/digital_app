<?php

namespace App\Livewire\Admin\LandingPage;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

use Illuminate\Support\Str;

use App\Models\LandingPage;
use App\Models\Media;
use App\Models\LandingPageSection;
use App\Models\LandingPageComponent;

use App\Traits\MediaHandler;

use App\Livewire\Admin\LandingPage\Components\ButtonSection;
use App\Livewire\Admin\LandingPage\Components\TextSection;
use App\Livewire\Admin\LandingPage\Components\ImageSection;
use App\Livewire\Admin\LandingPage\Components\VideoSection;
use App\Livewire\Admin\LandingPage\Components\SpacerSection;

class LandingPageEditor extends Component
{
    use WithFileUploads;
    use MediaHandler;

    public $landingPageId;

    /* ================= MODAL STATE ================= */
    public $openSectionModal = false;
    public $openComponentModal = false;

    public $openEditPanel = false;

    /* ================= EDIT STATE ================= */
    public $targetSectionId = null;

    public $selectedComponentId = null;
    public $editingType = null;
    public $editingContent = [];

    /* ================= UI STATE (WAJIB ADA) ================= */
    public $mediaMethod = 'upload';
    public $selectedMediaId = null;
    public $newFile = null;

    public $mediaItems = [];
    public $products = [];
    public $programs = [];

    public function mount($id)
    {
        $this->landingPageId = $id;
        $this->mediaItems = Media::all();
    }

    /* ================= LANDING PAGE ================= */
    public function getLandingPageProperty()
    {
        return LandingPage::with('sections.components')
            ->findOrFail($this->landingPageId);
    }

    #[On('section-sorted')]
    public function sectionSorted($order)
    {
        foreach ($order as $item) {

            LandingPageSection::where('id', $item['id'])
                ->update([
                    'sort_order' => $item['sort']
                ]);

        }

        $this->landingPage->refresh()->load('sections.components');
    }

    #[On('component-sorted')]
    public function componentSorted($sectionId, $order)
    {
        foreach ($order as $item) {

            LandingPageComponent::where('id', $item['id'])
                ->update([
                    'sort_order' => $item['sort']
                ]);

        }

        $this->landingPage->refresh();
    }

    /* ================= SECTION ================= */
    public function showSectionModal()
    {
        $this->openSectionModal = true;
    }

    public function createSection($layout)
    {
        $nextOrder = LandingPageSection::where('landing_page_id', $this->landingPageId)
            ->max('sort_order') + 1;

        LandingPageSection::create([
            'landing_page_id' => $this->landingPageId,
            'name' => 'Section Baru',
            'layout' => $layout,
            'sort_order' => $nextOrder,
            'is_visible' => true,
        ]);

        $this->openSectionModal = false;
    }

    public function deleteSection($id)
    {
        LandingPageSection::findOrFail($id)->delete();
    }

    /* ================= COMPONENT ================= */
    public function showComponentModal($sectionId)
    {
        $this->targetSectionId = $sectionId;
        $this->openComponentModal = true;
    }

    public function createComponent($type)
    {
        $nextOrder = LandingPageComponent::where('section_id', $this->targetSectionId)
            ->max('sort_order') + 1;

        $default = match ($type) {
            'text' => ['text' => 'Teks...'],
            'image' => ['url' => ''],
            'video' => ['url' => ''],
            'button' => [
                'text' => 'Klik',
                'url' => '#',
                'bg_color' => '#4f46e5',
                'text_color' => '#ffffff',
                'font_size' => '14px',
                'radius' => '8px',
                'padding_y' => 10,
                'padding_x' => 20,
                'alignment' => 'center',
                ],
            'spacer' => ['height' => 40],
            default => []
        };

        LandingPageComponent::create([
            'section_id' => $this->targetSectionId,
            'type' => $type,
            'content' => $default,
            'sort_order' => $nextOrder,
            'is_visible' => true,
        ]);

        $this->openComponentModal = false;
    }

    public function toggleComponent($id)
    {
        $c = LandingPageComponent::findOrFail($id);
        $c->update(['is_visible' => !$c->is_visible]);
    }

    public function deleteComponent($id)
    {
        LandingPageComponent::findOrFail($id)->delete();
    }

    /* ================= EDIT COMPONENT ================= */
    public function editComponent($id)
    {
        $c = LandingPageComponent::findOrFail($id);

        $this->selectedComponentId = $id;
        $this->editingType = $c->type;

        $this->editingContent = match ($c->type) {
            'button' => ButtonSection::getForm($c),
            'text'   => TextSection::getForm($c),
            'image'  => ImageSection::getForm($c),
            'video'  => VideoSection::getForm($c),
            'spacer' => SpacerSection::getForm($c),
            default  => $c->content ?? [],
        };

        $this->mediaMethod = 'upload';
        $this->selectedMediaId = null;
        $this->newFile = null;

        $this->openEditPanel = true;
    }

    public function saveComponent()
    {
        $c = LandingPageComponent::findOrFail($this->selectedComponentId);

        if ($c->type === 'image') {

            switch ($this->mediaMethod) {

                case 'upload':

                    if ($this->newFile) {

                        $path = $this->uploadImageAsWebp($this->newFile);

                        Media::create([
                            'title' => Str::random(10),
                            'file'  => $path,
                            'type'  => 'image',
                            'size'  => $this->newFile->getSize(),
                        ]);

                        $this->editingContent['image_url'] = $path;
                    }

                    break;

                case 'library':

                    if ($this->selectedMediaId) {

                        $media = Media::find($this->selectedMediaId);

                        if ($media) {
                            $this->editingContent['image_url'] = $media->file;
                        }
                    }

                    break;

                case 'url':
                    break;
            }
        }

        $c->update([
            'content' => $this->editingContent,
        ]);

        $this->openEditPanel = false;
    }

    /* ================= RENDER ================= */
    public function render()
    {
        return view('livewire.admin.landing-page.editor', [
            'landingPage' => $this->landingPage,
            'mediaItems' => $this->mediaItems,
            'products' => $this->products,
            'programs' => $this->programs,
        ])->layout('layouts.app', [
            'padding' => 'p-0',
            ]);
    }
}