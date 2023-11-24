<?php

namespace App\Imports;

use App\Models\BantuanPkhBpnt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BantuanPkhBpntImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function model(array $row): Model|BantuanPkhBpnt|null
    {
//        dd($row);
        return new BantuanPkhBpnt([
            'dtks_id' => $row['IDDTKS'],
            'nokk' => $row['NOKK'],
            'nik_ktp' => $row['NIK_KTP'],
            'nama_penerima' => $row['NAMA_PENERIMA'],
            'kabupaten' => $row['kabupaten'],
            'jumlah_kecamatan' => $row['jumlah_kecamatan'],
            'jumlah_kelurahan' => $row['jumlah_kelurahan'],
            'jumlah_tps' => $row['jumlah_tps'],
            'jumlah_laki' => $row['jumlah_laki'],
            'jumlah_perempuan' => $row['jumlah_perempuan'],
            'total_pemilih' => $row['total'],
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
