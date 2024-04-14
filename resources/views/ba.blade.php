@php
    use App\Supports\Helpers;
@endphp

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
                    <td width="87%" style="text-align: left">IRFAN SANJAYA, S.STP, M.Si</td>
                </tr>
                <tr class="pb-0">
                    <th width="5%" style="text-align: left"></th>
                    <th width="20%" style="text-align: right">NIP</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>19840118 200212 1 001</td>
                </tr>
                <tr class="pb-0">
                    <th width="5%" style="text-align: left"></th>
                    <th width="20%" style="text-align: right">Jabatan</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>KEPALA BIDANG PERLINDUNGAN DAN JAMINAN SOSIAL</td>
                </tr>
                <tr class="pb-0">
                    <th width="5%" style="text-align: left"></th>
                    <th width="20%" style="text-align: right">Instansi</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>DINAS SOSIAL KAB. SOPPENG</td>
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
                        {{ $record->nama_lengkap ?? $record->bantuan_rastra->nama_lengkap }}
                    </td>
                </tr>
                <tr class="pb-0">
                    <th width="5%" style="text-align: left"></th>
                    <th width="20%" style="text-align: right">NIP</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>{{ $record->penandatangan->nip ?? $record->bantuan_rastra->nama_lengkap }}</td>
                </tr>
                <tr class="pb-0">
                    <th width="5%" style="text-align: left"></th>
                    <th width="20%" style="text-align: right">Jabatan</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>
                        {{ $record->penandatangan->jabatan ?? $record->bantuan_rastra->nama_lengkap }}
                    </td>
                </tr>
                <tr class="pb-0">
                    <th width="5%" style="text-align: left"></th>
                    <th width="20%" style="text-align: right">Instansi</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>{{ $record->kode_instansi ?? $record->bantuan_rastra->kelurahan }}</td>
                </tr>
                <tr class="pb-0">
                    <th width="5%" style="text-align: left"></th>
                    <th width="20%" style="text-align: right">Kecamatan</th>
                    <th width="10%" style="text-align: right">:</th>
                    <td>{{ $record->kode_kecamatan ?? $record->bantuan_rastra->kecamatan }}</td>
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
                    @foreach ($record->itemBantuan as $item)
                        <td class="text-center">
                            {{ $item->id }}
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
                            {{ $item->harga_satuan }}
                        </td>
                        <td class="text-right">
                            {{ $item->total_harga }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td colspan="4" class="border-0"></td>
                    <td class="pl-0 text-right">Total Harga</td>
                    <td class="pr-0 text-right">
                        {{ $record->itemBantuan()->sum('total_harga') }}
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
                        <b>IRFAN SANJAYA, S.STP, M.Si</b>
                    </td>
                    <td class="text-center" style="text-decoration: underline">
                        <br />
                        <br />
                        <br />
                        <b>{{ $record->penandatangan->nama_penandatangan }}</b>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Nip. 19840118 200212 1 001</td>
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
    @endsection
</x-layouts.print>
