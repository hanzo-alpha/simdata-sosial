@php
    use App\Models\BantuanRastra;use App\Supports\Helpers;
@endphp

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
                <span style="text-decoration-line: underline">
                    <strong>{{ $record->judul_ba ?? Str::upper('Berita Acara Serah Terima Barang') }}</strong>
                </span>
                <br />
                <span>Nomor : {{ $record->nomor_ba ?? Helpers::generateNoSuratBeritaAcara() }}</span>
            </p>
        </div>
        <br />
        <br />
        <br />
        <p style="font-size: 12px">
            Pada hari ini {{ $record->tgl_ba->dayName ?? now()->dayName }} tanggal
            {{ $record->tgl_ba->day ?? now()->day }} {{ $record->tgl_ba->monthName ?? now()->monthName }}
            {{ $record->tgl_ba->year ?? now()->year }} Bertempat di Desa/Kelurahan {{ $record->kel->name }} Dilakukan
            serah terima barang Bantuan Sosial Pangan Beras Sejahtera.
        </p>
        <p style="font-size: 12px">Yang bertanda tangan dibawah ini :</p>
        <table class="table">
            <tbody>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">Nama</th>
                <th width="10%" style="text-align: right">:</th>
                <td width="87%" style="text-align: left">{{ setting('persuratan.nama_pps') }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">NIP</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ setting('persuratan.nip_pps') }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">Jabatan</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ setting('persuratan.jabatan_pps') }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">Instansi</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ setting('persuratan.instansi_pps') }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <td colspan="4">
                    Selanjutnya disebut
                    <b>PIHAK PERTAMA</b>
                </td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">Nama</th>
                <th width="10%" style="text-align: right">:</th>
                <td width="87%" style="text-align: left">
                    {{ $record->penandatangan->nama_penandatangan }}
                </td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">NIP</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ $record->penandatangan->nip }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">Jabatan</th>
                <th width="10%" style="text-align: right">:</th>
                <td>
                    {{ $record->penandatangan->jabatan }}
                </td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">Instansi</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ $record->kel->name }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">Kecamatan</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ $record->kec->name }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <td colspan="4">
                    Selanjutnya disebut
                    <b>PIHAK KEDUA</b>
                </td>
            </tr>
            </tbody>
        </table>
        <p>Untuk kewenangan masing masing dengan ini Para Pihak menyatakan dengan sebenarnya bahwa :</p>
        <p>
            a.
            <b>PIHAK PERTAMA</b>
            menyerahkan Barang Bantuan Sosial Pangan Beras Sejahtera Tahun 2023 kepada
            <b>PIHAK KEDUA</b>
            sebagaimana
            <b>PIHAK KEDUA</b>
            menerima Barang dari
            <b>PIHAK PERTAMA</b>
        </p>
        <br />
        <p>
            b. Jenis, spesifikasi, kuantitas, satuan, harga satuan dan total harga barang / jasa yang diserahterimakan
            sebagai berikut :
        </p>
        <br />
        <br />

        <table class="table-items table">
            <thead>
            <tr>
                <th scope="col" class="text-center">No.</th>
                <th scope="col" class="text-center">Uraian Jenis Barang/Jasa Lainnya</th>
                <th scope="col" class="text-center">Kuantitas</th>
                <th scope="col" class="text-center">Satuan</th>
                <th scope="col" class="text-center">Harga Satuan (RP)</th>
                <th scope="col" class="text-center">Jumlah Harga (Rp)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @php $i = 1; @endphp
                @foreach ($record->itemBantuan as $item)
                    <td class="text-center">
                        {{ $i++ }}
                    </td>
                    <td class="text-center">
                        {{ $item->nama_barang }}
                    </td>
                    <td class="text-center">
                        {{ $item->kuantitas }}
                    </td>
                    <td class="text-center">
                        {{ $item->satuan }}
                    </td>
                    <td class="text-right">
                        {{Number::format($item->harga_satuan, 0, locale: 'id') }}
                    </td>
                    <td class="text-right">
                        {{ Number::format($item->total_harga, 0, locale: 'id') }}
                    </td>
                @endforeach
            </tr>
            <tr>
                <td colspan="4"></td>
                <td class="text-right">Total Harga</td>
                <td class="text-right">
                    {{ Number::format($record->itemBantuan()->sum('total_harga'), 0, locale: 'id') }}
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-center">
                    Terbilang : {{ Str::ucfirst(Number::spell($record->itemBantuan()->sum('total_harga'), 'id')) }}
                    rupiah
                </td>
                <td></td>
            </tr>
            </tbody>
        </table><br>

        <p>
            Demikian Berita Acara Penyerahan Hasil Pekerjaan ini dibuat dalam rangkap secukupnya untuk dipergunakan
            sebagiamana mestinya.
        </p>
        <br />

        <table class="table">
            <tbody>
            <tr>
                <td width="60%"></td>
                <td class="text-center">
                    {{ $record->kel->name }}, {{ now()->dayName }}, {{ now()->day }} {{ now()->monthName }}
                    {{ now()->year }}
                </td>
                <br />
            </tr>
            <tr>
                <td class="text-center">
                    <b>PIHAK PERTAMA</b>
                </td>
                <td class="text-center">
                    <b>PIHAK KEDUA</b>
                </td>
            </tr>
            <tr>
                <td class="text-center" style="text-decoration: underline">
                    <br />
                    <br />
                    <br />
                    <b>{{ setting('persuratan.nama_pps') }}</b>
                </td>
                <td class="text-center" style="text-decoration: underline">
                    <br />
                    <br />
                    <br />
                    <b>{{ $record->penandatangan->nama_penandatangan }}</b>
                </td>
            </tr>
            <tr>
                <td class="text-center">Nip. {{ setting('persuratan.nip_pps') }}</td>
                <td class="text-center">Nip. {{ $record->penandatangan->nip }}</td>
            </tr>
            </tbody>
        </table>
        <p class="text-center">
            <b>MENGETAHUI</b>
        </p>
        <p class="text-center">
            <b>{{ setting('persuratan.jabatan') }}</b>
        </p>
        <br />
        <br />
        <br />
        <p class="text-center">
            <b>{{ setting('persuratan.nama_kepala_dinas') }}</b>
        </p>
        <p class="text-center">Pangkat. {{ setting('persuratan.pangkat') }}</p>
        <p class="text-center">Nip. {{ setting('persuratan.nip_kepala_dinas') }}</p>
        <br>
        <br>
        <br>
        <br>
        <div class="page-break"></div>

        {{-- Lampiran BAST --}}
        @if(setting('ba.kop_layout'))
            @include('laporan.partials.kop')
            <div class="text-center">
        @else
            <div class="text-center">
            @include('laporan.partials.kop-center')
        @endif
        <hr>
        <p style="font-size: 12px; text-align: left">
            Lampiran Berita Acara Nomor : {{ $record->nomor_ba }}
        </p>
        <p style="font-size: 12px; text-align: left">
            Tanggal : {{ $record->tgl_ba->format('d M Y') }}
        </p><br><br>
        <div class="text-center">
            <p style="font-size: 12px">
                <span style="text-decoration-line: underline">
                    <strong>
                        {{ Str::upper('DAFTAR PENERIMA MANFAAT BANTUAN SOSIAL PANGAN TAHUN ANGGARAN ') . now()->year }}
                    </strong>
                </span>
            </p>
        </div><br>

        <table class="table-items table">
            <thead>
            <tr style="border: 2px solid #dee2e6;">
                <th scope="col" class="text-center">No.</th>
                <th scope="col" class="text-center">Nama Lengkap</th>
                <th scope="col" class="text-center">KK</th>
                <th scope="col" class="text-center">NIK</th>
                <th scope="col" class="text-center">Desa/Kelurahan</th>
                <th scope="col" class="text-center">Jumlah Beras</th>
                <th scope="col" class="text-center">Tanda Tangan/Cap Jempol</th>
                <th scope="col" class="text-center">Keterangan</th>
            </tr>
            </thead>
            <tbody>
            @php
                $penerima = BantuanRastra::where('kecamatan',$record->kecamatan)->where('kelurahan',$record->kelurahan)->get();
                $jumlahBeras = ($record->itemBantuan()->get()->sum('kuantitas') / $penerima->count()) /
                $record->itemBantuan()->get()->sum('jumlah_bulan') ;
                $i = 1;
            @endphp
            @forelse($penerima as $kpm)
                <tr style="height: 40px;">
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-left">{{ $kpm->nama_lengkap }}</td>
                    <td class="text-center">{{ $kpm->nokk }}</td>
                    <td class="text-center">{{ $kpm->nik }}</td>
                    <td class="text-center">{{ $kpm->kel()?->first()?->name }}</td>
                    <td class="text-right">{{ $jumlahBeras }} Kg</td>
                    <td class="text-right"></td>
                    <td class="text-center">{{ 'Selama ' . $record->itemBantuan()->first()->jumlah_bulan . ' bulan'}}</td>
                </tr>
            @empty
                <tr>
                    <td></td>
                </tr>
            @endforelse
            <tr>
                <td colspan="5" class="pl-0 text-right">Total Jumlah Beras</td>
                <td class="pr-0 text-right">{{ $record->itemBantuan()->get()->sum('kuantitas') }} Kg</td>
                <td class="pr-0 text-right"></td>
                <td class="pr-0 text-right"></td>
            </tr>
            </tbody>
        </table>

        <table class="table">
            <tbody>
            <tr>
                <td width="60%"></td>
                <td class="text-center">
                    {{ $record->kel->name }}, {{ now()->dayName }}, {{ now()->day }} {{ now()->monthName }}
                    {{ now()->year }}
                </td>
                <br />
            </tr>
            <tr>
                <td class="text-center">
                    <b>PIHAK PERTAMA</b>
                </td>
                <td class="text-center">
                    <b>PIHAK KEDUA</b>
                </td>
            </tr>
            <tr>
                <td class="text-center" style="text-decoration: underline">
                    <br />
                    <br />
                    <br />
                    <b>{{ setting('persuratan.nama_pps') }}</b>
                </td>
                <td class="text-center" style="text-decoration: underline">
                    <br />
                    <br />
                    <br />
                    <b>{{ $record->penandatangan->nama_penandatangan }}</b>
                </td>
            </tr>
            <tr>
                <td class="text-center">Nip. {{ setting('persuratan.nip_pps') }}</td>
                <td class="text-center">Nip. {{ $record->penandatangan->nip }}</td>
            </tr>
            </tbody>
        </table>
        <p class="text-center">
            <b>MENGETAHUI</b>
        </p>
        <p class="text-center">
            <b>{{ setting('persuratan.jabatan') }}</b>
        </p>
        <br />
        <br />
        <br />
        <p class="text-center">
            <b>{{ setting('persuratan.nama_kepala_dinas') }}</b>
        </p>
        <p class="text-center">Pangkat. {{ setting('persuratan.pangkat') }}</p>
        <p class="text-center">Nip. {{ setting('persuratan.nip_kepala_dinas') }}</p>
        <br>
        <br>
        <br>
        <br>
    @endsection
</x-layouts.print>
