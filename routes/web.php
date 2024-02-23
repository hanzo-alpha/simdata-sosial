<?php

use App\Http\Controllers\PdfController;
use App\Livewire\Frontend\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)->name('frontend');

Route::middleware(['auth'])->group(function (): void {
    Route::controller(PdfController::class)->group(function (): void {
        Route::get('/download', 'download')->name('pdf.download');
        Route::get('/download-rastra', 'downloadRastra')->name('pdf.rastra');
        Route::get('/cetak-berita-acara', 'downloadBeritaAcara')->name('pdf.ba');
    });
});
