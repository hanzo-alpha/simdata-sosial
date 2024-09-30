<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Cetak Dokumen</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <style type="text/css" media="screen">
            html {
                font-family: sans-serif;
                line-height: 1.15;
                margin: 0;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans',
                    sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                text-align: left;
                background-color: #fff;
                font-size: 10px;
                margin: 36pt;
            }

            hr {
                display: block;
                height: 3px;
                border: 0;
                border-top: 3px solid #050505;
                margin: 1em auto;
                padding: 0;
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
                margin-bottom: 0.2rem;
            }

            strong {
                font-weight: bolder;
            }

            img {
                /*display: block;*/
                margin: 0 auto;
                /*vertical-align: middle;*/
                border-style: none;
            }

            table {
                border-collapse: collapse;
                border: 0.6rem;
            }

            th {
                text-align: inherit;
            }

            h4,
            .h4 {
                margin-bottom: 0.5rem;
                font-weight: 500;
                line-height: 1.2;
            }

            h4,
            .h4 {
                font-size: 1.5rem;
            }

            h5,
            .h5 {
                margin-bottom: 0.5rem;
                font-weight: 200;
                line-height: 1.2;
            }

            h5,
            .h5 {
                font-size: 0.3rem;
            }

            .table {
                /*table-layout: fixed;*/
                width: 100%;
                margin-bottom: 0.6rem;
                color: #212529;
            }

            ol li {
                padding: 5px;
                margin-left: -24px;
            }

            .table th,

            .table td {
                padding: 0.3rem;
                vertical-align: middle;
            }

            .table.table-items td {
                border-top: 2px solid #dee2e6;
                border-bottom: 2px solid #dee2e6;
                border-left: 2px solid #dee2e6;
                border-right: 2px solid #dee2e6;
                padding: 0.6rem;
            }

            .table thead th {
                vertical-align: middle;
                border-top: 2px solid #dee2e6;
                border-bottom: 2px solid #dee2e6;
                border-left: 2px solid #dee2e6;
                border-right: 2px solid #dee2e6;
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
                font-family: 'DejaVu Sans', serif;
            }

            body,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            table,
            th,
            tr,
            td,
            p,
            div {
                line-height: 1.1;
            }

            .total-amount {
                font-size: 11px;
                font-weight: 700;
            }

            .border-0 {
                border: none !important;
            }

            .cool-gray {
                color: #6b7280;
            }

            .img-foto {
                max-width: 350px;
            }

            .img-border {
                align-content: center;
                align-items: center;
                /*border: 2px solid #555;*/
                /*width: 800px;*/
                /*height: 500px;*/
                padding: 5px;
                margin: 5px auto 5px;
                max-width: inherit;
            }

            .page-break {
                page-break-after: always;
            }

            div.page {
                margin: 10px auto;
                border: solid 1px black;
                display: block;
                page-break-after: always;
                width: 209mm;
                height: 296mm;
                overflow: hidden;
                background: white;
            }

            div.landscape-parent {
                width: 296mm;
                height: 209mm;
            }

            div.landscape {
                width: 296mm;
                height: 209mm;
            }

            div.content {
                padding: 10mm;
            }
        </style>
    </head>

    <body>
        {{-- Header --}}
        @yield('content')

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
