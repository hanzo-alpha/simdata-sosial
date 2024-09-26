<?php

declare(strict_types=1);

namespace App\Exports;

use App\Enums\StatusAktif;
use App\Enums\StatusBpjsEnum;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Str;

class ExportBantuanBpjs extends ExcelExport
{
    public function setUp(): void
    {
        $this->withFilename(fn($resource) => date('Ymdhis') . '-' . Str::of(replace_nama_file_excel($resource::getLabel()))
            ->lower()->kebab());
        $this->askForWriterType();
        $this->withColumns([
            Column::make('id')->heading('NO'),
            Column::make('nokk_tmt')->heading('NO. KK')
                ->formatStateUsing(fn($record) => "'" . $record->nokk_tmt ?? '-'),
            Column::make('nik_tmt')->heading('N I K')
                ->formatStateUsing(fn($record) => "'" . $record->nik_tmt ?? '-'),
            Column::make('nama_lengkap')->heading('NAMA LENGKAP')
                ->formatStateUsing(fn($record) => Str::upper($record->nama_lengkap) ?? '-'),
            Column::make('tempat_lahir')->heading('TEMPAT LAHIR')
                ->formatStateUsing(fn($record) => Str::upper($record->tempat_lahir) ?? '-'),
            Column::make('tgl_lahir')->heading('TGL LAHIR')
                ->formatStateUsing(fn($record) => $record->tgl_lahir->format('d/m/Y')),
            Column::make('jenis_kelamin')->heading('JENIS KELAMIN'),
            Column::make('status_nikah')->heading('STATUS NIKAH'),
            Column::make('bulan')->heading('BULAN'),
            Column::make('tahun')->heading('TAHUN'),
            Column::make('alamat')->heading('ALAMAT')
                ->formatStateUsing(fn($record) => Str::upper($record->alamat) ?? '-'),
            Column::make('kecamatan')->heading('KECAMATAN')
                ->formatStateUsing(fn($state) => Str::upper(Kecamatan::find($state)?->name)),
            Column::make('kelurahan')->heading('KELURAHAN')
                ->formatStateUsing(fn($state) => Str::upper(Kelurahan::find($state)?->name)),
            Column::make('dusun')->heading('DUSUN'),
            Column::make('nort')->heading('RT'),
            Column::make('norw')->heading('RW'),
            Column::make('kodepos')->heading('KODE POS'),
            Column::make('status_aktif')->heading('STATUS AKTIF')
                ->formatStateUsing(fn($state) => (StatusAktif::AKTIF === $state) ? StatusAktif::AKTIF->getLabel() :
                    StatusAktif::NONAKTIF->getLabel()),
            Column::make('status_usulan')->heading('STATUS USULAN'),
            Column::make('status_bpjs')->heading('STATUS BPJS')
                ->formatStateUsing(fn($state) => match ($state) {
                    StatusBpjsEnum::BARU, 'default' => StatusBpjsEnum::BARU,
                    StatusBpjsEnum::PENGAKTIFAN => StatusBpjsEnum::PENGAKTIFAN,
                    StatusBpjsEnum::PENGALIHAN => StatusBpjsEnum::PENGALIHAN,
                }),
            Column::make('keterangan')->heading('KETERANGAN'),
            Column::make('foto_ktp')->heading('FOTO KTP'),
        ]);
        $this->queue()->withChunkSize(1000);
    }
}
