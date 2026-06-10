<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingPage\LandingPageList;
use App\Livewire\LandingPage\LandingPageEditor;
use App\Livewire\Product\ProductList;
use App\Livewire\Media\MediaList;
use App\Livewire\Product\ProductShow;
use App\Livewire\Public\Page;
use App\Livewire\Public\Cart;
use App\Livewire\Public\Checkout;

Route::prefix('admin')->group(function () {

    Route::get('/landing-page', LandingPageList::class);
    Route::get('/landing-page/{id}/edit', LandingPageEditor::class)
        ->name('landingpage-editor');
    
    Route::get('/product', ProductList::class)->name('product.list');
    Route::get('/product/{id}', ProductShow::class)->name('product.show');
    
    
    
    Route::get('/media', MediaList::class);
});
    
Route::get('/cart', Cart::class)->name('public.cart');
Route::get('/checkout', Checkout::class)->name('public.checkout');
Route::get('/{slug?}', Page::class)
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('public.page');
