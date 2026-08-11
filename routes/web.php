<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/pricing-data', [PricingController::class, 'data'])
    ->name('pricing.data');
    Route::get('/api/pricing', [PricingController::class, 'data'])
    ->name('pricing.api');

// العميل يرسل طلب بدون تسجيل دخول
Route::post('/quotes', [QuoteController::class, 'store']);

// صفحات الإدارة تحتاج تسجيل دخول
Route::middleware('auth')->group(function () {

 Route::get('/admin', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/admin/quotes', [QuoteController::class, 'index'])
    ->name('admin.quotes');

    Route::get('/admin/pricing', [PricingController::class, 'index'])
    ->name('admin.pricing.index');

    Route::patch('/admin/pricing/{pricingLane}', [PricingController::class, 'update'])
    ->name('admin.pricing.update');

    Route::get('/quotes', [QuoteController::class, 'getQuotes']);
    Route::patch('/quotes/{quote}', [QuoteController::class, 'updateStatus']);
    Route::get('/quotes.csv', [QuoteController::class, 'exportCsv']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/locale/{locale}', function ($locale) {
    if (! in_array($locale, ['ar', 'en'])) {
        abort(404);
    }

    session(['locale' => $locale]);

    return redirect('/');
})->name('locale');

Route::get('/admin/locale/{locale}', function ($locale) {

    if (! in_array($locale, ['ar', 'en'])) {
        abort(404);
    }

    session(['admin_locale' => $locale]);

    return back();

})->name('admin.locale');



require __DIR__.'/auth.php';