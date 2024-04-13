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
        </div>
        <p style="font-size: 12px">
            Pada hari ini {{ now()->dayName }} Tanggal {{ now()->day }} {{ now()->monthName }} {{ now()->year }}
            Bertempat di Desa Citta Dilakukan serah terima barang Bantuan Sosial Pangan Beras Sejahtera
        </p>
        <div class="text-center">
            <p style="font-size: 12px">
                <span style="text-decoration-line: underline">
                    <strong>{{ Str::upper('Berita Acara Serah Terima Barang') }}</strong>
                </span>
                <br />
                <span>Nomor : {{ Helpers::generateNoSuratBeritaAcara() }}</span>
            </p>
        </div>
        <p style="font-size: 12px">Yang bertanda tangan dibawah ini :</p>
        <table class="table">
            <tbody>
                <tr class="pb-0">
                    <th width="5%" style="text-align: left">1</th>
                    <th width="20%" style="text-align: left">NAMA</th>
                    <th width="10%" style="text-align: left">:</th>
                    <td width="87%" style="text-align: left">RUDI</td>
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
                    <td class="text-center">1</td>
                    <td class="text-center">Beras Premium</td>
                    <td class="text-center">600</td>
                    <td class="text-center">Kg</td>
                    <td class="text-right">12.000</td>
                    <td class="text-right">7.200.000</td>
                </tr>
                <tr>
                    <td colspan="4" class="border-0"></td>
                    <td class="pl-0 text-right">Total Harga</td>
                    <td class="pr-0 text-right">0</td>
                </tr>
                <tr>
                    <td colspan="5" class="border-0 text-center">
                        Terbilang : {{ Str::ucfirst(Number::spell(720000, 'id')) }} rupiah
                    </td>
                </tr>
            </tbody>
        </table>

        <p>
            Demikian Berita Acara Penyerahan Hasil Pekerjaan ini dibuat dalam rangkap secukupnya untuk dipergunakan
            sebagiamana mestinya.
        </p>

        <table class="table">
            <tbody>
                <tr>
                    <td width="60%"></td>
                    <td class="text-center">
                        Citta, {{ now()->dayName }}, {{ now()->day }} {{ now()->monthName }} {{ now()->year }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Disetujui Oleh</td>
                    <td class="text-center">Mengetahui</td>
                </tr>
                <tr>
                    <td class="text-center">Kepala Desa Citta</td>
                    <td class="text-center">Kepala Dinas</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <br />
                        <br />
                        <br />
                        <b>RUDI, S. Pd</b>
                    </td>
                    <td class="text-center">
                        <br />
                        <br />
                        <br />
                        <b>RUDI, S. Pd</b>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">NIP. 7312033112710111</td>
                    <td class="text-center">NIP. 7312033112710111</td>
                </tr>
            </tbody>
        </table>
        <p class="text-center">
            <b>Mengetahui</b>
        </p>
        <p class="text-center">
            <b>Kepala Desa Citta</b>
        </p>
        <p class="text-center">
            <b>RUDI, S. Pd</b>
        </p>
        <p class="text-center">NIP. 7312033112710111</p>
    @endsection
</x-layouts.print>
