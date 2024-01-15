<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $invoice->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style type="text/css" media="screen">
        html {
            font-family: sans-serif;
            line-height: 1.15;
            margin: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            font-size: 10px;
            margin: 36pt;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        h5 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        strong {
            font-weight: bolder;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        h4, .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h4, .h4 {
            font-size: 1.5rem;
        }

        h5, .h5 {
            margin-bottom: 0.5rem;
            font-weight: 200;
            line-height: 1.2;
        }

        h5, .h5 {
            font-size: 0.3rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table.table-items td {
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        * {
            font-family: "DejaVu Sans";
        }

        body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
            line-height: 1.1;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }

        .border-0 {
            border: none !important;
        }

        .cool-gray {
            color: #6B7280;
        }
    </style>
</head>

<body>
{{-- Header --}}
@if($invoice->logo)
    <div class="text-center">
        <img src="{{ $invoice->getLogo() }}" alt="logo" height="80">
        <h1><strong>PEMERINTAH KABUPATEN SOPPENG</strong></h1>
        <h1><strong>DINAS SOSIAL</strong></h1>
        @if($invoice->seller->address)
            <p style="margin-top: 0">
                {{ __('invoices::invoice.address') }}: {{ $invoice->seller->address }}
            </p>
            <p class="pt-0">
                Website : https://dinsos.@soppengkab.go.id/, Email : dinsos01.soppeng@gmail.com
            </p>
        @endif
    </div>
@endif

<table class="table mt-2">
    <tbody>
    <tr>
        <td class="border-0 pl-0 text-center" width="70%">
            <p class="text-uppercase" style="font-size: 0.7rem">
                <strong>{{ Str::take($invoice->name, 37) }}</strong><br>
                <strong>{{ Str::substr($invoice->name, 37) }}</strong>
            </p>

            @foreach($invoice->buyer->custom_fields as $key => $value)
                <p style="text-align: right; font-size: 0.9rem"><strong>{{ $value }}</strong></p>
            @endforeach
            {{--            <p>{{ __('invoices::invoice.date') }}: <strong>{{ $invoice->getDate() }}</strong></p>--}}
        </td>
        {{--        <td class="border-0 text-center pl-0">--}}
        {{--            @if($invoice->status)--}}
        {{--                <h4 class="text-uppercase cool-gray">--}}
        {{--                    <strong>{{ $invoice->status }}</strong>--}}
        {{--                </h4>--}}
        {{--            @endif--}}
        {{--            <p>{{ __('invoices::invoice.serial') }} <strong>{{ $invoice->getSerialNumber() }}</strong></p>--}}
        {{--            <p>{{ __('invoices::invoice.date') }}: <strong>{{ $invoice->getDate() }}</strong></p>--}}
        {{--        </td>--}}
    </tr>
    </tbody>
</table>
{{-- Seller - Buyer --}}
<table class="table">
    {{--    <thead>--}}
    {{--    <tr>--}}
    {{--                <th class="border-0 pl-0 party-header" width="48.5%">--}}
    {{--                    {{ __('invoices::invoice.seller') }}--}}
    {{--                </th>--}}
    {{--                <th class="border-0" width="3%"></th>--}}
    {{--        <th class="border-0 pl-0 text-center party-header">--}}
    {{--            {{ __('invoices::invoice.buyer') }}--}}
    {{--        </th>--}}
    {{--    </tr>--}}
    {{--    </thead>--}}
    <tbody>
    {{--    <tr>--}}
    {{--        <th>sdfsdfsdf</th>--}}
    {{--        <td class="px-0">--}}
    {{--            @if($invoice->buyer->name)--}}
    {{--                <p class="buyer-name">--}}
    {{--                    NAMA: <strong>{{ $invoice->buyer->name }}</strong>--}}
    {{--                </p>--}}
    {{--            @endif--}}

    {{--            @if($invoice->buyer->address)--}}
    {{--                <p class="buyer-address">--}}
    {{--                    NIK : {{ __('invoices::invoice.address') }}: {{ $invoice->buyer->address }}--}}
    {{--                </p>--}}
    {{--            @endif--}}

    {{--            @if($invoice->buyer->code)--}}
    {{--                <p class="buyer-code">--}}
    {{--                    ALAMAT : {{ __('invoices::invoice.code') }}: {{ $invoice->buyer->code }}--}}
    {{--                </p>--}}
    {{--            @endif--}}

    {{--            @if($invoice->buyer->vat)--}}
    {{--                <p class="buyer-vat">--}}
    {{--                    {{ __('invoices::invoice.vat') }}: {{ $invoice->buyer->vat }}--}}
    {{--                </p>--}}
    {{--            @endif--}}

    {{--            @if($invoice->buyer->phone)--}}
    {{--                <p class="buyer-phone">--}}
    {{--                    {{ __('invoices::invoice.phone') }}: {{ $invoice->buyer->phone }}--}}
    {{--                </p>--}}
    {{--            @endif--}}

    {{--            @foreach($invoice->buyer->custom_fields as $key => $value)--}}
    {{--                <p class="buyer-custom-field">--}}
    {{--                    {{ ucfirst($key) }}: {{ $value }}--}}
    {{--                </p>--}}
    {{--            @endforeach--}}
    {{--        </td>--}}
    {{--    </tr>--}}
    <tr>
        <th class="text-left">NAMA</th>
        <th class="text-center">:</th>
        <td>RUDI HARTONO</td>
    </tr>
    <tr>
        <th class="text-left">NIK</th>
        <th class="text-center">:</th>
        <td>7312033112710111</td>
    </tr>
    <tr>
        <th class="text-left">ALAMAT</th>
        <th class="text-center">:</th>
        <td>LOMPULLE RT 01 RW 04</td>
    </tr>
    <tr>
        <th class="text-left">DESA / KEL</th>
        <th class="text-center">:</th>
        <td>KEBO</td>
    </tr>
    <tr>
        <th class="text-left">KECAMATAN</th>
        <th class="text-center">:</th>
        <td>LILIRILAU</td>
    </tr>
    </tbody>
</table>

{{-- Table --}}
<table class="table table-items">
    {{--    <thead>--}}
    {{--    <tr>--}}
    {{--        <th scope="col" class="border-0 pl-0">{{ __('invoices::invoice.description') }}</th>--}}
    {{--        @if($invoice->hasItemUnits)--}}
    {{--            <th scope="col" class="text-center border-0">{{ __('invoices::invoice.units') }}</th>--}}
    {{--        @endif--}}
    {{--        <th scope="col" class="text-center border-0">{{ __('invoices::invoice.quantity') }}</th>--}}
    {{--        <th scope="col" class="text-right border-0">{{ __('invoices::invoice.price') }}</th>--}}
    {{--        @if($invoice->hasItemDiscount)--}}
    {{--            <th scope="col" class="text-right border-0">{{ __('invoices::invoice.discount') }}</th>--}}
    {{--        @endif--}}
    {{--        @if($invoice->hasItemTax)--}}
    {{--            <th scope="col" class="text-right border-0">{{ __('invoices::invoice.tax') }}</th>--}}
    {{--        @endif--}}
    {{--        <th scope="col" class="text-right border-0 pr-0">{{ __('invoices::invoice.sub_total') }}</th>--}}
    {{--    </tr>--}}
    {{--    </thead>--}}
    <tbody>
    <tr>
        <td class="pl-0">
            sdfsdfsdf
        </td>
    </tr>
    {{--    @foreach($invoice->items as $item)--}}
    {{--        <tr>--}}
    {{--            <td class="pl-0">--}}
    {{--                {{ $item->title }}--}}

    {{--                @if($item->description)--}}
    {{--                    <p class="cool-gray">{{ $item->description }}</p>--}}
    {{--                @endif--}}
    {{--            </td>--}}
    {{--            @if($invoice->hasItemUnits)--}}
    {{--                <td class="text-center">{{ $item->units }}</td>--}}
    {{--            @endif--}}
    {{--            <td class="text-center">{{ $item->quantity }}</td>--}}
    {{--            <td class="text-right">--}}
    {{--                {{ $invoice->formatCurrency($item->price_per_unit) }}--}}
    {{--            </td>--}}
    {{--            @if($invoice->hasItemDiscount)--}}
    {{--                <td class="text-right">--}}
    {{--                    {{ $invoice->formatCurrency($item->discount) }}--}}
    {{--                </td>--}}
    {{--            @endif--}}
    {{--            @if($invoice->hasItemTax)--}}
    {{--                <td class="text-right">--}}
    {{--                    {{ $invoice->formatCurrency($item->tax) }}--}}
    {{--                </td>--}}
    {{--            @endif--}}

    {{--            <td class="text-right pr-0">--}}
    {{--                {{ $invoice->formatCurrency($item->sub_total_price) }}--}}
    {{--            </td>--}}
    {{--        </tr>--}}
    {{--    @endforeach--}}
    {{-- Summary --}}
    {{--    @if($invoice->hasItemOrInvoiceDiscount())--}}
    {{--        <tr>--}}
    {{--            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>--}}
    {{--            <td class="text-right pl-0">{{ __('invoices::invoice.total_discount') }}</td>--}}
    {{--            <td class="text-right pr-0">--}}
    {{--                {{ $invoice->formatCurrency($invoice->total_discount) }}--}}
    {{--            </td>--}}
    {{--        </tr>--}}
    {{--    @endif--}}
    {{--    @if($invoice->taxable_amount)--}}
    {{--        <tr>--}}
    {{--            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>--}}
    {{--            <td class="text-right pl-0">{{ __('invoices::invoice.taxable_amount') }}</td>--}}
    {{--            <td class="text-right pr-0">--}}
    {{--                {{ $invoice->formatCurrency($invoice->taxable_amount) }}--}}
    {{--            </td>--}}
    {{--        </tr>--}}
    {{--    @endif--}}
    {{--    @if($invoice->tax_rate)--}}
    {{--        <tr>--}}
    {{--            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>--}}
    {{--            <td class="text-right pl-0">{{ __('invoices::invoice.tax_rate') }}</td>--}}
    {{--            <td class="text-right pr-0">--}}
    {{--                {{ $invoice->tax_rate }}%--}}
    {{--            </td>--}}
    {{--        </tr>--}}
    {{--    @endif--}}
    {{--    @if($invoice->hasItemOrInvoiceTax())--}}
    {{--        <tr>--}}
    {{--            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>--}}
    {{--            <td class="text-right pl-0">{{ __('invoices::invoice.total_taxes') }}</td>--}}
    {{--            <td class="text-right pr-0">--}}
    {{--                {{ $invoice->formatCurrency($invoice->total_taxes) }}--}}
    {{--            </td>--}}
    {{--        </tr>--}}
    {{--    @endif--}}
    {{--    @if($invoice->shipping_amount)--}}
    {{--        <tr>--}}
    {{--            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>--}}
    {{--            <td class="text-right pl-0">{{ __('invoices::invoice.shipping') }}</td>--}}
    {{--            <td class="text-right pr-0">--}}
    {{--                {{ $invoice->formatCurrency($invoice->shipping_amount) }}--}}
    {{--            </td>--}}
    {{--        </tr>--}}
    {{--    @endif--}}
    {{--    <tr>--}}
    {{--        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>--}}
    {{--        <td class="text-right pl-0">{{ __('invoices::invoice.total_amount') }}</td>--}}
    {{--        <td class="text-right pr-0 total-amount">--}}
    {{--            {{ $invoice->formatCurrency($invoice->total_amount) }}--}}
    {{--        </td>--}}
    {{--    </tr>--}}
    </tbody>
</table>

@if($invoice->notes)
    <p>
        {{ __('invoices::invoice.notes') }}: {!! $invoice->notes !!}
    </p>
@endif

<p>
    {{ __('invoices::invoice.amount_in_words') }}: {{ $invoice->getTotalAmountInWords() }}
</p>
<p>
    {{ __('invoices::invoice.pay_until') }}: {{ $invoice->getPayUntilDate() }}
</p>

<script type="text/php">
    if (isset($pdf) && $PAGE_COUNT > 1) {
        $text = "{{ __('invoices::invoice.page') }} {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width);
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
</script>
</body>
</html>
