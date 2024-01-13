<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BantuanRastra;
use Illuminate\Http\Response;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;

class PdfController extends Controller
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Exception
     */
    public function download(BantuanRastra $record): Response
    {
        $customer = new Buyer([
            'name' => 'John Doe',
            'custom_fields' => [
                'email' => 'test@example.com',
                'test' => 'test 1',
            ],
        ]);

        $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->buyer($customer)
            ->logo('images/logos/logo-soppeng2.png')
            ->discountByPercent(10)
            ->template('rastra')
            ->taxRate(11)
            ->shipping(20000)
            ->addItem($item);

        return $invoice->stream();
    }

    public function downloadRastra()
    {
        $rastra = BantuanRastra::all();
        $pdf = \PDF::loadView('pdf.rastra', compact('rastra'));

        return $pdf->stream('rastra.pdf');
    }
}
