<?php

declare(strict_types=1);

namespace App\Exports;

use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportBantuanBpjs extends ExcelExport
{
    public function setUp()
    {
        $this->askForFilename();
        $this->withFilename(fn($filename) => date('Ymdhis') . '-' . $filename . '-ekspor');
        $this->askForWriterType();
        $this->modifyQueryUsing(fn($query) => $query->with([
            'alamat',
            'alamat.kec',
            'alamat.kel',
            'jenis_bantuan',
            'pendidikan_terakhir',
            'hubungan_keluarga',
            'jenis_pekerjaan'
        ]));
        $this->withColumns([
            Column::make('dtks_id')->heading('DTKS ID'),
            Column::make('nokk')->heading('No. KK'),
            Column::make('nik')->heading('N I K'),
            Column::make('nama_lengkap')->heading('Nama Lengkap'),
            Column::make('notelp')->heading('No. Telp/WA'),
            Column::make('tempat_lahir')->heading('Tempat Lahir'),
            Column::make('tgl_lahir')->heading('Tgl. Lahir'),
            Column::make('alamat.kec.name')->heading('Kecamatan'),
            Column::make('alamat.kel.name')->heading('Kelurahan'),
            Column::make('alamat.dusun')->heading('Dusun'),
            Column::make('alamat.no_rt')->heading('No.RT'),
            Column::make('alamat.no_rw')->heading('No.RW'),
            Column::make('jenis_bantuan.alias')->heading('Bantuan'),
            Column::make('jenis_pekerjaan.nama_pekerjaan')->heading('Pekerjaan'),
            Column::make('pendidikan_terakhir.nama_pendidikan')->heading('Pendidikan Terakhir'),
            Column::make('hubungan_keluarga.nama_hubungan')->heading('Hubungan Keluarga'),
            Column::make('status_kawin')->heading('Status Kawin'),
            Column::make('status_verifikasi')->heading('Status Verifikasi'),
            Column::make('status_bpjs')->heading('Status BPJS'),
            Column::make('bukti_foto')->heading('Foto Rumah'),
        ]);
        $this->queue()->withChunkSize(500);
    }
}
