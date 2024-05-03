@php
    use App\Models\BantuanRastra;use App\Supports\DateHelper;use App\Supports\Helpers;use Carbon\Carbon;
    $nomorBa = Helpers::generateNoSuratBeritaAcara(model: 'ppks');
    $tglBa = Carbon::today()->locale(config('app.locale'));
    $judul = 'Berita Acara S';
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
                <span>Nomor : {{ $nomorBa }}</span>
            </p>
        </div>
        <br />
        <br />
        <br />
        <p style="font-size: 12px">
            Pada hari ini {{ $tglBa->dayName ?? now()->dayName }} Tanggal
            {{ $tglBa->day ?? now()->day }} {{ $tglBa->monthName ?? now()->monthName }}
            {{ $tglBa->year ?? now()->year }} Bertempat di Desa/Kelurahan {{ $record->kel->name }} Dilakukan
            serah terima barang Bantuan Sosial {{ $record->nama_bantuan }}
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
                    {{ $record->nama_lengkap }}
                </td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">NIK</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ $record->nik }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">Jabatan</th>
                <th width="10%" style="text-align: right">:</th>
                <td>
                    Penerima Bantuan
                </td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: right">Instansi</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ 'Kec. ' . $record->kec->name . ', Kel. ' .$record->kel->name }}</td>
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
            menyerahkan Barang Bantuan Sosial {{ $record->nama_bantuan }} Tahun {{ today()->year }} kepada
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
                <th scope="col" class="border-0 text-center">No.</th>
                <th scope="col" class="border-0 text-center">Uraian Jenis Barang/Jasa Lainnya</th>
                <th scope="col" class="border-0 text-center">Kategori PPKS</th>
                <th scope="col" class="border-0 text-center">Jumlah Bantuan</th>
                {{--                <th scope="col" class="border-0 text-center">Harga Satuan (RP)</th>--}}
                {{--                <th scope="col" class="border-0 text-center">Jumlah Harga (Rp)</th>--}}
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">
                    {{ 1 }}
                </td>
                <td class="text-center">
                    {{ $record->nama_bantuan }}
                </td>
                <td class="text-center">
                    {{ $record->tipe_ppks->nama_tipe }}
                </td>
                <td class="text-right">
                    {{ $record->jumlah_bantuan }}
                </td>
                {{--                <td class="text-right">--}}
                {{--                    {{Number::format($item->harga_satuan, 0, locale: 'id') }}--}}
                {{--                </td>--}}
                {{--                <td class="text-right">--}}
                {{--                    {{ Number::format($item->total_harga, 0, locale: 'id') }}--}}
                {{--                </td>--}}
            </tr>
            <tr>
                {{--                <td colspan="2" class="border-0"></td>--}}
                <td colspan="3" class="pl-0 text-right">Total Harga</td>
                <td class="text-right">
                    {{ Number::format($record->jumlah_bantuan, 0, locale: 'id') }}
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
                    {{ $tglBa->year }}
                </td>
                <br />
            </tr>
            <tr>
                <td class="text-center">
                    <b>Penerima</b>
                </td>
                <td class="text-center">
                    <b>Mengetahui</b>
                </td>
            </tr>
            <tr>
                <td class="text-center" style="text-decoration: underline">
                    <br />
                    <br />
                    <br />
                    <b>{{ $record->nama_lengkap ?? '-' }}</b>
                </td>
                <td class="text-center" style="text-decoration: underline">
                    <br />
                    <br />
                    <br />
                    <b>{{ setting('persuratan.nama_kepala_dinas') ?? '-' }}</b>
                </td>
            </tr>
            <tr>
                <td class="text-center"></td>
                <td class="text-center">Pangkat. {{ setting('persuratan.pangkat') }}</td>
            </tr>
            <tr>
                <td class="text-center"></td>
                <td class="text-center">Nip. {{ setting('persuratan.nip_kepala_dinas') ?? '-' }}</td>
            </tr>
            </tbody>
        </table>
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
        <hr>
        <p style="font-size: 12px">
            Lampiran Berita Acara Nomor : {{ $nomorBa }}
        </p>
        <p style="font-size: 12px">
            Tanggal : {{ DateHelper::tanggal() }}
        </p><br><br>
        <div class="text-center">
            <p style="font-size: 12px">
                <span style="text-decoration-line: underline">
                    <strong>
                        {{ Str::upper('DAFTAR PENERIMA MANFAAT BANTUAN SOSIAL PPKS TAHUN ANGGARAN ') . now()->year }}
                    </strong>
                </span>
            </p>
        </div><br>

        <table class="table-items table">
            <thead>
            <tr>
                {{--                <th scope="col" class="border-0 pl-0">No.</th>--}}
                <th scope="col" class="border-0 text-center">Nama Lengkap</th>
                <th scope="col" class="border-0 text-center">KK</th>
                <th scope="col" class="border-0 text-center">NIK</th>
                <th scope="col" class="border-0 text-center">Desa/Kelurahan</th>
                <th scope="col" class="border-0 text-center">Jumlah Bantuan</th>
                <th scope="col" class="border-0 text-center">Tanda Tangan/Cap Jempol</th>
                <th scope="col" class="border-0 text-center">Keterangan</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                {{--                <td class="text-center">{{ $i++ }}</td>--}}
                <td class="text-center">{{ $record->nama_lengkap }}</td>
                <td class="text-center">{{ $record->nokk }}</td>
                <td class="text-center">{{ $record->nik }}</td>
                <td class="text-center">{{ $record->kel()?->first()?->name }}</td>
                <td class="text-center">{{ $record->jumlah_bantuan }}</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td colspan="6" class="pl-0 text-right">Total Jumlah Bantuan</td>
                <td class="text-right">{{ $record->jumlah_bantuan }}</td>
            </tr>
            </tbody>
        </table>

        <table class="table">
            <tbody>
            <tr>
                <td width="60%"></td>
                <td class="text-center">
                    {{ $record->kel->name }}, {{ DateHelper::hariTanggal() }}
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
                    <b>{{ $record->nama_lengkap }}</b>
                </td>
            </tr>
            <tr>
                <td class="text-center">Nip. {{ setting('persuratan.nip_pps') }}</td>
                <td class="text-center">Penerima</td>
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
