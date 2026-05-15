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
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/auctions/create', [AdminController::class, 'create'])->name('auctions.create');
    Route::post('/auctions/store', [AdminController::class, 'store'])->name('auctions.store');
    Route::get('/auctions/{id}/edit', [AdminController::class, 'edit'])->name('auctions.edit');
    Route::post('/auctions/{id}/update', [AdminController::class, 'update'])->name('auctions.update');
    Route::post('/lots/{id}/approve', [AdminController::class, 'approve'])->name('approve');
    Route::delete('/auctions/{id}', [AdminController::class, 'destroy'])->name('destroy');
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
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

Route::view('/como-comprar', 'pages.como-comprar')->name('pages.como-comprar');
Route::view('/como-vender', 'pages.como-vender')->name('pages.como-vender');
Route::view('/terminos', 'pages.terminos')->name('pages.terminos');
Route::view('/privacidad', 'pages.privacidad')->name('pages.privacidad');

Route::get('/dashboard', function () {
    return redirect(route('home'));
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

