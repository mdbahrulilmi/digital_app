<?php

namespace App\Livewire\Admin\LandingPage\Components\Modal;

use Livewire\Component;
use App\Models\LandingPage;
use App\Models\LandingPageSection;
use App\Models\LandingPageComponent;
use App\Traits\SlugGenerator;
use Livewire\WithFileUploads;
use App\Traits\MediaHandler;
use App\Models\Media;
use Livewire\WithPagination;
use App\Livewire\Admin\LandingPage\Templates\LandingPageTemplate;

class LandingPageFormModal extends Component
{
    use SlugGenerator; 
    use WithFileUploads;
    use MediaHandler;
    use WithPagination;

    public $openModal = false;
    public $editMode = false;

    public $pageId;
    public $title;
    public $slug;
    public $description;
    public $status = 'published';
    public $templateType = 'blank';

    public $home = false;
    public $homeExists = false;
    public $cart = false;
    public $blog = false;

    public $program_page_id;
    public $program_id;

    public $image_source = 'upload';
    public $image;
    public $image_url;
    public $media_id;
    public $existingImage;
    public $searchMedia = '';

    public $relation_pages = [];

    protected $listeners = [
        'openLandingPageModal' => 'openModalHandler',
    ];

    public $meta_title;
    public $meta_description;
    public $canonical_url;
    public $robots = 'index,follow';

    public function openModalHandler($mode, $id = null)
    {
        $this->resetFields();

        $this->relation_pages = LandingPage::whereNotNull('program_id')->get();

        if ($mode === 'edit' && $id) {
            $this->editMode = true;

            $page = LandingPage::findOrFail($id);

            $this->pageId = $page->id;
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->description = $page->description;
            $this->status = $page->status;

            $this->home = (bool) $page->home;
            $this->cart = (bool) $page->cart;
            $this->blog = (bool) $page->blog;

            $this->program_page_id = $page->program_page_id;
            $this->program_id = $page->program_id;

            $this->existingImage = $page->image_url;
            $this->image_source = $page->image_source ?? 'upload';

            if ($this->image_source === 'url') {
                $this->image_url = $page->image_url;
            }

            if ($this->image_source === 'media') {
                $this->media_id = $page->image_url;
            }

            $this->meta_title = $page->meta_title;
            $this->meta_description = $page->meta_description;
            $this->canonical_url = $page->canonical_url;
            $this->robots = $page->robots;
        }

        $this->openModal = true;
    }

    public function selectMedia($url)
    {
        $this->image_source = 'media';
        $this->media_id = $url;
    }
    
    public function updatingSearchMedia()
    {
        $this->resetPage('mediaPage');
    }

    public function handleImageSelected($data)
    {
        $this->image_source = $data['type'];

        switch ($data['type']) {

            case 'upload':
                $this->image = $data['data'];
                $this->image_url = null;
                $this->media_id = null;
                break;

            case 'url':
                $this->image_url = $data['data'];
                $this->image = null;
                $this->media_id = null;
                break;

            case 'media':
                $this->media_id = $data['data'];
                $this->image = null;
                $this->image_url = null;
                break;
        }
    }

    public function updatedTitle($value)
    {
        $this->slug = $this->generateUniqueSlug($value, LandingPage::class);
    }

    public function updatedHome($value)
    {
        if ($value) {
            $this->slug = '';
        }
    }

    public function resetFields()
    {
        $this->pageId = null;
        $this->title = '';
        $this->slug = '';
        $this->description = '';
        $this->status = 'published';
        $this->templateType = 'blank';

        $this->home = false;
        $this->cart = false;
        $this->blog = false;

        $this->program_page_id = null;
        $this->program_id = null;

        $this->image = null;
        $this->image_url = null;
        $this->media_id = null;
        $this->existingImage = null;

        $this->meta_title = null;
        $this->meta_description = null;
        $this->canonical_url = null;
        $this->robots = 'index,follow';

        $this->editMode = false;
    }

    public function save()
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'slug' => $this->home ? 'nullable' : 'required|unique:landing_pages,slug,' . $this->pageId,
            'description' => 'required|string',
            'status' => 'required|in:published,draft',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|url',
        ]);

        if ($this->home) {
            $this->slug = '';
        }

        $imageValue = $this->existingImage;

        switch ($this->image_source) {

            case 'upload':
                if ($this->image) {
                    $imageValue = $this->uploadImageAsWebp($this->image);

                    Media::create([
                        'title' => $this->title,
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
        $validated['slug'] = $this->slug;
        $validated['home'] = (bool) $this->home;
        $validated['cart'] = (bool) $this->cart;
        $validated['blog'] = (bool) $this->blog;
        $validated['program_page_id'] = $this->program_page_id ?: null;
        $validated['program_id'] = $this->program_id;
        $validated['image_url'] = $imageValue;
        $validated['image_source'] = $this->image_source;
        $validated['meta_title'] = $this->meta_title;
        $validated['meta_description'] = $this->meta_description;
        $validated['canonical_url'] = $this->canonical_url;
        $validated['robots'] = $this->robots;

        if ($this->home) {
            LandingPage::where('id', '!=', $this->pageId)
                ->update(['home' => 0]);
        }

        if ($this->editMode) {

            $page = LandingPage::findOrFail($this->pageId);
            $page->update($validated);

            $this->syncButtonComponents($page);

            session()->flash('message', 'Halaman berhasil diperbarui.');
        } else {

            $page = LandingPage::create($validated);

            
            if ($this->templateType !== 'blank') {
                $this->generateTemplateSections($page, $this->templateType);
            }

            $this->syncButtonComponents($page);

            session()->flash('message', 'Halaman berhasil dibuat.');

            $this->dispatch('refreshList');

            $this->openModal = false;

            return redirect()->route('landingpage-editor', $page->id);
        }

        $this->resetFields();
        $this->openModal = false;

        $this->dispatch('refreshList');
    }

    protected function syncButtonComponents(LandingPage $page)
    {
        LandingPageComponent::whereHas('section', function ($q) use ($page) {
            $q->where('landing_page_id', $page->id);
        })
        ->where('type', 'button')
        ->get()
        ->each(function ($button) use ($page) {

            $content = $button->content ?? [];

            if ($page->program_page_id) {
                $relatedPage = LandingPage::find($page->program_page_id);

                if ($relatedPage) {
                    $content['url'] = '/' . $relatedPage->slug;
                    $content['url_disabled'] = true;
                }
            } else {
                $content['url_disabled'] = false;
                $content['url'] = '';
            }

            $button->update([
                'content' => $content,
            ]);
        });
    }

    protected function generateTemplateSections($page, $templateType)
    {
        $template = LandingPageTemplate::get($templateType);

        foreach ($template as $sectionIndex => $sectionData) {

            $section = LandingPageSection::create([
                'landing_page_id' => $page->id,
                'name'            => $sectionData['name'],
                'layout'          => $sectionData['layout'] ?? 'stack',
                'sort_order'      => $sectionIndex + 1,
                'is_visible'      => true,
            ]);

            foreach ($sectionData['components'] as $componentIndex => $component) {

                LandingPageComponent::create([
                    'section_id' => $section->id,
                    'type'       => $component['type'],
                    'content'    => $component['content'],
                    'sort_order' => $componentIndex + 1,
                    'is_visible' => true,
                ]);

            }
        }
    }

    public function render()
    {
        $mediaItems = Media::query()
            ->when(
                $this->searchMedia,
                fn ($q) => $q->where('title', 'like', '%' . $this->searchMedia . '%')
            )
            ->latest()
            ->paginate(8, ['*'], 'mediaPage');

        return view('livewire.admin.landing-page.components.modal.landing-page-form-modal', [
            'mediaItems' => $mediaItems,
        ]);
    }
}