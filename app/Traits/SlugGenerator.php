<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Program;

trait SlugGenerator
{
    public function generateUniqueSlug($value, $modelClass)
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $count = 1;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}