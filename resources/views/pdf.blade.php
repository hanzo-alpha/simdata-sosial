<x-layouts.print>
    @section('content')
        <div class="text-center">
            <img src="{{ asset('images/logos/logo-soppeng2.png') }}" alt="logo" height="60">
            <h2 style="margin-bottom: 5px;"><strong>PEMERINTAH KABUPATEN SOPPENG</strong></h2>
            <h1 style="margin-top: 3px;margin-bottom: 5px;"><strong>DINAS SOSIAL</strong></h1>
            {{--                <p style="margin-top: 0">--}}
            {{--                    {{ __('invoices::invoice.address') }}: {{ $invoice->seller->address }}--}}
            {{--                </p>--}}
            <p class="pt-0">
                <span style="font-style: italic">Jalan Salotungo Kel. Lalabata Rilau Kec. Lalabata
                    Watansoppeng</span><br>
                <span style="font-style: italic" class="mt-1">Website : https://dinsos.@soppengkab.go.id/, Email : dinsos01.soppeng@gmail.com</span>
            </p>
            <hr>
            <p style="font-size: 12px;">
                <span><strong>Dokumentasi Penyaluran Bantuan Sosial</strong></span><br>
                <span><strong>Beras Sejahtera Tahun {{ now()->year }}</strong></span>
            </p>
            <p style="text-align: right; font-size: 1.2rem"><span>10</span></p>
            <table class="table">
                <tbody>
                <tr class="pb-0" style="margin-bottom: 0.1rem">
                    <th width="20%" style="text-align: right">NAMA</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>RUDI</td>
                </tr>
                <tr class="pb-0">
                    <th width="20%" style="text-align: right">NIK</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>7312033112710111</td>
                </tr>
                <tr class="pb-0">
                    <th width="20%" style="text-align: right">ALAMAT</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>LOMPULLE RT 01 RW 04</td>
                </tr>
                <tr class="pb-0">
                    <th width="20%" style="text-align: right">DESA/KEL</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>KEBO</td>
                </tr>
                <tr class="pb-0">
                    <th width="20%" style="text-align: right">KECAMATAN</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>LILIRILAU</td>
                </tr>
                <tr class="pb-0">
                    <th width="20%" style="text-align: right">DTKS ID</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>817BB1FF-E6A7-4C11-BBDA-80255EB88359</td>
                </tr>
                </tbody>
            </table>

            <div class="text-center">
                <div style="width: 350px; height: 350px;margin-bottom: 20px;" class="img-border">
                    <img width="300px"
                         src="{{ asset('storage/' . $model->foto_penyerahan) }}"
                         alt="foto"/>
                    <div class="m-0" style="font-size: 12px;">
                        <p style="margin-top: 10px;">Penyaluran pada titik koordinat indonesia : {{ $model->lat }}</p>
                        <p>{{ $model->lng . ', ' . $model->bantuan_rastra->kel->name . ' KEC. ' .
                        $model->bantuan_rastra->kec->name . ' KAB. SOPPENG, '}} </p>
                        <p>{{ 'SULAWESI SELATAN, ' . $model->created_at->format('d/m/Y') }}</p>
                        <p style="margin-top: 40px;">{{ $model->created_at->format('d/m/Y H:i:s') . ' WITA'}}</p>
                    </div>
                </div>

                <div style="width: 350px; height: 350px;" class="img-border">
                    <img width="300px"
                         src="{{ asset('storage/' . $model->foto_ktp_kk) }}"
                         alt="foto"/>
                    <div class="m-0" style="font-size: 12px;">
                        <p style="margin-top: 10px;">Penyaluran pada titik koordinat indonesia : {{ $model->lat }}</p>
                        <p>{{ $model->lng . ', ' . $model->bantuan_rastra->kel->name . ' KEC. ' .
                        $model->bantuan_rastra->kec->name . ' KAB. SOPPENG, '}} </p>
                        <p>{{ 'SULAWESI SELATAN, ' . $model->created_at->format('d/m/Y') }}</p>
                        <p style="margin-top: 40px;">{{ $model->created_at->format('d/m/Y H:i:s') . ' WITA'}}</p>
                    </div>

                </div>

            </div>
        </div>
    @endsection
</x-layouts.print>
