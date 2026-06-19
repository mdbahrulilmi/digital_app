<?php

namespace App\Livewire\Admin\LandingPage\Components;

use App\Models\Product;

class ProductSection

{
    public static function getDefault(): array
    {
        return [
            'title' => 'Nama Produk',
            'price' => 0,
            'description' => 'Tuliskan deskripsi singkat atau spesifikasi produk Anda di sini.',
            'button_text' => 'Masukkan Keranjang',
            'image_url' => '',
            'badge' => 'Terlaris',
            'font_family' => 'font-sans',
            'alignment' => 'text-left',
            'text_color' => '#1e293b',
            'price_color' => '#4f46e5',
            'btn_bg_color' => '#4f46e5',
            'btn_text_color' => '#ffffff',
        ];  
    }

    public static function get2Default(): array
    {
        return [
            'title_1'        => 'Nama Produk',
            'price_1'        => 0,
            'description_1'  => 'Deskripsi singkat produk.',
            'image_url_1'    => '',
            'button_url_1'   => '#',

            'title_2'        => 'Nama Produk',
            'price_2'        => 0,
            'description_2'  => 'Deskripsi singkat produk.',
            'image_url_2'    => '',
            'button_url_2'   => '#',

            'button_text'    => 'Masukkan Keranjang',
            'badge'          => 'Promo',
            'font_family'    => 'font-sans',
            'alignment'      => 'text-center',
            'text_color'     => '#1e293b',
            'price_color'    => '#4f46e5',
            'btn_bg_color'   => '#4f46e5',
            'btn_text_color' => '#ffffff',
        ];  
    }

    public static function getForm($section): array
    {
        return [
            'product_id'       => $section->content['product_id'] ?? '',

            'badge'            => $section->content['badge'] ?? '',
            'button_text'      => $section->content['button_text'] ?? 'Beli Sekarang',
            'button_url'       => $section->content['button_url'] ?? '#',
            'old_price'       => $section->content['old_price'] ?? null,
            
            'font_family'      => $section->content['font_family'] ?? 'font-sans',
            'alignment'        => $section->content['alignment'] ?? 'text-left',
            
            'text_color'       => $section->content['text_color'] ?? '#1e293b',
            'price_color'      => $section->content['price_color'] ?? '#4f46e5',
            'old_price_color'  => $section->content['old_price_color'] ?? '#94a3b8',
            'badge_bg_color'   => $section->content['badge_bg_color'] ?? '#f43f5e',
            'badge_text_color' => $section->content['badge_text_color'] ?? '#ffffff',
            'btn_bg_color'     => $section->content['btn_bg_color'] ?? '#4f46e5',
            'btn_text_color'   => $section->content['btn_text_color'] ?? '#ffffff',
        ];  
    }

    public static function get2Form($section): array
    {
        return [
            'product_id_1'     => $section->content['product_id_1'] ?? '',
            'product_id_2'     => $section->content['product_id_2'] ?? '',

            'badge_1'          => $section->content['badge_1'] ?? '',
            'badge_2'          => $section->content['badge_2'] ?? '',

            'button_text'      => $section->content['button_text'] ?? 'Beli',
            'font_family'      => $section->content['font_family'] ?? 'font-sans',
            'alignment'        => $section->content['alignment'] ?? 'text-left',
            
            'text_color'       => $section->content['text_color'] ?? '#1e293b',
            'price_color'      => $section->content['price_color'] ?? '#4f46e5',
            'badge_bg_color'   => $section->content['badge_bg_color'] ?? '#f43f5e',
            'badge_text_color' => $section->content['badge_text_color'] ?? '#ffffff',
            'btn_bg_color'     => $section->content['btn_bg_color'] ?? '#4f46e5',
            'btn_text_color'   => $section->content['btn_text_color'] ?? '#ffffff',
        ];  
    }

    public static function mutateBeforeSave(array $content): array
    {
        if (!empty($content['product_id'])) {
            $product = Product::find($content['product_id']);
            if ($product) {
                $content['title']       = $product->title;
                $content['price']       = $product->price;
                $content['description'] = $product->description;
                $content['image_url']   = $product->image ?? '';
            }
        }

        return $content;
    }
    
   public static function mutateBeforeSave2(array $content): array
    {
        $fields = [
            'product_id_1' => '1',
            'product_id_2' => '2',
        ];

        foreach ($fields as $key => $index) {

            if (!empty($content[$key])) {

                $product = Product::find($content[$key]);

                if ($product) {

                    $content["title_{$index}"] = $product->title;
                    $content["price_{$index}"] = $product->price;
                    $content["description_{$index}"] = $product->description;
                    $content["image_url_{$index}"] = $product->image;

                }

                unset($content["product_{$index}"]);
            }
        }

        return $content;
    }
}