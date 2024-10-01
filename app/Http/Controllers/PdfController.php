<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BantuanPpks;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    public function cetakDokumentasiRastra(Request $request): Response
    {
        $model = $request->get('m')::find($request->get('id'));
        $pdf = PDF::loadView('laporan.dokumentasi', compact('model'));
        $pdf->setOption([
            'defaultFont' => 'sans-serif',
            'defaultPaperSize' => 'a4',
        ]);
        return $pdf->stream('dokumentasi-rastra.pdf');
    }

    public function cetakDokumentasi(Request $request): Response
    {
        $model = $request->get('m')::find($request->get('id'));
        $pdf = PDF::loadView('laporan.dokumentasi-ppks', compact('model'));
        $pdf->setOption([
            'dpi' => 96,
            'defaultFont' => 'sans-serif',
            'defaultPaperSize' => 'a4',
        ]);
        return $pdf->stream('dokumentasi-ppks.pdf');
    }

    public function downloadBeritaAcara(Request $request): Response
    {
        $data = $request->has('d') ? $request->get('d') : [];
        $record = $request->get('m')::find($request->get('id'));
        $pdf = PDF::loadView('laporan.ba', compact('record', 'data'));
        $pdf->setOption([
            'dpi' => 120,
            'defaultFont' => 'sans-serif',
            'defaultPaperSize' => 'a4',
        ]);

        return $pdf->stream('bast-rastra.pdf');
    }

    public function cetakBeritaAcaraPpks(Request $request): Response
    {
        $data = $request->has('d') ? $request->get('d') : [];
        $records = $request->has('m') ? $request->get('m') : BantuanPpks::class;
        $record = $records::find($request->get('id'));
        $pdf = PDF::loadView('laporan.ba-ppks', compact('record', 'data'));
        $pdf->setOption([
            'dpi' => 120,
            'defaultFont' => 'sans-serif',
            'defaultPaperSize' => 'a4',
        ]);

        return $pdf->stream('bast-ppks.pdf');
    }
}
