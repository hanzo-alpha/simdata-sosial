<?php

namespace App\Exports;

use App\Enums\StatusAktif;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExportBantuanBpjs extends ExcelExport
{
    public function setUp(): void
    {
        $this->askForFilename();
        $this->withFilename(fn($filename) => date('Ymdhis') . '-' . $filename . '-ekspor');
        $this->askForWriterType();
        $this->withColumns([
            Column::make('nokk_tmt')->heading('No. KK'),
            Column::make('nik_tmt')->heading('N I K'),
            Column::make('nama_lengkap')->heading('Nama Lengkap'),
            Column::make('tempat_lahir')->heading('Tempat Lahir'),
            Column::make('tgl_lahir')->heading('Tgl. Lahir')
                ->formatStateUsing(fn($record) => $record->tgl_lahir->format('d/m/Y')),
            Column::make('jenis_kelamin')->heading('Jenis Kelamin'),
            Column::make('status_nikah')->heading('Status Nikah'),
            Column::make('bulan')->heading('Bulan'),
            Column::make('tahun')->heading('Tahun'),
            Column::make('alamat')->heading('Alamat'),
            Column::make('kecamatan')->heading('Kecamatan')
                ->formatStateUsing(fn($state) => Kecamatan::find($state)?->name),
            Column::make('kelurahan')->heading('Kelurahan')
                ->formatStateUsing(fn($state) => Kelurahan::find($state)?->name),
            Column::make('dusun')->heading('Dusun'),
            Column::make('nort')->heading('No.RT'),
            Column::make('norw')->heading('No.RW'),
            Column::make('kodepos')->heading('Kode Pos'),
            Column::make('status_aktif')->heading('Status Aktif')
                ->formatStateUsing(fn($state) => (1 === $state) ? StatusAktif::AKTIF->getLabel() :
                    StatusAktif::NONAKTIF->getLabel()),
            Column::make('status_usulan')->heading('Status Usulan'),
            Column::make('status_bpjs')->heading('Status BPJS'),
            Column::make('keterangan')->heading('Keterangan'),
            Column::make('foto_ktp')->heading('Foto KTP'),
        ]);
        $this->queue()->withChunkSize(1000);
    }
}
