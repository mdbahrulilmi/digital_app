<?php

namespace App\Livewire\LandingPage\Components;

class ScriptSection
{
    public static function getForm($section): array
    {
        return [
            'script' => $section->content['script'] ?? ''
        ];  
    }
}