<?php

namespace App\Livewire\Admin\LandingPage\Components;

class ImageSection
{
    public static function getForm($section): array
    {
        return [
            'title' => $section->content['title'] ?? '',
            'image_url' => $section->content['image_url'] ?? '',
        ];  
    }
}