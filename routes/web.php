<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// Admin
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Settings;
use App\Livewire\Admin\LandingPage\LandingPageList;
use App\Livewire\Admin\LandingPage\LandingPageEditor;
use App\Livewire\Admin\Product\ProductList;
use App\Livewire\Admin\Product\ProductShow;
use App\Livewire\Admin\Program\ProgramList;
use App\Livewire\Admin\Program\ProgramShow;
use App\Livewire\Admin\Media\MediaList;
use App\Livewire\Admin\Order\OrderList;
use App\Livewire\Admin\Member\MemberList;

// Member
use App\Livewire\Member\MemberDashboard;

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
use App\Http\Controllers\Payment\DokuController;    

Route::get('/test-doku', [DokuController::class, 'generateQr']);

Route::middleware(['guest'])->group(function () {
    Route::get('/admin/login', AdminLogin::class)->name('admin.login');
    Route::get('/member/login', MemberLogin::class)->name('login');
});

Route::prefix('admin')->middleware(['admin'])->group(function () {

    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/settings', Settings::class)->name('admin.settings');

    Route::get('/landing-page', LandingPageList::class);
    Route::get('/landing-page/{id}/edit', LandingPageEditor::class)
        ->name('landingpage-editor');
    
    Route::get('/product', ProductList::class)->name('product.list');
    Route::get('/product/{id}', ProductShow::class)->name('product.show');
    
    Route::get('/program', ProgramList::class)->name('program.list');
    Route::get('/program/{id}', ProgramShow::class)->name('program.show');
    
    Route::get('/orders', OrderList::class)->name('order.list');
    Route::get('/members', MemberList::class)->name('member.list');
    
    
    Route::get('/media', MediaList::class);

    Route::post('/logout', function () {
            Auth::logout();
            return redirect()->route('admin.login');
        })->name('admin.logout');
});

Route::middleware(['auth:member'])->group(function () {
    
    Route::get('/member', MemberDashboard::class)->name('member.dashboard');

});

Route::post('/member/logout', function () {
    Auth::guard('member')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    
    return redirect()->to('/member/login');
})->name('member.logout');

// Invoice
Route::get('/payment', Invoice::class)->name('payment.invoice');
Route::get('/payment/success', function () {
    return view('payment.success');
})->name('payment.success');

// Midtrans
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handleNotification']);

// Cart n Checkout
Route::get('/cart', Cart::class)->name('public.cart');
Route::get('/checkout', Checkout::class)->name('public.checkout');

Route::get('/test', function(){
    return response('
        <html>
            <body>
                <h1>Test Traffic</h1>
                <a href="http://localhost:8000/">Klik menuju dashboard</a>
            </body>
        </html>
    ');
});
// Landing Page
Route::get('/{slug?}', Page::class)
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('public.page');
