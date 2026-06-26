<?php

namespace App\Livewire\Admin\LandingPage\Templates;

class LandingPageTemplate
{
    public static function all(): array
    {
        return [
            'authority' => [
                'label' => 'The Authority',
                'description' => 'Produk Digital, Course, Software',
                'sections' => self::authority(),
            ],

            'converter' => [
                'label' => 'The Converter',
                'description' => 'Produk Fisik, Flash Sale',
                'sections' => self::converter(),
            ],

            'service' => [
                'label' => 'The Service',
                'description' => 'Jasa, Agency, Consulting',
                'sections' => self::service(),
            ],
        ];
    }

    public static function get(string $template): array
    {
        return self::all()[$template]['sections'] ?? [];
    }

   protected static function authority(): array
    {
        return [
            [
                'name' => 'Hero',
                'type' => 'script',
                'content' => [
                    'script' => '<!-- height:220 -->
            <style>
            .hero-wrap { padding: 32px 20px; text-align: center; background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%); }
            .hero-badge { display: inline-block; background: #e0e7ff; color: #4338ca; font-size: 11px; font-weight: 600; padding: 4px 14px; border-radius: 99px; margin-bottom: 14px; }
            .hero-title { font-size: 22px; font-weight: 800; color: #1e293b; line-height: 1.35; margin-bottom: 12px; }
            .hero-sub { font-size: 13px; color: #64748b; line-height: 1.6; }
            </style>
            <div class="hero-wrap">
                <span class="hero-badge">🚀 Program 2026</span>
                <h1 class="hero-title">Capai Level Pro dalam<br>30 Hari Tanpa Ribet</h1>
                <p class="hero-sub">Belajar dari nol hingga siap kerja bersama mentor berpengalaman.</p>
            </div>',
                ],
            ],
            [
                'name' => 'Visual',
                'type' => 'video',
                'content' => [
                    'title' => 'Tonton Demo',
                    'video_url' => 'https://youtube.com/embed/xyz',
                ],
            ],
            [
                'name' => 'Benefit',
                'type' => 'script',
                'content' => [
                    'script' => '<!-- height:260 -->
            <style>
            .benefit-wrap { padding: 20px 16px; }
            .benefit-title { font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 14px; }
            .benefit-list { display: flex; flex-direction: column; gap: 10px; }
            .benefit-item { display: flex; align-items: flex-start; gap: 10px; background: #f8fafc; border-radius: 10px; padding: 12px 14px; border: 1px solid #e2e8f0; }
            .benefit-icon { width: 28px; height: 28px; background: #d1fae5; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 14px; }
            .benefit-text { font-size: 13px; color: #334155; font-weight: 500; line-height: 1.5; }
            .benefit-desc { font-size: 11px; color: #94a3b8; margin-top: 2px; }
            </style>
            <div class="benefit-wrap">
                <p class="benefit-title">Mengapa belajar dengan kami?</p>
                <div class="benefit-list">
                    <div class="benefit-item">
                        <div class="benefit-icon">📚</div>
                        <div>
                            <div class="benefit-text">Kurikulum terupdate 2026</div>
                            <div class="benefit-desc">Materi selalu diperbarui mengikuti industri terkini</div>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">💬</div>
                        <div>
                            <div class="benefit-text">Grup diskusi eksklusif</div>
                            <div class="benefit-desc">Komunitas aktif dan mentor siap membantu 24/7</div>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">♾️</div>
                        <div>
                            <div class="benefit-text">Akses lifetime</div>
                            <div class="benefit-desc">Bayar sekali, akses selamanya tanpa biaya tambahan</div>
                        </div>
                    </div>
                </div>
            </div>',
                ],
            ],
            [
                'name' => 'Produk',
                'type' => 'script',
                'content' => [
                    'script' => '<!-- height:280 -->
            <style>
            .prod-wrap { padding: 16px; }
            .prod-card { border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden; background: #fff; }
            .prod-banner { background: linear-gradient(135deg, #6366f1, #8b5cf6); padding: 20px; text-align: center; }
            .prod-banner-title { font-size: 17px; font-weight: 800; color: #fff; margin-bottom: 4px; }
            .prod-banner-sub { font-size: 12px; color: #c7d2fe; }
            .prod-body { padding: 16px; }
            .prod-price { font-size: 22px; font-weight: 800; color: #4338ca; margin-bottom: 4px; }
            .prod-desc { font-size: 12px; color: #64748b; margin-bottom: 14px; }
            .prod-features { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
            .prod-feature { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #334155; }
            .prod-btn { display: block; width: 100%; padding: 12px; background: #6366f1; color: #fff; text-align: center; border-radius: 10px; font-size: 14px; font-weight: 700; border: none; cursor: pointer; }
            </style>
            <div class="prod-wrap">
                <div class="prod-card">
                    <div class="prod-banner">
                        <div class="prod-banner-title">Full Access Pass</div>
                        <div class="prod-banner-sub">Akses seluruh modul dan tool eksklusif</div>
                    </div>
                    <div class="prod-body">
                        <div class="prod-price">Rp 750.000</div>
                        <div class="prod-desc">Bayar sekali, nikmati selamanya.</div>
                        <div class="prod-features">
                            <div class="prod-feature"><span style="color:#22c55e">✓</span> Semua modul video HD</div>
                            <div class="prod-feature"><span style="color:#22c55e">✓</span> Sertifikat resmi</div>
                            <div class="prod-feature"><span style="color:#22c55e">✓</span> Grup mentoring eksklusif</div>
                            <div class="prod-feature"><span style="color:#22c55e">✓</span> Update materi gratis selamanya</div>
                        </div>
                        <button class="prod-btn">Daftar Sekarang</button>
                    </div>
                </div>
            </div>',
                ],
            ],
            [
                'name' => 'Testi',
                'type' => 'script',
                'content' => [
                    'script' => '<!-- height:320 -->
            <style>
            .testi-wrap { padding: 16px; display: flex; flex-direction: column; gap: 12px; }
            .testi-card { background: #f8fafc; border-left: 4px solid #6366f1; border-radius: 8px; padding: 14px 16px; }
            .testi-text { font-size: 14px; color: #334155; font-style: italic; line-height: 1.6; margin-bottom: 8px; }
            .testi-author { font-size: 12px; font-weight: 600; color: #6366f1; }
            </style>
            <div class="testi-wrap">
                <div class="testi-card">
                    <p class="testi-text">"Kurikulum paling lengkap yang pernah saya ikuti. Worth it banget!"</p>
                    <span class="testi-author">— Andi, Web Developer</span>
                </div>
                <div class="testi-card">
                    <p class="testi-text">"Dalam 30 hari saya sudah bisa bikin project sendiri. Mentor-nya juga responsif."</p>
                    <span class="testi-author">— Sari, Fresh Graduate</span>
                </div>
                <div class="testi-card">
                    <p class="testi-text">"Materinya up-to-date dan langsung bisa dipraktikkan. Highly recommended!"</p>
                    <span class="testi-author">— Budi, Freelancer</span>
                </div>
            </div>',
                ],
            ],
            [
                'name' => 'FAQ',
                'type' => 'script',
                'content' => [
                    'script' => '<!-- height:380 -->
            <style>
            .faq-wrap { padding: 16px; display: flex; flex-direction: column; gap: 10px; }
            .faq-title { font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
            .faq-item { background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden; }
            .faq-q { padding: 12px 16px; font-size: 13px; font-weight: 600; color: #1e293b; border-bottom: 1px solid #e2e8f0; background: #fff; }
            .faq-a { padding: 12px 16px; font-size: 13px; color: #475569; line-height: 1.6; }
            </style>
            <div class="faq-wrap">
                <p class="faq-title">Pertanyaan Umum</p>
                <div class="faq-item">
                    <div class="faq-q">Apakah ada sertifikat?</div>
                    <div class="faq-a">Ya, setelah menyelesaikan seluruh modul kamu akan mendapatkan sertifikat resmi yang bisa dicantumkan di LinkedIn.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-q">Berapa lama akses materi?</div>
                    <div class="faq-a">Akses lifetime, tidak ada batas waktu. Kamu bisa mengulang materi kapan saja.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-q">Apakah ada sesi live mentoring?</div>
                    <div class="faq-a">Ada sesi live setiap minggu dan kamu bisa bertanya langsung kepada mentor berpengalaman.</div>
                </div>
            </div>',
                ],
            ],
            [
                'name' => 'CTA',
                'type' => 'button_checkout',
                'content' => [
                    'title' => 'Mulai Belajar',
                    'url' => '#checkout',
                ],
            ],
        ];
    }

    protected static function converter(): array
    {
        return [
            ['name' => 'Hero', 'type' => 'text', 'content' => ['text' => 'Diskon 50% Khusus Hari Ini Saja!', 'font_size' => 'text-5xl', 'is_bold' => true, 'alignment' => 'text-center', 'text_color' => '#dc2626']],
            ['name' => 'Visual', 'type' => 'image', 'content' => ['image_url' => 'product.jpg', 'image_name' => 'Product Banner']],
            ['name' => 'Benefit', 'type' => 'text', 'content' => ['text' => 'Kelebihan Produk Kami:\n- Bahan Premium\n- Garansi 1 Tahun\n- Gratis Ongkir', 'font_size' => 'text-lg']],
            ['name' => 'Produk', 'type' => 'product', 'content' => ['name' => 'Limited Edition Kit', 'price' => 199000, 'description' => 'Stok terbatas.', 'button_text' => 'Beli Sekarang', 'image_url' => '...']],
            ['name' => 'Testi', 'type' => 'script', 'content' => ['script' => '<!-- height:200 --> <div>User Rating: 4.9/5 ★★★★☆</div>']],
            ['name' => 'FAQ', 'type' => 'text', 'content' => ['text' => 'Q: Bisa COD?\nA: Bisa, pilih opsi COD saat checkout.', 'font_size' => 'text-base']],
            ['name' => 'CTA', 'type' => 'button_checkout', 'content' => ['title' => 'Ambil Diskon Anda', 'url' => '#checkout']]
        ];
    }

    protected static function service(): array
    {
        return [
            ['name' => 'Hero', 'type' => 'text', 'content' => ['text' => 'Tingkatkan Performa Bisnis Anda Bersama Kami', 'font_size' => 'text-5xl', 'is_bold' => true, 'alignment' => 'text-center']],
            ['name' => 'Visual', 'type' => 'video', 'content' => ['title' => 'Company Profile', 'video_url' => 'https://youtube.com/abc']],
            ['name' => 'Benefit', 'type' => 'text', 'content' => ['text' => 'Apa yang kami berikan?\n- Analisis data akurat\n- Strategi custom\n- Laporan mingguan', 'font_size' => 'text-lg']],
            ['name' => 'Produk', 'type' => 'product', 'content' => ['name' => 'Consulting Session', 'price' => 1000000, 'description' => 'Sesi eksklusif 60 menit.', 'button_text' => 'Book Sesi', 'image_url' => '...']],
            ['name' => 'Testi', 'type' => 'script', 'content' => ['script' => '<!-- height:200 --> <div>"Hasilnya nyata dalam 1 minggu!"</div>']],
            ['name' => 'FAQ', 'type' => 'text', 'content' => ['text' => 'Q: Berapa lama durasi project?\nA: Tergantung kebutuhan.', 'font_size' => 'text-base']],
            ['name' => 'CTA', 'type' => 'button_checkout', 'content' => ['title' => 'Konsultasi Gratis', 'url' => '#chat']]
        ];
    }
}