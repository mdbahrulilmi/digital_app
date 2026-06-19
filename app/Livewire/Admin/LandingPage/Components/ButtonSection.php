<?php

namespace App\Livewire\Admin\LandingPage\Components;

class ButtonSection
{
    public static function getForm($section): array
    {
        $url = $section->content['url'] ?? '';
        $url_disabled = false;
    
        if ($section['relation_url']) {
            $url = '/' . $section['url'];
            $url_disabled = true;
        }

        return [
            'text' => $section->content['text'] ?? 'Klik Disini',
            'url' => $url,
            'url_disabled' => $url_disabled,
            'bg_color' => $section->content['bg_color'] ?? '#4f46e5',
            'text_color' => $section->content['text_color'] ?? '#ffffff',
            'font_size' => $section->content['font_size'] ?? '14px',
            'radius' => $section->content['radius'] ?? '8px',
            'padding_y' => $section->content['padding_y'] ?? '10',
            'padding_x' => $section->content['padding_x'] ?? '20',
            'width' => 'auto',
            'height' => 'auto',
            'alignment' => 'center',
            'full_width' => false,
            'border_width' => '0px',
            'border_color' => '#000000',
            'shadow' => true,
        ];
    }

    public static function getDefault(
        bool $relationUrl = false,
        string $slug = ''
    ): array
    {
        return [
            'text' => 'Klik Disini',
            'url' => $relationUrl ? '/' . $slug : '',
            'url_disabled' => $relationUrl,
        ];
    }

    
}