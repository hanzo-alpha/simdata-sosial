<?php

use App\Http\Controllers\PdfController;
use App\Livewire\Frontend\Index;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Index::class)->middleware('guest')->name('frontend');

Route::middleware(['auth'])->group(function () {
    Route::controller(PdfController::class)->group(function () {
        Route::get('/download', 'download')->name('pdf.download');
        Route::get('/download/{record}', 'downloadRastra')->name('pdf.rastra');
    });
});
