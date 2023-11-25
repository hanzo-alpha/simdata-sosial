<?php

namespace App\Imports;

use App\Enums\StatusPkhBpntEnum;
use App\Models\BantuanPkh as DataPkh;
use App\Models\JenisBantuan;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportBantuanPkh implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|\App\Models\BantuanPkh|null
     */
    public function model(array $row): Model|DataPkh|null
    {
        $provinsi = Provinsi::query()->where('name', \Str::ucfirst($row['nama_prop']))->first()->code;
        $kabupaten = Kabupaten::query()->where('name', \Str::ucfirst($row['nama_kab']))->first()->code;
        $kecamatan = Kecamatan::query()->where('name', \Str::ucfirst($row['nama_kec']))->first()->code;
        $kelurahan = Kelurahan::query()->where('name', \Str::ucfirst($row['nama_kel']))->first()->code;

        $jenisBantuan = JenisBantuan::where('alias', \Str::upper($row['bansos']))->first()->id;
        return new DataPkh([
            'dtks_id' => $row['iddtks'],
            'nokk' => $row['nokk'],
            'nik_ktp' => $row['nik_ktp'],
            'nama_penerima' => $row['nama_penerima'],
            'provinsi' => $provinsi ?? $row['nama_prop'],
            'kabupaten' => $kabupaten ?? $row['nama_kab'],
            'kecamatan' => $kecamatan ?? $row['nama_kec'],
            'kelurahan' => $kelurahan ?? $row['nama_kel'],
            'kode_wilayah' => $row['kode_wilayah'],
            'tahap' => $row['tahap'],
            'bansos' => $row['bansos'],
            'bank' => $row['bank'],
            'jenis_bantuan_id' => $jenisBantuan ?? 1,
            'alamat' => $row['alamat'],
            'no_rt' => $row['no_rt'],
            'no_rw' => $row['no_rw'],
            'dusun' => $row['dusun'],
            'dir' => $row['dir'],
            'gelombang' => $row['gelombang'],
            'nominal' => $row['nominal'],
            'status_pkh' => StatusPkhBpntEnum::PKH,
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
