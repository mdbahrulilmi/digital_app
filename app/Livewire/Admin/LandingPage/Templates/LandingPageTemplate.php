<?php

namespace App\Livewire\Admin\LandingPage\Templates;

class LandingPageTemplate
{
    public static function all(): array
    {
        return [
            'basic' => [
                'label' => 'Basic',
                'description' => 'Produk Digital, Course, Software',
                'sections' => self::basic(),
            ],
        ];
    }

    public static function get(string $template): array
    {
        return self::all()[$template]['sections'] ?? [];
    }

    protected static function basic(): array
    {
        return [

            // 1. HERO
            ['name' => 'Hero', 'layout' => 'col-1', 'components' => [
                ['type' => 'spacer', 'content' => ['height' => 30]],

                ['type' => 'text', 'content' => [
                    'text'       => '🚀 Program Akselerasi Karir 2026',
                    'font_size'  => 'text-xs',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#818cf8',
                ]],

                ['type' => 'spacer', 'content' => ['height' => 8]],

                ['type' => 'text', 'content' => [
                    'text'       => 'Kuasai Skill Level Pro dalam 30 Hari',
                    'font_size'  => 'text-4xl',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#0f172a',
                ]],

                ['type' => 'text', 'content' => [
                    'text'       => 'Tanpa teori berbelit. Langsung praktek, langsung bisa, langsung kerja.',
                    'font_size'  => 'text-sm',
                    'alignment'  => 'text-center',
                    'text_color' => '#64748b',
                ]],

                ['type' => 'spacer', 'content' => ['height' => 10]],

                ['type' => 'video', 'content' => [
                    'video_url' => 'https://www.youtube.com/embed/Q51l8zE1m4Q',
                ]],

                ['type' => 'spacer', 'content' => ['height' => 10]],

                ['type' => 'button', 'content' => [
                    'text'       => 'Mulai Transformasi Sekarang →',
                    'url'        => '#cta',
                    'bg_color'   => '#4f46e5',
                    'text_color' => '#ffffff',
                    'radius'     => '10px',
                    'padding_y'  => 14,
                    'padding_x'  => 36,
                    'alignment'  => 'center',
                    'shadow'     => true,
                ]],
            ]],

            // 2. FEATURES
            ['name' => 'Features', 'layout' => 'col-1', 'components' => [
                ['type' => 'spacer', 'content' => ['height' => 30]],

                ['type' => 'text', 'content' => [
                    'text'       => 'KURIKULUM',
                    'font_size'  => 'text-xs',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#94a3b8',
                ]],

                ['type' => 'text', 'content' => [
                    'text'       => 'Berbasis Real-World Project',
                    'font_size'  => 'text-3xl',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#0f172a',
                ]],

                ['type' => 'text', 'content' => [
                    'text'       => 'Setiap materi langsung diimplementasikan ke project nyata yang bisa masuk portfolio.',
                    'font_size'  => 'text-sm',
                    'alignment'  => 'text-center',
                    'text_color' => '#64748b',
                ]],

                ['type' => 'spacer', 'content' => ['height' => 10]],

                ['type' => 'image', 'content' => [
                    'image_url' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=1200',
                ]],

                ['type' => 'spacer', 'content' => ['height' => 30]],
            ]],

            // 3. BENEFITS col-3
            ['name' => 'Benefits', 'layout' => 'col-3', 'components' => [
                ['type' => 'image', 'content' => [
                    'image_url' => 'https://cdn-icons-png.flaticon.com/128/3135/3135768.png',
                ]],
                ['type' => 'image', 'content' => [
                    'image_url' => 'https://cdn-icons-png.flaticon.com/128/2697/2697664.png',
                ]],
                ['type' => 'image', 'content' => [
                    'image_url' => 'https://cdn-icons-png.flaticon.com/128/3004/3004613.png',
                ]],

                ['type' => 'text', 'content' => [
                    'text'       => 'Coding Intensif',
                    'font_size'  => 'text-xs',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#1e293b',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => '1-on-1 Mentor',
                    'font_size'  => 'text-xs',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#1e293b',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => 'Job Connect',
                    'font_size'  => 'text-xs',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#1e293b',
                ]],

                ['type' => 'text', 'content' => [
                    'text'       => 'Praktek setiap hari, tanpa jeda.',
                    'font_size'  => 'text-xs',
                    'alignment'  => 'text-center',
                    'text_color' => '#64748b',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => 'Senior dev berpengalaman 5+ tahun.',
                    'font_size'  => 'text-xs',
                    'alignment'  => 'text-center',
                    'text_color' => '#64748b',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => 'Network ke 200+ perusahaan.',
                    'font_size'  => 'text-xs',
                    'alignment'  => 'text-center',
                    'text_color' => '#64748b',
                ]],
            ]],

            // 4. TECH STACK
            ['name' => 'TechStack', 'layout' => 'col-1', 'components' => [
                ['type' => 'spacer', 'content' => ['height' => 30]],

                ['type' => 'text', 'content' => [
                    'text'       => 'TECH STACK YANG KAMU KUASAI',
                    'font_size'  => 'text-xs',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#94a3b8',
                ]],

                ['type' => 'spacer', 'content' => ['height' => 10]],
            ]],

            ['name' => 'TechStackIcons', 'layout' => 'col-3', 'components' => [
                ['type' => 'image', 'content' => [
                    'image_url' => 'https://cdn-icons-png.flaticon.com/128/919/919827.png',
                ]],
                ['type' => 'image', 'content' => [
                    'image_url' => 'https://cdn-icons-png.flaticon.com/128/5968/5968292.png',
                ]],
                ['type' => 'image', 'content' => [
                    'image_url' => 'https://cdn-icons-png.flaticon.com/128/919/919825.png',
                ]],

                ['type' => 'text', 'content' => [
                    'text'       => 'HTML5',
                    'font_size'  => 'text-xs',
                    'alignment'  => 'text-center',
                    'text_color' => '#64748b',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => 'JavaScript',
                    'font_size'  => 'text-xs',
                    'alignment'  => 'text-center',
                    'text_color' => '#64748b',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => 'Node.js',
                    'font_size'  => 'text-xs',
                    'alignment'  => 'text-center',
                    'text_color' => '#64748b',
                ]],
            ]],

            // 5. TESTIMONIALS
            ['name' => 'Testimonials', 'layout' => 'col-1', 'components' => [
                ['type' => 'spacer', 'content' => ['height' => 30]],

                ['type' => 'text', 'content' => [
                    'text'       => 'ALUMNI BERBICARA',
                    'font_size'  => 'text-xs',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#94a3b8',
                ]],

                ['type' => 'text', 'content' => [
                    'text'       => 'Sudah 1.200+ Alumni Membuktikan',
                    'font_size'  => 'text-2xl',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#0f172a',
                ]],

                ['type' => 'spacer', 'content' => ['height' => 10]],
            ]],

            ['name' => 'Testi 1', 'layout' => 'col-2', 'components' => [
                ['type' => 'image', 'content' => [
                    'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&fit=crop',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => "Arif Setiawan\nFrontend Dev · Batch 2025\n\n★★★★★\n\n\"Kurikulumnya daging semua, langsung praktek bikin project beneran. Sekarang udah kerja di startup unicorn.\"",
                    'font_size'  => 'text-xs',
                    'alignment'  => 'text-left',
                    'text_color' => '#334155',
                ]],
            ]],

            ['name' => 'Testi 2', 'layout' => 'col-2', 'components' => [
                ['type' => 'image', 'content' => [
                    'image_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&fit=crop',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => "Sari Puspita\nFullstack Dev · Batch 2025\n\n★★★★★\n\n\"Gak nyangka bisa paham backend secepat ini. Mentornya sabar dan solutif banget.\"",
                    'font_size'  => 'text-xs',
                    'alignment'  => 'text-left',
                    'text_color' => '#334155',
                ]],
            ]],

            ['name' => 'Testi 3', 'layout' => 'col-2', 'components' => [
                ['type' => 'image', 'content' => [
                    'image_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&fit=crop',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => "Budi Santoso\nFreelancer · Batch 2024\n\n★★★★★\n\n\"Skill saya meningkat drastis, udah dapet job freelance pertama senilai 15 juta.\"",
                    'font_size'  => 'text-xs',
                    'alignment'  => 'text-left',
                    'text_color' => '#334155',
                ]],
            ]],

            // 6. FINAL CTA
            ['name' => 'CTA', 'layout' => 'col-1', 'components' => [
                ['type' => 'spacer', 'content' => ['height' => 30]],

                ['type' => 'text', 'content' => [
                    'text'       => '● Hanya 20 slot tersisa',
                    'font_size'  => 'text-xs',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#ef4444',
                ]],

                ['type' => 'spacer', 'content' => ['height' => 10]],

                ['type' => 'text', 'content' => [
                    'text'       => 'Slot Terbatas Batch 2026',
                    'font_size'  => 'text-3xl',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#0f172a',
                ]],

                ['type' => 'text', 'content' => [
                    'text'       => 'Daftar sekarang sebelum kuota penuh. Garansi uang kembali 30 hari jika tidak puas.',
                    'font_size'  => 'text-sm',
                    'alignment'  => 'text-center',
                    'text_color' => '#64748b',
                ]],

                ['type' => 'spacer', 'content' => ['height' => 30]],

                ['type' => 'button', 'content' => [
                    'text'       => 'Daftar Sekarang — Gratis Konsultasi',
                    'url'        => '#cta',
                    'bg_color'   => '#10b981',
                    'text_color' => '#ffffff',
                    'radius'     => '10px',
                    'padding_y'  => 14,
                    'padding_x'  => 36,
                    'alignment'  => 'center',
                    'shadow'     => true,
                ]],

                ['type' => 'text', 'content' => [
                    'text'       => '✓ Tanpa komitmen  ·  ✓ Garansi 30 hari  ·  ✓ Bayar setelah yakin',
                    'font_size'  => 'text-xs',
                    'alignment'  => 'text-center',
                    'text_color' => '#94a3b8',
                ]],

                ['type' => 'spacer', 'content' => ['height' => 10]],
            ]],

        ];
    }

    protected static function program_overview(): array
    {
        return [
            // 1. HEADER PROGRAM
            ['name' => 'Program Header', 'layout' => 'col-1', 'components' => [
                ['type' => 'spacer', 'content' => ['height' => 40]],
                ['type' => 'text', 'content' => [
                    'text'       => 'DETAIL PROGRAM',
                    'font_size'  => 'text-xs',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#6366f1',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => 'Kurikulum Intensif Fullstack 2026',
                    'font_size'  => 'text-4xl',
                    'is_bold'    => true,
                    'alignment'  => 'text-center',
                    'text_color' => '#0f172a',
                ]],
            ]],

            // 2. MENTOR PROFILE (Kredibilitas adalah kunci)
            ['name' => 'Mentor', 'layout' => 'col-2', 'components' => [
                ['type' => 'image', 'content' => [
                    'image_url' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&fit=crop',
                ]],
                ['type' => 'text', 'content' => [
                    'text'       => "DIBIMBING LANGSUNG OLEH EXPERT\n\nBudi Santoso, Senior Software Engineer\n\n\"Saya telah membimbing 500+ developer untuk berkarir di perusahaan teknologi top dunia. Di program ini, saya akan mendampingi kamu step-by-step.\"",
                    'font_size'  => 'text-sm',
                    'alignment'  => 'text-left',
                    'text_color' => '#334155',
                ]],
            ]],

            // 3. ROADMAP/SILABUS (Apa yang didapat)
            ['name' => 'Roadmap', 'layout' => 'col-1', 'components' => [
                ['type' => 'spacer', 'content' => ['height' => 30]],
                ['type' => 'text', 'content' => ['text' => 'Fase 1: Fundamental & Logic Building', 'font_size' => 'text-lg', 'is_bold' => true]],
                ['type' => 'text', 'content' => ['text' => 'Fase 2: Building Modern Backend API', 'font_size' => 'text-lg', 'is_bold' => true]],
                ['type' => 'text', 'content' => ['text' => 'Fase 3: Deployment & Production Ready', 'font_size' => 'text-lg', 'is_bold' => true]],
            ]],

            // 4. WHAT YOU GET (Poin kelebihan program)
            ['name' => 'Features', 'layout' => 'col-1', 'components' => [
                ['type' => 'spacer', 'content' => ['height' => 20]],
                ['type' => 'text', 'content' => ['text' => '✅ Akses Materi Selamanya', 'font_size' => 'text-base']],
                ['type' => 'text', 'content' => ['text' => '✅ Sertifikat Kelulusan Resmi', 'font_size' => 'text-base']],
                ['type' => 'text', 'content' => ['text' => '✅ Akses Komunitas Eksklusif', 'font_size' => 'text-base']],
            ]],

            // 5. CTA FOCUS PROGRAM
            ['name' => 'CTA Program', 'layout' => 'col-1', 'components' => [
                ['type' => 'spacer', 'content' => ['height' => 40]],
                ['type' => 'button', 'content' => [
                    'text'       => 'Lihat Silabus Lengkap',
                    'url'        => '#silabus',
                    'bg_color'   => '#0f172a',
                    'text_color' => '#ffffff',
                    'padding_y'  => 16,
                    'padding_x'  => 40,
                    'alignment'  => 'center',
                ]],
                ['type' => 'spacer', 'content' => ['height' => 40]],
            ]],
        ];
    }

    
}