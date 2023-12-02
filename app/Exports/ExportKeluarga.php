<?php
declare(strict_types=1);

namespace App\Exports;

use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportKeluarga extends ExcelExport
{
    public function setUp()
    {
        $this->askForFilename();
        $this->withFilename(fn($filename) => date('Ymdhis') . '-' . $filename . '-ekspor');
        $this->askForWriterType();
        $this->withColumns([
            Column::make('dtks_id')->heading('DTKS ID'),
            Column::make('nokk')->heading('No. KK'),
            Column::make('nik')->heading('N I K'),
            Column::make('nama_lengkap')->heading('Nama Lengkap'),
            Column::make('notelp')->heading('No. Telp/WA'),
            Column::make('tempat_lahir')->heading('Tempat Lahir'),
            Column::make('tgl_lahir')->heading('Tgl. Lahir'),
            Column::make('kec.name')->heading('Kecamatan'),
            Column::make('kel.name')->heading('Kelurahan'),
            Column::make('dusun')->heading('Dusun'),
            Column::make('no_rt')->heading('No.RT'),
            Column::make('no_rw')->heading('No.RW'),
            Column::make('jenis_bantuan.alias')->heading('Bantuan'),
            Column::make('jenis_pekerjaan.nama_pekerjaan')->heading('Pekerjaan'),
            Column::make('pendidikan_terakhir.nama_pendidikan')->heading('Pendidikan Terakhir'),
            Column::make('hubungan_keluarga.nama_hubungan')->heading('Hubungan Keluarga'),
            Column::make('status_kawin')->heading('Status Kawin'),
            Column::make('status_verifikasi')->heading('Status Verifikasi'),
            Column::make('unggah_foto')->heading('Foto Rumah'),
        ]);
        $this->queue()->withChunkSize(500);
    }
}
