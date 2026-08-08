<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\QuoteController;

Route::get('/', function () {
    return view('welcome');
});

// العميل يرسل طلب بدون تسجيل دخول
Route::post('/quotes', [QuoteController::class, 'store']);

// صفحات الإدارة تحتاج تسجيل دخول
Route::middleware('auth')->group(function () {

    Route::get('/admin', [QuoteController::class, 'index']);

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

    return back();

})->name('locale');

require __DIR__.'/auth.php';