<?php

namespace App\Livewire\Admin\LandingPage\Components;

class ScriptSection
{
    public static function getForm($section): array
    {
        return [
            'script' => $section->content['script'] ?? ''
        ];  
    }
}