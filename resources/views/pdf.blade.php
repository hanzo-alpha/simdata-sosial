<x-layouts.print>
    @section('content')
        <div class="text-center">
            <img src="{{ asset('images/logos/logo-soppeng2.png') }}" alt="logo" height="60" />
            <h2 style="margin-bottom: 5px"><strong>PEMERINTAH KABUPATEN SOPPENG</strong></h2>
            <h1 style="margin-top: 3px; margin-bottom: 5px"><strong>DINAS SOSIAL</strong></h1>
            {{-- <p style="margin-top: 0"> --}}
            {{-- {{ __('invoices::invoice.address') }}: {{ $invoice->seller->address }} --}}
            {{-- </p> --}}
            <p class="pt-0">
                <span style="font-style: italic">Jalan Salotungo Kel. Lalabata Rilau Kec. Lalabata Watansoppeng</span>
                <br />
                <span style="font-style: italic" class="mt-1">
                    Website : https://dinsos.@soppengkab.go.id/, Email : dinsos01.soppeng@gmail.com
                </span>
            </p>
            <hr />
            <p style="font-size: 12px">
                <span><strong>Dokumentasi Penyaluran Bantuan Sosial</strong></span>
                <br />
                <span><strong>Beras Sejahtera Tahun {{ now()->year }}</strong></span>
            </p>
            <p style="text-align: right; font-size: 1.2rem"><span>{{ $model->id }}</span></p>
            <table class="table">
                <tbody>
                    <tr class="pb-0" style="margin-bottom: 0.1rem">
                        <th width="20%" style="text-align: right">NAMA</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ Str::upper($model->bantuan_rastra->nama_lengkap) }}</td>
                    </tr>
                    <tr class="pb-0">
                        <th width="20%" style="text-align: right">NIK</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ $model->bantuan_rastra->nik }}</td>
                    </tr>
                    <tr class="pb-0">
                        <th width="20%" style="text-align: right">ALAMAT</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ Str::upper($model->bantuan_rastra->alamat) }}</td>
                    </tr>
                    <tr class="pb-0">
                        <th width="20%" style="text-align: right">DESA/KEL</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ Str::upper($model->bantuan_rastra->kel->name) }}</td>
                    </tr>
                    <tr class="pb-0">
                        <th width="20%" style="text-align: right">KECAMATAN</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ Str::upper($model->bantuan_rastra->kec->name) }}</td>
                    </tr>
                    <tr class="pb-0">
                        <th width="20%" style="text-align: right">STATUS DTKS</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ $model->bantuan_rastra->status_dtks->getLabel() }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="text-center" style="padding-top: 20px">
                @if ($model->count() > 0)
                    @forelse ($model->foto_penyerahan as $foto)
                        <div
                            style="width: 400px; height: 500px; padding: 5px; margin-bottom: 5px; margin-top: 10px"
                            class="img-border"
                        >
                            <img style="width: 300px" src="{{ asset('storage/' . $foto) }}" alt="foto" />
                            <div class="m-0" style="font-size: 10px">
                                <p style="margin-top: 30px">
                                    Penyaluran pada titik koordinat indonesia : {{ $model->lat }}
                                </p>
                                <p>
                                    {{
                                        $model->lng .
                                            ', ' .
                                            $model->bantuan_rastra->kel->name .
                                            ' KEC. ' .
                                            $model->bantuan_rastra->kec->name .
                                            ' KAB. SOPPENG, '
                                    }}
                                </p>
                                <p>{{ 'SULAWESI SELATAN, ' . $model->created_at->format('d/m/Y') }}</p>
                                <p style="margin-top: 10px">
                                    {{
                                        $model->created_at->format('d/m/Y H:i:s') .
                                            '
                                                                                                                                                        WITA'
                                    }}
                                </p>
                            </div>
                        </div>
                    @empty

                    @endforelse
                @endif
            </div>
            <br />

            <div class="">
                @isset($model->bantuan_rastra->foto_ktp_kk)
                    <div class="">
                        <img
                            style="width: 600px"
                            src="{{ asset('storage/' . $model->bantuan_rastra->foto_ktp_kk) }}"
                            alt="foto"
                        />
                    </div>
                @endif
            </div>
        </div>
    @endsection
</x-layouts.print>
