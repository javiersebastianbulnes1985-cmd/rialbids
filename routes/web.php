<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\StripeConnectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuctionController::class, 'home'])->name('home');
Route::get('/auctions', [AuctionController::class, 'home'])->name('auctions.index');
Route::get('/auctions/{id}', [AuctionController::class, 'show'])->name('auctions.show');
Route::post('/auctions/{id}/bid', [AuctionController::class, 'bid'])->middleware('auth')->name('auctions.bid');
Route::get('/finalizadas', [AuctionController::class, 'finalizadas'])->name('auctions.finalizadas');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is.admin'])->group(function () {
    Route::get('/finanzas', [AdminController::class, 'finanzas'])->name('finanzas');
    Route::post('/gastos', [\App\Http\Controllers\Admin\GastoController::class, 'store'])->name('gastos.store');
    Route::delete('/gastos/{id}', [\App\Http\Controllers\Admin\GastoController::class, 'destroy'])->name('gastos.destroy');
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/auctions/create', [AdminController::class, 'create'])->name('auctions.create');
    Route::post('/auctions/store', [AdminController::class, 'store'])->name('auctions.store');
    Route::get('/auctions/{id}/edit', [AdminController::class, 'edit'])->name('auctions.edit');
    Route::post('/auctions/{id}/update', [AdminController::class, 'update'])->name('auctions.update');
    Route::post('/lots/{id}/approve', [AdminController::class, 'approve'])->name('approve');
    Route::post('/lots/{id}/reject', [AdminController::class, 'reject'])->name('reject');
    Route::delete('/auctions/{id}', [AdminController::class, 'destroy'])->name('destroy');
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::post('/banners/{id}/update', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');
    Route::post('/banners/{id}/toggle', [BannerController::class, 'toggle'])->name('banners.toggle');
});

Route::prefix('vendor')->name('vendor.')->middleware(['auth', 'is.vendedor'])->group(function () {
    Route::get('/', [VendorController::class, 'index'])->name('index');
    Route::get('/create', [VendorController::class, 'create'])->name('create');
    Route::post('/store', [VendorController::class, 'store'])->name('store');
    Route::get('/stripe/onboarding', [StripeConnectController::class, 'onboarding'])->name('stripe.onboarding');
    Route::get('/stripe/callback', [StripeConnectController::class, 'callback'])->name('stripe.callback');
    Route::post('/auctions/{id}/ship', [VendorController::class, 'marcarEnviado'])->name('auctions.ship');
    Route::get('/edit/{id}', [VendorController::class, 'edit'])->name('edit');
    Route::post('/edit/{id}', [VendorController::class, 'update'])->name('update');
});

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/payment/{id}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/{id}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::post('/auctions/{id}/confirm', [AuctionController::class, 'confirmarEntrega'])->name('auctions.confirm');
});

Route::post('/webhook/stripe', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Mobile upload (sin auth, solo token)
Route::get('/mobile-upload/{token}', [\App\Http\Controllers\MobileUploadController::class, 'page'])->name('mobile.upload.page');
Route::post('/mobile-upload/{token}/upload', [\App\Http\Controllers\MobileUploadController::class, 'upload'])->name('mobile.upload.photo');
Route::get('/mobile-upload/{token}/status', [\App\Http\Controllers\MobileUploadController::class, 'status'])->name('mobile.upload.status');
Route::post('/mobile-upload/{token}/delete', [\App\Http\Controllers\MobileUploadController::class, 'delete'])->name('mobile.upload.delete');

Route::view('/como-comprar', 'pages.como-comprar')->name('pages.como-comprar');
Route::view('/proteccion-al-comprador', 'pages.proteccion-comprador')->name('pages.proteccion-comprador');
Route::view('/como-vender', 'pages.como-vender')->name('pages.como-vender');
Route::view('/terminos', 'pages.terminos')->name('pages.terminos');
Route::view('/faq', 'pages.faq')->name('pages.faq');
Route::view('/sobre-nosotros', 'pages.about')->name('pages.about');
Route::view('/garantia', 'pages.garantia')->name('pages.garantia');
Route::view('/privacidad', 'pages.privacidad')->name('pages.privacidad');

Route::get('/dashboard', function () {
    return redirect(route('home'));
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/seller-request', [App\Http\Controllers\SellerRequestController::class, 'create'])->name('seller.request.create');
Route::post('/seller-request', [App\Http\Controllers\SellerRequestController::class, 'store'])->name('seller.request.store');

// Aliases para el nav
Route::get('/como-comprar-redirect', function() { return redirect('/como-comprar'); })->name('como-comprar');
Route::get('/como-vender-redirect', function() { return redirect('/como-vender'); })->name('como-vender');
Route::get('/faq-redirect', function() { return redirect('/faq'); })->name('faq');
Route::get('/terminos-redirect', function() { return redirect('/terminos'); })->name('terms');
Route::get('/privacidad-redirect', function() { return redirect('/privacidad'); })->name('privacy');
Route::view('/cookies', 'pages.privacidad')->name('cookies');
Route::get('/lang/{locale}', function ($locale) {
    $supported = ['es', 'en', 'pt', 'it', 'de'];
    if (in_array($locale, $supported)) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');
