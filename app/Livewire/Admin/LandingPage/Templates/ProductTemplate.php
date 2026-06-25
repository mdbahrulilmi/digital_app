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