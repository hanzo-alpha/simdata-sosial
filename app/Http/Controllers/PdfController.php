<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    public function downloadRastra(Request $request): Response
    {
        $model = $request->get('m')::find($request->get('id'));
        $pdf = PDF::loadView('pdf', compact('model'));
        $pdf->setOption([
            'dpi' => 96,
            'defaultFont' => 'sans-serif',
            'defaultPaperSize' => 'a4',
        ]);
        return $pdf->stream('dokumentasi-rastra.pdf');
    }

    public function downloadBeritaAcara(Request $request): Response
    {
        $data = $request->has('d') ? $request->get('d') : [];
        $record = $request->get('m')::find($request->get('id'));
        $pdf = PDF::loadView('ba', compact('record', 'data'));
        $pdf->setOption([
            'dpi' => 120,
            'defaultFont' => 'sans-serif',
            'defaultPaperSize' => 'a4',
        ]);

        return $pdf->stream('berita-acara-serah-terima-barang.pdf');
    }
}
