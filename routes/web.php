<?php

declare(strict_types=1);

use App\Http\Controllers\PdfController;
use App\Livewire\Frontend\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)->name('frontend');

Route::middleware(['auth'])->group(function (): void {
    Route::controller(PdfController::class)->group(function (): void {
        Route::get('/download', 'download')->name('pdf.download');
        Route::get('/cetak-dokumentasi-rastra', 'cetakDokumentasiRastra')->name('cetak-dokumentasi.rastra');
        Route::get('/cetak-dokumentasi-ppks', 'cetakDokumentasi')->name('cetak-dokumentasi.ppks');
        Route::get('/cetak-berita-acara', 'downloadBeritaAcara')->name('ba.rastra');
        Route::get('/cetak-berita-acara-ppks', 'cetakBeritaAcaraPpks')->name('ba.ppks');
    });
});
