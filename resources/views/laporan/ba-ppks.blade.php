@php
    use App\Models\BantuanRastra;use App\Supports\DateHelper;use App\Supports\Helpers;use Carbon\Carbon;
    $nomorBa = Helpers::generateNoSuratBeritaAcara(model: 'ppks');
    $tglBa = $record->tgl_ba ?? now();
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
                    <strong>{{ $record->judul_ba ?? Str::upper(setting('ba.kop_ba', 'Berita Acara Serah Terima Barang')) }}</strong>
                </span>
                <br />
                <span>Nomor : {{ $nomorBa }}</span>
            </p>
        </div>
        <br />
        <br />
        <p style="font-size: 12px">
            Pada hari ini {{ $tglBa->dayName ?? now()->dayName }} Tanggal
            {{ tanggal_ke_kalimat($tglBa->format('Y-m-d') ?? now()->format('Y-m-d')) }}  Bertempat di Desa/Kelurahan
            <b>{{ \Illuminate\Support\Str::upper($record->kel->name) }}</b> Dilakukan serah terima Alat Bantu berupa
            {{ Str::title($record->barang?->nama_barang) ?? $record->nama_bantuan }} kepada para
            {{ \Illuminate\Support\Str::title($record->tipe_ppks?->nama_tipe) ?? 'Penyandang Disabilitas' }}.
        </p><br />
        <p style="font-size: 12px">Yang bertanda tangan dibawah ini :</p>
        <table style="font-size: 12px" class="table">
            <tbody>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: left">1. Nama</th>
                <th width="10%" style="text-align: right">:</th>
                <td width="87%" style="text-align: left"><b>{{ setting('persuratan.nama_kepala_dinas') }}</b></td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: left">2. NIP</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ setting('persuratan.nip_kepala_dinas') }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: left">3. Jabatan</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ setting('persuratan.jabatan') }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: left">4. Instansi</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ setting('persuratan.instansi_ppk') }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <td colspan="4">
                    <span style="font-size: 12px">Selanjutnya disebut <b>PIHAK KESATU</b></span>
                </td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: left">1. Nama</th>
                <th width="10%" style="text-align: right">:</th>
                <td width="87%" style="text-align: left">
                    {{ $record->nama_lengkap }}
                </td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: left">2. NIK</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ $record->nik }}</td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: left">3. Alamat</th>
                <th width="10%" style="text-align: right">:</th>
                <td>
                    {{ $record->alamat }}
                </td>
            </tr>
            <tr class="pb-0">
                <th width="5%" style="text-align: left"></th>
                <th width="20%" style="text-align: left">4. Desa/Kelurahan</th>
                <th width="10%" style="text-align: right">:</th>
                <td>{{ \Illuminate\Support\Str::upper($record->kel->name) }}</td>
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
        <p style="font-size: 12px">Untuk kewenangan masing masing dengan ini Para Pihak menyatakan dengan sebenarnya bahwa :</p>
        <ol type="a" style="font-size: 12px;">
            <li>
                <b>PIHAK KESATU</b>
                menyerahkan Alat Bantu berupa {{ Str::title($record->barang?->nama_barang) ?? $record->nama_bantuan }} kepada para
                Penyandang Disabilitas
{{--                {{ \Illuminate\Support\Str::title($record->tipe_ppks?->nama_tipe) ?? 'Penyandang Disabilitas' }}--}}
                Tahun {{ today()->year }} kepada
                <b>PIHAK KEDUA</b>
                sebagaimana <b>PIHAK KEDUA</b>
                menerima Alat Bantu dari
                <b>PIHAK KESATU</b>.
            </li>
            <li>
                Jenis, spesifikasi, kriteria, dan jumlah barang / jasa yang diserahterimakan sebagai berikut :
            </li>
        </ol>
        <br />

        <table style="font-size: 12px" class="table-items table">
            <thead>
            <tr>
                <th scope="col" class="text-center">No.</th>
                <th scope="col" class="text-center">Uraian Jenis Barang/Jasa Lainnya</th>
                <th scope="col" class="text-center">Satuan</th>
                <th scope="col" class="text-center">Kuantitas</th>
                <th scope="col" class="text-right">Harga Satuan (Rp)</th>
                <th scope="col" class="text-right">Jumlah Harga (Rp)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">
                    {{ 1 }}
                </td>
                <td class="text-center">
                    {{ $record->barang?->nama_barang ?? $record->nama_bantuan }}
                </td>
                <td class="text-center">
                    {{ $record->barang?->satuan ?? 'Unit' }}
                </td>
                <td class="text-center">
                    {{ $record->barang?->kuantitas ?? 1 }}
                </td>
                <td class="text-right">
                    {{ Number::format($record->barang?->harga_satuan ?? 0, 0, locale: 'id') }}
                </td>
                <td class="text-right">
                    {{ Number::format($record->barang?->total_harga ?? 0, 0, locale: 'id') }}
                </td>
            </tr>
            <tr>
                <td colspan="5" class="pl-0 text-right"><strong>Total Harga (Rp)</strong></td>
                <td class="text-right">
                    <strong>{{ Number::format($record->barang?->total_harga ?? 0, 0, locale: 'id') }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="6" class="text-center">
                    <b>Terbilang : {{ Str::ucfirst(Number::spell($record->barang?->total_harga ?? 0, 'id')) }}
                        rupiah</b>
                </td>
            </tr>
            </tbody>
        </table><br />

        <p style="font-size: 12px">
            Demikian Berita Acara Penyerahan Hasil Pekerjaan ini dibuat dalam rangkap secukupnya untuk dipergunakan
            sebagaimana mestinya.
        </p>
        <br />
        <br />

        <table style="font-size: 12px" class="table">
            <tbody>
            <tr>
                <td style="padding: 0.1rem" class="text-center">
                    <b>PIHAK KESATU</b>
                </td>
                <td style="padding: 0.1rem" class="text-center">
                    <b>MENGETAHUI</b>
                </td>
                <td style="padding: 0.1rem" class="text-center">
                    <b>PIHAK KEDUA</b>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    {{ setting('persuratan.instansi_pps') }}
                </td>
                <td class="text-center">
                    KEPALA DESA/KELURAHAN
                </td>
                <td class="text-center">
                    PENERIMA MANFAAT
                </td>
            </tr>
            <tr>
                <td class="text-center" style="text-decoration: underline">
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <b>{{ setting('persuratan.nama_kepala_dinas') }}</b>
                </td>
                <td class="text-center" style="text-decoration: underline">
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <b>{{ $record->penandatangan?->nama_penandatangan ?? 'Belum ada penandatangan'}}</b>
                </td>
                <td class="text-center" style="text-decoration: underline">
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <b>{{ $record->nama_lengkap  }}</b>
                </td>
            </tr>
            <tr>
                <td class="text-center pl-0">
                    <span>Nip. {{ setting('persuratan.nip_kepala_dinas') }}</span>
                </td>
                <td class="text-center pl-0">
                    <span>Nip. {{ $record->penandatangan?->nip ?? '-'}}</span>
                </td>
                <td class="text-center" style="text-decoration: underline">
{{--                    <b>Nik. {{ $record->nik }}</b>--}}
                </td>
            </tr>
            </tbody>
        </table>
    @endsection
</x-layouts.print>
