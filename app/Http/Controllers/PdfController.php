<?php

namespace App\Http\Controllers;

use App\Models\PenyaluranBantuanRastra;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;
use PDF;

class PdfController extends Controller
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws Exception
     */
    public function download(PenyaluranBantuanRastra $record): Response
    {
        $peserta = $record->get()->first();
        $customer = new Buyer([
            'name' => $peserta?->bantuan_rastra->nama_lengkap,
            'custom_fields' => [
                'no' => $peserta->id,
            ],
        ]);

        $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->name('Dokumentasi Penyaluran Bantuan Sosial Beras Sejahtera Tahun 2022')
            ->buyer($customer)
            ->logo('images/logos/logo-soppeng2.png')
            ->discountByPercent(10)
            ->template('rastra')
            ->taxRate(11)
            ->shipping(20000)
            ->addItem($item);

        return $invoice->stream();
    }

    public function downloadRastra(Request $request): Response
    {
        $model = $request->get('m')::find($request->get('id'));
        $pdf = PDF::loadView('pdf', compact('model'));
        $pdf->setOption([
            'dpi' => 120,
            'defaultFont' => 'sans-serif',
            'defaultPaperSize' => 'a4'
        ]);


        return $pdf->stream('rastra.pdf');
    }

    public function downloadBeritaAcara(Request $request): Response
    {
        $model = $request->get('m')::find($request->get('id'));
        $pdf = PDF::loadView('ba', compact('model'));
        $pdf->setOption([
            'dpi' => 120,
            'defaultFont' => 'sans-serif',
            'defaultPaperSize' => 'a4'
        ]);


        return $pdf->stream('berita-acara-serah-terima-barang.pdf');
    }
}
