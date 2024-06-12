<?php

declare(strict_types=1);

namespace App\Exports;

use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportBantuanRastra extends ExcelExport
{
    public function setUp(): void
    {
        $this->askForFilename();
        $this->withFilename(fn($filename) => date('Ymdhis') . '-' . $filename . '-ekspor');
        $this->askForWriterType();
        $this->modifyQueryUsing(fn($query) => $query->with(['kec', 'kel']));
        $this->withColumns([
            Column::make('status_dtks')->heading('DTKS'),
            Column::make('nokk')->heading('No. KK'),
            Column::make('nik')->heading('N I K'),
            Column::make('nama_lengkap')->heading('Nama Lengkap'),
            Column::make('kec.name')->heading('Kecamatan'),
            Column::make('kel.name')->heading('Kelurahan'),
            Column::make('dusun')->heading('Dusun'),
            Column::make('no_rt')->heading('No.RT'),
            Column::make('no_rw')->heading('No.RW'),
            Column::make('status_verifikasi')->heading('Status Verifikasi'),
            Column::make('status_rastra')->heading('Status Rastra'),
            Column::make('foto_ktp_kk')->heading('Foto KTP KK'),
        ]);
        $this->queue()->withChunkSize(300);
    }
}
