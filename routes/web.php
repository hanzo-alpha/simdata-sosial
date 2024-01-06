<?php

use App\Http\Controllers\PdfController;
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

Route::get('/', static function () {
    return view('frontend');
})->name('frontend');

Route::get('/download', [PdfController::class, 'download'])->name('pdf.download');
Route::get('/download/{record}', [PdfController::class, 'downloadRastra'])->name('rastra.pdf.download');
