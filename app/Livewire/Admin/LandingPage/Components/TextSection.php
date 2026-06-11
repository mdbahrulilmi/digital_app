<?php

namespace App\Livewire\Admin\LandingPage\Components;

class TextSection
{
    public static function getForm($section): array
    {
        return [
            'text'          => $section->content['text'] ?? '',
            'font_family'   => $section->content['font_family'] ?? 'font-sans',
            'font_size'     => $section->content['font_size'] ?? 'text-sm',
            'line_height'   => $section->content['line_height'] ?? 'leading-relaxed',
            'is_bold'       => $section->content['is_bold'] ?? false,
            'is_italic'     => $section->content['is_italic'] ?? false,
            'is_underline'  => $section->content['is_underline'] ?? false,
            'alignment'     => $section->content['alignment'] ?? 'text-left',
            'text_color'    => $section->content['text_color'] ?? '#334155',
        ];
    }
}