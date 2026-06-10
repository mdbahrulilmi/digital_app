<?php

namespace App\Livewire\LandingPage\Components;

class VideoSection
{
    public static function getForm($section): array
    {
        return [
            'title' => $section->content['title'] ?? '',
            'video_url' => $section->content['video_url'] ?? '',
        ];
    }
}