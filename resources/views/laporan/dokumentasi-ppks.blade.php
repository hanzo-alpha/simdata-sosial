<x-layouts.print>
    @section('content')
        @if(setting('ba.kop_layout'))
            @include('laporan.partials.kop')
            <div class="text-center">
        @else
            <div class="text-center">
                @include('laporan.partials.kop-center')
        @endif
            <hr />
            <p style="font-size: 12px">
                <span><strong>Dokumentasi Penyaluran Bantuan Sosial</strong></span>
                <br />
                <span><strong>{{ $model->bantuan_ppks?->nama_bantuan }} Tahun {{ now()->year }}</strong></span>
            </p>
            <p style="text-align: right; font-size: 1.2rem"><span>{{ $model->id }}</span></p>
            <table class="table">
                <tbody>
                    <tr class="pb-0" style="margin-bottom: 0.1rem">
                        <th width="20%" style="text-align: right">NAMA</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ Str::upper($model->bantuan_ppks?->nama_lengkap) }}</td>
                    </tr>
                    <tr class="pb-0">
                        <th width="20%" style="text-align: right">NIK</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ $model->bantuan_ppks?->nik }}</td>
                    </tr>
                    <tr class="pb-0">
                        <th width="20%" style="text-align: right">ALAMAT</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ Str::upper($model->bantuan_ppks?->alamat) }}</td>
                    </tr>
                    <tr class="pb-0">
                        <th width="20%" style="text-align: right">DESA/KEL</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ Str::upper($model->bantuan_ppks?->kel->name) }}</td>
                    </tr>
                    <tr class="pb-0">
                        <th width="20%" style="text-align: right">KECAMATAN</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ Str::upper($model->bantuan_ppks?->kec->name) }}</td>
                    </tr>
                    <tr class="pb-0">
                        <th width="20%" style="text-align: right">STATUS DTKS</th>
                        <th width="10%" style="text-align: right">:</th>
                        <td>{{ $model->bantuan_ppks?->status_dtks->getLabel() }}</td>
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
                                            $model->bantuan_ppks->kel->name .
                                            ' KEC. ' .
                                            $model->bantuan_ppks->kec->name .
                                            ' KAB. SOPPENG, '
                                    }}
                                </p>
                                <p>{{ 'SULAWESI SELATAN, ' . $model->created_at->format('d/m/Y') }}</p>
                                <p style="margin-top: 10px">
                                    {{
                                        $model->created_at->format('d/m/Y H:i:s') . ' WITA'
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
                @isset($model->bantuan_ppks->bukti_foto)
                    <div class="">
                        <img
                            style="width: 600px"
                            src="{{ asset('storage/' . $model->bantuan_ppks->bukti_foto) }}"
                            alt="foto"
                        />
                    </div>
                @endif
            </div>
        </div>
    @endsection
</x-layouts.print>
