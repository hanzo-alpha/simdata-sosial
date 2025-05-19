<?php

declare(strict_types=1);

namespace App\Exports;

use App\Enums\AlasanBpjsEnum;
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
                ->heading('PESERTA BPJS'),
            Column::make('nomor_kartu')->heading('No. KARTU'),
            Column::make('nik')
                ->formatStateUsing(fn($state) => "'" . $state)
                ->heading('N I K'),
            Column::make('nama_lengkap')->heading('NAMA LENGKAP'),
            Column::make('periode_bulan')->heading('PERIODE BULAN'),
            Column::make('periode_tahun')->heading('PERIODE TAHUN'),
            Column::make('alasan_mutasi')
                ->formatStateUsing(function ($state) {
                    return match ($state) {
                        AlasanBpjsEnum::MAMPU => AlasanBpjsEnum::MAMPU->getLabel(),
                        AlasanBpjsEnum::MENINGGAL => AlasanBpjsEnum::MENINGGAL->getLabel(),
                        AlasanBpjsEnum::GANDA => AlasanBpjsEnum::GANDA->getLabel(),
                        AlasanBpjsEnum::PINDAH => AlasanBpjsEnum::PINDAH->getLabel(),
                    };
                })
                ->heading('ALASAN MUTASI'),
            Column::make('alamat_lengkap')->heading('ALAMAT LENGKAP'),
            Column::make('keterangan')->heading('KETERANGAN'),
        ]);
        $this->queue()->withChunkSize(500);
    }
}
