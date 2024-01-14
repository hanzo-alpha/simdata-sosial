<?php

declare(strict_types=1);

namespace App\Exports;

use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

final class ExportBantuanPpks extends ExcelExport
{
    public function setUp(): void
    {
        $this->askForFilename();
        $this->withFilename(fn($filename) => date('Ymdhis') . '-' . $filename . '-ekspor');
        $this->askForWriterType();
        $this->withColumns([
            //            Column::make('dtks_id')->heading('DTKS ID'),
            Column::make('nama_lengkap')->heading('Nama Lengkap'),
            Column::make('nik')->heading('N I K'),
            Column::make('nokk')->heading('No. KK'),
            Column::make('status_kawin')->heading('Status Kawin'),
            Column::make('hubungan_keluarga.nama_hubungan')->heading('Hubungan Keluarga'),
            Column::make('jenis_kelamin')->heading('Jenis Kelamin'),
            Column::make('tempat_lahir')->heading('Tempat Lahir')
                ->formatStateUsing(fn($record) => $record->tempat_lahir . ', ' . $record->tgl_lahir),
            Column::make('notelp')->heading('No. Telp/WA'),
            Column::make('alamat.alamat_lengkap')->heading('Alamat Lengkap'),
            Column::make('alamat.kel.name')->heading('Kelurahan'),
            Column::make('alamat.kec.name')->heading('Kecamatan'),
            Column::make('pendidikan_terakhir.nama_pendidikan')->heading('Pendidikan Terakhir'),
            Column::make('sub_jenis_disabilitas.nama_sub_jenis')->heading('Jenis PPKS'),
            Column::make('nama_ibu_kandung')->heading('Nama Ibu Kandung'),
            Column::make('jenis_pekerjaan.nama_pekerjaan')->heading('Pekerjaan'),
            Column::make('penghasilan_rata_rata')->heading('Penghasilan Rata Rata PerBulan'),
            Column::make('bantuan_yang_pernah_diterima')->heading('Bantuan Yang Pernah Diterima'),
            Column::make('status_rumah_tinggal')->heading('Rumah Tinggal'),
            Column::make('status_kondisi_rumah')->heading('Kondisi Rumah'),
            Column::make('tahun_anggaran')->heading('Tahun'),
            Column::make('jenis_anggaran')->heading('Jenis Anggaran'),
            Column::make('jumlah_bantuan')->heading('Jumlah Bantuan'),
        ]);
        $this->queue()->withChunkSize(500);
    }
}
