<?php

namespace App\Livewire\Admin\LandingPage\Components;

use App\Models\Program;

class ProgramSection
{
    /**
     * Default data untuk 1 program (single)
     */
    public static function getDefault(): array
    {
        return [
            'title' => 'Nama Program',
            'price' => 0,
            'description' => 'Deskripsi singkat program Anda di sini.',
            'button_text' => 'Daftar Sekarang',
            'image_url' => '',
            'badge' => 'Terpopuler',
            'font_family' => 'font-sans',
            'alignment' => 'text-left',
            'text_color' => '#1e293b',
            'price_color' => '#4f46e5',
            'btn_bg_color' => '#4f46e5',
            'btn_text_color' => '#ffffff',
        ];
    }

    /**
     * Default data untuk 2 program (split/duo)
     */
    public static function get2Default(): array
    {
        return [
            'title_1' => 'Program 1', 'price_1' => 0, 'description_1' => 'Deskripsi program 1.', 'image_url_1' => '', 'button_url_1' => '#',
            'title_2' => 'Program 2', 'price_2' => 0, 'description_2' => 'Deskripsi program 2.', 'image_url_2' => '', 'button_url_2' => '#',
            'button_text' => 'Daftar Sekarang',
            'badge' => 'Promo',
            'font_family' => 'font-sans',
            'alignment' => 'text-center',
            'text_color' => '#1e293b',
            'price_color' => '#4f46e5',
            'btn_bg_color' => '#4f46e5',
            'btn_text_color' => '#ffffff',
        ];
    }

    /**
     * Form schema untuk single program
     */
    public static function getForm($section): array
    {
        $content = $section->content ?? [];
        return [
            'program_id'        => $content['program_id'] ?? '',
            'badge'             => $content['badge'] ?? '',
            'button_text'       => $content['button_text'] ?? 'Daftar Sekarang',
            'button_url'        => $content['button_url'] ?? '#',
            'old_price'         => $content['old_price'] ?? null,
            'font_family'       => $content['font_family'] ?? 'font-sans',
            'alignment'         => $content['alignment'] ?? 'text-left',
            'text_color'        => $content['text_color'] ?? '#1e293b',
            'price_color'       => $content['price_color'] ?? '#4f46e5',
            'old_price_color'   => $section->content['old_price_color'] ?? '#94a3b8',
            'badge_bg_color'    => $section->content['badge_bg_color'] ?? '#f43f5e',
            'badge_text_color'  => $section->content['badge_text_color'] ?? '#ffffff',
            'btn_bg_color'      => $section->content['btn_bg_color'] ?? '#4f46e5',
            'btn_text_color'    => $section->content['btn_text_color'] ?? '#ffffff',
        ];
    }

    /**
     * Form schema untuk duo program
     */
    public static function get2Form($section): array
    {
        $content = $section->content ?? [];
        return [
            'program_id_1' => $content['program_id_1'] ?? '',
            'program_id_2' => $content['program_id_2'] ?? '',
            'badge_1'      => $content['badge_1'] ?? '',
            'badge_2'      => $content['badge_2'] ?? '',
            'button_text'  => $content['button_text'] ?? 'Daftar',
            'font_family'  => $content['font_family'] ?? 'font-sans',
            'alignment'    => $content['alignment'] ?? 'text-center',
            'text_color'   => $content['text_color'] ?? '#1e293b',
            'price_color'  => $content['price_color'] ?? '#4f46e5',
            'btn_bg_color' => $content['btn_bg_color'] ?? '#4f46e5',
        ];
    }

    /**
     * Sinkronisasi data saat menyimpan single program
     */
    public static function mutateBeforeSave(array $content): array
    {
        if (!empty($content['program_id'])) {
            $program = Program::find($content['program_id']);
            if ($program) {
                $content['title']       = $program->title;
                $content['price']       = $program->price ?? 0;
                $content['description'] = $program->description ?? '';
                $content['image_url']   = $program->image ?? '';
                $content['start_date']   = $program->start_date ?? '';
                $content['end_date']   = $program->end_date ?? '';
            }
        }
        return $content;
    }

    /**
     * Sinkronisasi data saat menyimpan duo program
     */
    public static function mutateBeforeSave2(array $content): array
    {
        foreach ([1, 2] as $i) {
            $key = "program_id_{$i}";
            if (!empty($content[$key])) {
                $program = Program::find($content[$key]);
                if ($program) {
                    $content["title_{$i}"]       = $program->title;
                    $content["price_{$i}"]       = $program->price ?? 0;
                    $content["description_{$i}"] = $program->description ?? '';
                    $content["image_url_{$i}"]   = $program->image ?? '';
                    $content["start_date_{$i}"]  = $program->start_date ?? '';
                    $content["end_date_{$i}"]    = $program->end_date ?? '';
                }
            }
        }
        return $content;
    }
}