<?php

namespace App\Imports;

use App\Models\DataPesertaJamkesda as PesertaJamkesda;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\ImportFailed;

class ImportPesertaJamkesda implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue, SkipsEmptyRows
{
    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event) {
                Notification::make('Import Failed')
                    ->title('Gagal Impor Peserta JAMKESDA')
                    ->danger()
                    ->send()
                    ->sendToDatabase(auth()->user());
            },
        ];
    }

    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|\App\Models\UsulanMutasiTmt|null
     */
    public function model(array $row): Model|PesertaJamkesda|null
    {
//        $rt = '';
//        $rw = '';
//        $kec = '';
//        $kel = '';
//        $almt = '';
//
//        $alamat = explode(',', $row['alamat']);
//
//
//        if(!blank($alamat[0])){
//            $alm = explode(' ', $alamat[0]);
//
//            if (!blank($alm[0])) {
//                $almt .= $alm[0];
//            }
//
//            if (!blank($alm[1])) {
//                $almt .= $alm[1];
//            }
//
//            if(!blank($alm[2])){
//                $rtrw = explode('/', $alm[2]);
//                if(!blank($rtrw[0])){
//                    $rt .= $rtrw[0];
//                }
//
//                if (!blank($rtrw[1])) {
//                    $rw .= $rtrw[1];
//                }
//            }
//
//            if (!blank($alm[3])) {
//               $kel = $alm[3];
//            }
//        }
//
//        if(!blank($alamat[1])){
//            $kec = trim($alamat[1]);
//        }
//
//        if (!blank($alamat[2])) {
//            $kab = trim($alamat[2]);
//        }
//
//        $kabupaten = Kabupaten::query()
//            ->where('code', config('custom.default.kodekab'))
//            ->orWhere('name', \Str::upper($kab))
//            ->first()?->code;
//
//        $kecamatan = Kecamatan::query()
//            ->where('kabupaten_code', $kabupaten)
//            ->orWhere('name', \Str::ucfirst($kec))
//            ->first()?->code;
//
//        $kelurahan = Kelurahan::query()
//            ->where('kecamatan_code', $kecamatan)
//            ->where('name', \Str::ucfirst($kel))
//            ->first()?->code;

        return new PesertaJamkesda([
            'nomor_kartu' => $row['no_kartu'] ?? 'NO KARTU',
            'nik' => $row['nik'] ?? 'NO NIK',
            'nama_lengkap' => $row['nama'] ?? 'NO NAME',
            'alamat' => $row['alamat'] ?? 'NO ALAMAT',
            'no_rt' => null,
            'no_rw' => null,
            'kabupaten' => null,
            'kecamatan' => null,
            'kelurahan' => null,
            'dusun' => null,
        ]);
    }

    public function batchSize(): int
    {
        return 5000;
    }

    public function chunkSize(): int
    {
        return 5000;
    }
}
