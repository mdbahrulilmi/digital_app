<?php

namespace App\Livewire\Admin\LandingPage\Components;

class SpacerSection
{
    public static function getForm($section): array
    {
        return [
            'height' => $section->content['height'] ?? '',
        ];  
    }
}