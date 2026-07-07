<?php

namespace App\Livewire\Admin\LandingPage\Components;

use App\Models\Product;

class ProductSection

{
    public static function getDefault(): array
    {
        return [
            'product_style' => 'card',
            'title' => 'Nama Produk',
            'slug' => '#',
            'price' => 0,
            'description' => 'Tuliskan deskripsi singkat atau spesifikasi produk Anda di sini.',
            'button_text' => 'Masukkan Keranjang',
            'image_url' => '',
            'badge' => 'Terlaris',
        ];  
    }

    public static function getForm($section): array
    {
        return [
            'product_style' => $section->content['product_style'] ?? 'card',
            'product_id'       => $section->content['product_id'] ?? '',
            'product_slug'       => $section->content['product_slug'] ?? '',

            'badge'            => $section->content['badge'] ?? '',
            'button_text'      => $section->content['button_text'] ?? 'Beli Sekarang',
            'button_url'       => $section->content['button_url'] ?? '#',
            'old_price'       => $section->content['old_price'] ?? null,
        ];  
    }

    public static function mutateBeforeSave(array $content): array
    {
        if (!empty($content['product_id'])) {
            $product = Product::find($content['product_id']);
            if ($product) {
                $content['title']       = $product->title;
                $content['slug']        = $product->slug;
                $content['price']       = $product->price;
                $content['description'] = $product->description;
                $content['image_url']   = $product->image ?? '';
            }
        }

        return $content;
    }
    
}