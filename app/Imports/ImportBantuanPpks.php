<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\BantuanPpks as DataPpks;
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
use Str;

final class ImportBantuanPpks implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|\App\Models\BantuanPkh|null
     */
    public function model(array $row): Model|DataPpks|null
    {
        $provinsi = Provinsi::query()->where('name', Str::ucfirst($row['nama_prop']))->first()->code;
        $kabupaten = Kabupaten::query()->where('name', Str::ucfirst($row['nama_kab']))->first()->code;
        $kecamatan = Kecamatan::query()->where('name', Str::ucfirst($row['nama_kec']))->first()->code;
        $kelurahan = Kelurahan::query()->where('name', Str::ucfirst($row['nama_kel']))->first()->code;

        $jenisBantuan = JenisBantuan::where('alias', Str::upper($row['bansos']))->first()->id;
        $ttl = explode(',', $row['tempat_tanggal_lahir']);
        if (isset($ttl[0])) {
            $tempat = $ttl[0];
        }

        if (isset($ttl[1])) {
            $tgl = $ttl[1];
        }

        return new DataPpks([
            'nama_lengkap' => $row['nama_lengkap'],
            'nik' => $row['nik'],
            'nokk' => $row['no_kk'],
            'status_kawin' => $row['status_pernikahan'],
            'hubungan_keluarga_id' => $row['hubungan_keluarga'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tempat_lahir' => $tempat ?? '-',
            'tgl_lahir' => $tgl ?? now()->format('Y-m-d'),
            'alamat.alamat' => $row['alamat_lengkap'],
            'kecamatan' => $kecamatan ?? $row['nama_kec'],
            'kelurahan' => $kelurahan ?? $row['nama_kel'],
            'pendidikan_terakhir_id' => $row['pendidikan_terakhir'],
            'sub_jenis_disabilitas' => $row['jenis_ppks'],
            'nama_ibu_kandung' => $row['nama_ibu_kandung'],
            'jenis_pekerjaan_id' => $row['pekerjaan'],
            'penghasilan_rata_rata' => $row['penghasilan_rata_rata_perbulan'],
            'bantuan_yang_pernah_diterima' => $row['bantuan_sosial_yang_pernah_diterima'],
            'status_rumah_tinggal' => $row['rumah_tinggal'],
            'status_kondisi_rumah' => $row['kondisi_rumah'],
            'tahun_anggaran' => $row['kondisi_rumah'],
            'jenis_anggaran' => $row['kondisi_rumah'],
            'jumlah_bantuan' => 1,
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
