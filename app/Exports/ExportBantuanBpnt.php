<?php

declare(strict_types=1);

namespace App\Exports;

use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportBantuanBpnt extends ExcelExport
{
    public function setUp(): void
    {
        $this->askForFilename();
        $this->withFilename(fn($filename) => date('Ymdhis') . '-' . $filename . '-ekspor');
        $this->askForWriterType();
        $this->withColumns([
            Column::make('dtks_id')->heading('ID DTKS'),
            Column::make('nokk')->heading('NO KK'),
            Column::make('nik_ktp')->heading('NIK KTP'),
            Column::make('nama_penerima')->heading('NAMA PENERIMA'),
            Column::make('kode_wilayah')->heading('KODE WILAYAH'),
            Column::make('tahap')->heading('TAHAP'),
            Column::make('bansos')->heading('BANSOS'),
            Column::make('nominal')->heading('NOMINAL'),
            Column::make('bank')->heading('BANK'),
            Column::make('provinsi')->heading('PROVINSI'),
            Column::make('kabupaten')->heading('KABUPATEN'),
            Column::make('kecamatan')->heading('KECAMATAN'),
            Column::make('kelurahan')->heading('KELURAHAN'),
            Column::make('alamat')->heading('ALAMAT'),
            Column::make('dusun')->heading('DUSUN'),
            Column::make('no_rt')->heading('RT'),
            Column::make('no_rw')->heading('RW'),
            Column::make('dir')->heading('DIR'),
            Column::make('gelombang')->heading('GELOMBANG'),
        ]);
        $this->queue()->withChunkSize(500);
    }
}
