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
                <span>
                    <strong>
                        {{ \Illuminate\Support\Str::of($model->bantuan_ppks?->tipe_ppks?->nama_tipe)->lower()->ucfirst() ??
                        'Penyandang Disabilitas' }} Tahun {{ now()->year}}
                    </strong>
                </span>
            </p><br />
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
                        <div class="img-border">
                            @env('production')
                                <img class="img-foto-ppks" src="{{ asset('storage/' . $foto) }}" alt="foto" />
                            @endenv
                            @env('local')
                                <img class="img-foto-ppks" src="{{ public_path('storage/' . $foto) }}" alt="foto" />
                            @endenv
                        </div>
                    @empty
                    <div></div>
                    @endforelse
                        <div class="m-0" style="font-size: 10px">
                            <p style="margin-top: 30px">
                                Penyaluran pada titik koordinat indonesia : {{ $model->lat }}
                            </p>
                            <p>
                                {{
                                    $model->lng .
                                        ', ' .
                                        $model->bantuan_ppks->kel->name .
                                        ' Kec. ' .
                                        $model->bantuan_ppks->kec->name .
                                        ' KAB. SOPPENG '
                                }}
                            </p>
                            <p>
                                {{
                                    $model->tgl_penyerahan->format('d/m/Y H:i:s') . ' WITA'
                                }}
                            </p>
                        </div>
                @endif
            </div>
            <br />

            <div >
                @isset($model->bantuan_ppks->bukti_foto)
                    @foreach($model->bantuan_ppks->bukti_foto as $foto)
                        <div>
                            @env('production')
                                <img style="width: 600px" src="{{ asset('storage/' . $foto) }}" alt="foto" />
                            @endenv
                            @env('local')
                                <img style="width: 600px" src="{{ public_path('storage/' . $foto) }}" alt="foto" />
                            @endenv
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endsection
</x-layouts.print>
