<?php

namespace App\Livewire\Admin\LandingPage;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LandingPage;
use App\Models\Program;

class LandingPageList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    public $openModal = false;
    public $editMode = false;
    
    public $pageId;
    public $title;
    public $slug;
    public $description;
    public $status = 'published';
    public $templateType = 'blank';
    public $home = false; 
    public $cart = false; 
    public $blog = false;
    public $homeExists = false;

    public $program_page_id;
    public $program_id;

    public function mount() {
        $this->checkHomeStatus();
    }

    public function checkHomeStatus()
    {
        $this->homeExists = LandingPage::where('home', true)
            ->when($this->pageId, function($query) {
                $query->where('id', '!=', $this->pageId);
            })
            ->exists();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->pageId = null;
        $this->title = '';
        $this->slug = '';
        $this->description = '';
        $this->status = 'published';
        $this->templateType = 'blank';
        $this->product_id = null;
        $this->program_page_id = null;
    }

    public function create()
    {
        $this->resetFields();
        $this->checkHomeStatus();
        $this->editMode = false;
        $this->openModal = true;
    }

    public function edit($id)
    {
        $this->checkHomeStatus();
        $this->resetFields();
        $page = LandingPage::findOrFail($id);
        $this->program_id = $page->program_id;
        $this->program_page_id = $page->program_page_id;
        $this->pageId = $page->id;
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->description = $page->description;
        $this->cart = $page->cart ? 1 : 0;
        $this->blog = $page->blog ? 1 : 0;
        $this->home = $page->home ? 1 : 0;
        $this->status = $page->status;
        $this->editMode = true;
        $this->openModal = true;
    }

    public function save()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => $this->home ? 'nullable' : 'required|unique:landing_pages,slug,' . $this->pageId,
            'description' => 'required|string',
            'status' => 'required|in:published,draft',
            'templateType' => 'nullable',
            'home' => 'nullable',
            'cart' => 'nullable',
            'blog' => 'nullable',
        ];

        if ($this->home) {
            $this->slug = ''; 
        }

        $validatedData = $this->validate($rules);

        $validatedData['home'] = $this->home ? 1 : 0;
        $validatedData['cart'] = $this->cart ? 1 : 0;
        $validatedData['blog'] = $this->blog ? 1 : 0;

        $this->home = $this->home ? 1 : 0;
        $this->cart = $this->cart ? 1 : 0;
        $this->blog = $this->blog ? 1 : 0;

        $validatedData['program_page_id'] = $this->program_page_id ?: null;

        if ($this->home == 1) {
            LandingPage::where('id', '!=', $this->pageId)
                ->update(['home' => 0]);
        }

        if ($this->editMode) {
            $page = LandingPage::findOrFail($this->pageId);
            unset($validatedData['templateType']); 
            
            $page->update($validatedData);
            session()->flash('message', 'Halaman berhasil diperbarui.');
        } else {
            $selectedTemplate = $this->templateType;
            unset($validatedData['templateType']);

            $page = LandingPage::create($validatedData);

            $this->generateTemplateSections($page, $selectedTemplate);

            session()->flash('message', 'Halaman baru beserta template berhasil ditambahkan.');
            
            return redirect()->route('landingpage-editor', $page->id); 
        }

        $this->openModal = false;
        $this->resetFields();
    }

    public function delete($id)
    {
        LandingPage::findOrFail($id)->delete();
        session()->flash('message', 'Halaman berhasil dihapus.');
    }

    public function render()
    {
        $pages = LandingPage::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->whereNull('program_id')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.landing-page.list', [
            'pages' => $pages,
            'program_pages' => LandingPage::whereNotNull('program_id')->paginate(10),
            'relation_pages' => LandingPage::whereNotNull('program_id')->get(),
        ]);
    }
    public function updatedIsHome($value)
    {
        if ($value) {
            $this->slug = '';
        }
    }


   protected function generateTemplateSections($page, $templateType)
    {
        $sections = [];

        if ($templateType === 'checkout') {
            $sections = [
                [
                    'name' => 'Banner Header Produk',
                    'type' => 'image',
                    'content' => ['image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500', 'image_name' => 'Header Checkout'],
                ],
                [
                    'name' => 'Detail Deskripsi Produk',
                    'type' => 'text',
                    'content' => ['text' => 'Smartwatch Minimalis v2. Dapatkan diskon potongan harga sebesar 50% khusus pemesanan hari ini saja. Garansi resmi distributor selama 1 tahun.'],
                ],
                [
                    'name' => 'Tombol Ambil Promo',
                    'type' => 'button',
                    'content' => ['title' => 'BELI SEKARANG (DISKON 50%)', 'url' => '#checkout-form'],
                ]
            ];
        } elseif ($templateType === 'landing_page') {
            $sections = [
                [
                    'name' => 'Hero Bisnis Utama',
                    'type' => 'text',
                    'content' => ['text' => 'Tingkatkan Omset Bisnis Anda 10x Lipat. Gunakan ekosistem manajemen digital cerdas untuk memantau performa penjualan produk secara otomatis dan terukur.'],
                ],
                [
                    'name' => 'Video Review Layanan',
                    'type' => 'video',
                    'content' => ['title' => 'Simak Cara Kerja Platform Kami', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'],
                ],
                [
                    'name' => 'CTA Daftar Akun',
                    'type' => 'button',
                    'content' => ['title' => 'Mulai Konsultasi Gratis Sekarang', 'url' => '/register'],
                ]
            ];
        } 
        // 🔥 TEMPLATE PRODUCT PAGE - LANGSUNG DIISI KONTENNYA
        elseif ($templateType === 'product_page') {
            $sections = [
                [
                    'name' => 'Judul Promo Produk',
                    'type' => 'text',
                    'content' => [
                        'text' => 'Katalog Produk Unggulan Kami',
                        'font_family' => 'font-sans',
                        'font_size' => 'text-2xl',
                        'line_height' => 'leading-snug',
                        'is_bold' => true,
                        'is_italic' => false,
                        'is_underline' => false,
                        'alignment' => 'text-center',
                        'text_color' => '#1e293b',
                    ]
                ],
                [
                    'name' => 'Produk Utama (Single)',
                    'type' => 'product', 
                    'content' => [
                        'name' => 'Smartwatch Premium X1 Pro',
                        'price' => 1500000,
                        'description' => 'Gadget canggih dengan pelacak kesehatan real-time, monitor detak jantung, dan baterai tangguh yang tahan hingga 14 hari pemakaian aktif.',
                        'button_text' => 'Masukkan Keranjang',
                        'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',
                        'badge' => 'Terlaris',
                        'font_family' => 'font-sans',
                        'alignment' => 'text-left',
                        'text_color' => '#1e293b',
                        'price_color' => '#4f46e5',
                        'btn_bg_color' => '#4f46e5',
                        'btn_text_color' => '#ffffff',
                    ]
                ],
                [
                    'name' => 'Sub-judul Paket Bundling',
                    'type' => 'text',
                    'content' => [
                        'text' => 'Pilih Paket Hemat Bundling (Isi 2)',
                        'font_family' => 'font-sans',
                        'font_size' => 'text-xl',
                        'line_height' => 'leading-normal',
                        'is_bold' => true,
                        'is_italic' => false,
                        'is_underline' => false,
                        'alignment' => 'text-center',
                        'text_color' => '#1e293b',
                    ]
                ],
                [
                    'name' => 'Paket Bundling (Double)',
                    'type' => 'product2',
                    'content' => [
                        'name_1' => 'Smartwatch Black Midnight',
                        'price_1' => 1350000,
                        'description_1' => 'Desain sport tangguh dengan strap silikon hitam solid yang maskulin.',
                        'image_url_1' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',
                        'button_url_1' => '#',

                        'name_2' => 'Smartwatch Silver Luxury',
                        'price_2' => 1350000,
                        'description_2' => 'Balutan warna perak chrome elegan yang cocok untuk acara formal Anda.',
                        'image_url_2' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',
                        'button_url_2' => '#',

                        'button_text' => 'Beli Paket Bundling',
                        'badge' => 'Promo Hemat',
                        'font_family' => 'font-sans',
                        'alignment' => 'text-center',
                        'text_color' => '#1e293b',
                        'price_color' => '#e11d48', 
                        'btn_bg_color' => '#10b981', 
                        'btn_text_color' => '#ffffff',
                    ]
                ]
            ];
        }

        foreach ($sections as $index => $sectionData) {
            \App\Models\LandingPageSection::create([
                'landing_page_id' => $page->id,
                'name'            => $sectionData['name'],
                'type'            => $sectionData['type'],
                'sort_order'      => $index + 1,
                'is_visible'      => true,
                'content'         => $sectionData['content']
            ]);
        }
    }
}