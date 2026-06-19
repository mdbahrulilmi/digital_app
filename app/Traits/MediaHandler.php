<?php

namespace App\Traits; // Jika ini di dalam file trait kamu

use Intervention\Image\ImageManager; // PENTING: Gunakan ini
use Intervention\Image\Drivers\Gd\Driver; // PENTING: Gunakan ini
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait MediaHandler
{
    public function uploadImageAsWebp($file, $directory = 'media/images')
    {
        $manager = new ImageManager(new Driver());

        $filename = Str::random(20) . '.webp';
        $path = $directory . '/' . $filename;

        $img = $manager->read($file);
        $encoded = $img->toWebp(75);

        Storage::disk('public')->put($path, (string) $encoded);

        return '/storage/' . $path;
    }
}