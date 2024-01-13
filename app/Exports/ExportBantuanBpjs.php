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
        $this->withFilename(fn ($filename) => date('Ymdhis').'-'.$filename.'-ekspor');
        $this->askForWriterType();
        $this->withColumns([
            Column::make('dtks_id')->heading('DTKS ID'),
            Column::make('nokk_tmt')->heading('No. KK'),
            Column::make('nik_tmt')->heading('N I K'),
            Column::make('nama_lengkap')->heading('Nama Lengkap'),
            Column::make('tempat_lahir')->heading('Tempat Lahir'),
            Column::make('tgl_lahir')->heading('Tgl. Lahir'),
            Column::make('jenis_kelamin')->heading('Jenis Kelamin'),
            Column::make('status_nikah')->heading('Status Nikah'),
            Column::make('bulan')->heading('Periode'),
            Column::make('tahun')->heading('Tahun'),
            Column::make('alamat')->heading('Alamat'),
            Column::make('kecamatan')->heading('Kecamatan'),
            Column::make('kelurahan')->heading('Kelurahan'),
            Column::make('dusun')->heading('Dusun'),
            Column::make('nort')->heading('No.RT'),
            Column::make('norw')->heading('No.RW'),
            Column::make('kodepos')->heading('Kode Pos'),
            Column::make('status_aktif')->heading('Status Aktif'),
            Column::make('status_usulan')->heading('Status Usulan'),
            Column::make('status_bpjs')->heading('Status BPJS'),
            Column::make('keterangan')->heading('Keterangan'),
        ]);
        $this->queue()->withChunkSize(500);
    }
}
