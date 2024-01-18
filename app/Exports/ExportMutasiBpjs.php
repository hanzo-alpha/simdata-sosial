<?php

namespace App\Exports;

use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportMutasiBpjs extends ExcelExport
{
    public function setUp(): void
    {
        $this->askForFilename();
        $this->withFilename(fn($filename) => date('Ymdhis') . '-' . $filename . '-ekspor');
        $this->askForWriterType();
        $this->withColumns([
            Column::make('id')->heading('NO'),
            Column::make('peserta_bpjs_id')
                ->formatStateUsing(fn($record) => $record->peserta->nama_lengkap)
                ->heading('PESERTA BPJS ID'),
            Column::make('nomor_kartu')->heading('No. KARTU'),
            Column::make('nik')
                ->formatStateUsing(fn($state) => "'" . $state)
                ->heading('N I K'),
            Column::make('nama_lengkap')->heading('Nama Lengkap'),
            Column::make('alasan_mutasi')->heading('ALASAN MUTASI'),
            Column::make('alamat_lengkap')->heading('ALAMAT LENGKAP'),
            Column::make('keterangan')->heading('KETERANGAN'),
        ]);
        $this->queue()->withChunkSize(500);
    }
}
