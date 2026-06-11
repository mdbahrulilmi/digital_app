<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// Admin
use App\Livewire\Admin\LandingPage\LandingPageList;
use App\Livewire\Admin\LandingPage\LandingPageEditor;
use App\Livewire\Admin\Product\ProductList;
use App\Livewire\Admin\Media\MediaList;
use App\Livewire\Admin\Product\ProductShow;
use App\Livewire\Member\Dashboard as MemberDashboard;

// Auth
use App\Livewire\Auth\AdminLogin;
use App\Livewire\Auth\MemberLogin;

// Public
use App\Livewire\Public\Page;
use App\Livewire\Public\Cart;
use App\Livewire\Public\Checkout;

// Payment
use App\Livewire\Payment\Invoice;
use App\Http\Controllers\Payment\MidtransWebhookController;


Route::middleware(['guest'])->group(function () {
    Route::get('/admin/login', AdminLogin::class)->name('admin.login');
    Route::get('/member/login', MemberLogin::class)->name('login');
});

Route::prefix('admin')->middleware(['admin'])->group(function () {

    Route::get('/landing-page', LandingPageList::class);
    Route::get('/landing-page/{id}/edit', LandingPageEditor::class)
        ->name('landingpage-editor');
    
    Route::get('/product', ProductList::class)->name('product.list');
    Route::get('/product/{id}', ProductShow::class)->name('product.show');
    
    
    
    Route::get('/media', MediaList::class);
});

Route::middleware(['auth:member'])->group(function () {
    
    Route::get('/member/dashboard', MemberDashboard::class)->name('member.dashboard');

});

Route::post('/member/logout', function () {
    Auth::guard('member')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    
    return redirect()->to('/');
})->name('member.logout');

// Invoice
Route::get('/payment', Invoice::class)->name('payment.invoice');

// Midtrans
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handleNotification']);

// Cart n Checkout
Route::get('/cart', Cart::class)->name('public.cart');
Route::get('/checkout', Checkout::class)->name('public.checkout');

// Landing Page
Route::get('/{slug?}', Page::class)
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('public.page');
