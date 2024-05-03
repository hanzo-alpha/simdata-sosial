@php
    use App\Models\BantuanRastra;use App\Supports\Helpers;
@endphp

<x-layouts.print>
    @section('content')
        <table class="table border-0">
            <tbody>
            <th class="text-center" rowspan="3">
                <img style="align-items: center; align-content: center;"
                     src="{{ asset('images/logos/logo-soppeng2.png') }}"
                     alt="logo"
                     height="100" />
            </th>
            <th class="text-center">
                <h2 style="margin-bottom: 0"><strong>{{ setting('ba.kop_title') }}</strong></h2></th>
            </tbody>
            <tbody>
            <th class="text-center">
                <h1 style="margin-top: 3px; margin-bottom: 3px"><strong>{{ setting('ba.kop_instansi') }}</strong></h1>
            </th>
            </tbody>
            <tbody>
            <th class="text-center">
                 <span style="font-style: italic">
                    {{ setting('ba.kop_jalan') }}
                 </span><br>
                <span style="font-style: italic">
                     {{ setting('ba.kop_website') }}
                </span>
            </th>
            </tbody>
        </table>
        <div class="text-center">
            {{--            <h2 style="margin-bottom: 5px">--}}
            {{--                <img src="{{ asset('images/logos/logo-soppeng2.png') }}" alt="logo" height="60" />--}}
            {{--                <strong>PEMERINTAH KABUPATEN SOPPENG</strong></h2>--}}
            {{--            <h1 style="margin-top: 3px; margin-bottom: 5px"><strong>DINAS SOSIAL</strong></h1>--}}
            {{--            <p class="pt-0">--}}
            {{--                <span style="font-style: italic">Jalan Salotungo Kel. Lalabata Rilau Kec. Lalabata Watansoppeng</span>--}}
            {{--                <br />--}}
            {{--                <span style="font-style: italic" class="mt-1">--}}
            {{--                    Website : https://dinsos.@soppengkab.go.id/, Email : dinsos01.soppeng@gmail.com--}}
            {{--                </span>--}}
            {{--            </p>--}}
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
            Pada hari ini {{ $record->tgl_ba->dayName ?? now()->dayName }} Tanggal
            {{ $record->tgl_ba->day ?? now()->day }} {{ $record->tgl_ba->monthName ?? now()->monthName }}
            {{ $record->tgl_ba->year ?? now()->year }} Bertempat di Desa/Kelurahan {{ $record->kel->name }} Dilakukan
            serah terima barang Bantuan Sosial Pangan Beras Sejahtera
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
        <br />

        <table class="table-items table">
            <thead>
            <tr>
                <th scope="col" class="border-0 pl-0">No.</th>
                <th scope="col" class="border-0 text-center">Uraian Jenis Barang/Jasa Lainnya</th>
                <th scope="col" class="border-0 text-center">Kuantitas</th>
                <th scope="col" class="border-0 text-center">Satuan</th>
                <th scope="col" class="border-0 text-center">Harga Satuan (RP)</th>
                <th scope="col" class="border-0 text-center">Jumlah Harga (Rp)</th>
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
                <td colspan="4" class="border-0"></td>
                <td class="pl-0 text-right">Total Harga</td>
                <td class="pr-0 text-right">
                    {{ Number::format($record->itemBantuan()->sum('total_harga'), 0, locale: 'id') }}
                </td>
            </tr>
            <tr>
                <td colspan="5" class="border-0 text-center">
                    Terbilang : {{ Str::ucfirst(Number::spell($record->itemBantuan()->sum('total_harga'), 'id')) }}
                    rupiah
                </td>
            </tr>
            </tbody>
        </table>

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
        <table class="table border-0">
            <tbody>
            <th class="text-center" rowspan="3">
                <img style="align-items: center; align-content: center;"
                     src="{{ asset('images/logos/logo-soppeng2.png') }}"
                     alt="logo"
                     height="100" />
            </th>
            <th class="text-center">
                <h2 style="margin-bottom: 0"><strong>PEMERINTAH KABUPATEN SOPPENG</strong></h2></th>
            </tbody>
            <tbody>
            <th class="text-center">
                <h1 style="margin-top: 3px; margin-bottom: 3px"><strong>DINAS SOSIAL</strong></h1>
            </th>
            </tbody>
            <tbody>
            <th class="text-center">
                 <span style="font-style: italic">
                    Jalan Salotungo Kel. Lalabata Rilau Kec. Lalabata Watansoppeng
                 </span><br>
                <span style="font-style: italic">
                    Website : https://dinsos.@soppengkab.go.id/, Email : dinsos01.soppeng@gmail.com
                </span>
            </th>
            </tbody>
        </table>
        <hr>
        <p style="font-size: 12px">
            Lampiran Berita Acara Nomor : {{ $record->nomor_ba }}
        </p>
        <p style="font-size: 12px">
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
            <tr>
                <th scope="col" class="border-0 pl-0">No.</th>
                <th scope="col" class="border-0 text-center">Nama Lengkap</th>
                <th scope="col" class="border-0 text-center">KK</th>
                <th scope="col" class="border-0 text-center">NIK</th>
                <th scope="col" class="border-0 text-center">Desa/Kelurahan</th>
                <th scope="col" class="border-0 text-center">Jumlah Beras</th>
                <th scope="col" class="border-0 text-center">Tanda Tangan/Cap Jempol</th>
                <th scope="col" class="border-0 text-center">Keterangan</th>
            </tr>
            </thead>
            <tbody>
            @php
                $penerima = BantuanRastra::where('kecamatan',$record->kecamatan)->where('kelurahan',$record->kelurahan)->get();
                $jumlahBeras = $record->itemBantuan()->get()->sum('kuantitas') / $penerima->count();
                $i = 1;
            @endphp
            @forelse($penerima as $kpm)
                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-left">{{ $kpm->nama_lengkap }}</td>
                    <td class="text-center">{{ $kpm->nokk }}</td>
                    <td class="text-center">{{ $kpm->nik }}</td>
                    <td class="text-center">{{ $kpm->kel()?->first()?->name }}</td>
                    <td class="text-right">{{ $jumlahBeras }} Kg</td>
                    <td class="text-right"></td>
                    <td class="text-right"></td>
                </tr>
            @empty
                <tr>
                    <td></td>
                </tr>
            @endforelse
            <tr>
                <td colspan="5" class="pl-0 text-right">Total Jumlah Beras</td>
                <td class="pr-0 text-right">{{ $record->itemBantuan()->get()->sum('kuantitas') }} Kg</td>
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
