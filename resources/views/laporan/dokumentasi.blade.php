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
                <span><strong>Beras Sejahtera Tahun {{ now()->year }}</strong></span>
            </p><br><br>
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
                        <div class="img-border" >
                            @if(config('app.env') === 'local')
                                <img class="img-foto" src="./storage/{{ $foto }}" alt="foto" />
                            @else
                                <img class="img-foto" src="{{ asset('storage/' . $foto) }}" alt="foto" />
                            @endif
                        </div>
                    @empty
                        <span></span>
                    @endforelse
                        <div class="m-0" style="font-size: 12px">
                            <p style="margin-top: 30px">
                                Penyaluran pada titik koordinat indonesia : lat. {{ $model->lat }}
                            </p>
                            <p>
                                long. {{ $model->lng . ', ' . $model->keterangan }}
                            </p>
                            <p>{{ 'Watansoppeng, ' . $model->created_at->format('d/m/Y') }}</p>
                            <p style="margin-top: 10px">
                                {{ $model->created_at->format('d/m/Y H:i:s') . ' WITA' }}
                            </p>
                        </div>
                @endif
            </div>
           <div class="page-break"></div>

            <div class="">
                @isset($model->bantuan_rastra->foto_ktp_kk)
                    <div class="">
                        @if(config('app.env') === 'local')
                            <img
                                style="width: 600px"
                                src="./storage/{{ $model->bantuan_rastra->foto_ktp_kk }}"
                                alt="foto"
                            />
                        @else
                            <img
                                style="width: 600px"
                                src="{{ asset('storage/' . $model->bantuan_rastra->foto_ktp_kk) }}"
                                alt="foto"
                            />
                        @endif

                    </div>
                @endif
            </div>
        </div>
    @endsection
</x-layouts.print>
