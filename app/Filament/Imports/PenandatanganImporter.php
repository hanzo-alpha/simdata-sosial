<?php

namespace App\Filament\Imports;

use App\Enums\StatusPenandatangan;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Penandatangan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PenandatanganImporter extends Importer
{
    protected static ?string $model = Penandatangan::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('kode_instansi')
                ->guess(['instansi', 'kelurahan'])
                ->fillRecordUsing(function ($record, $state): void {
                    $instansi = Kelurahan::where('name', $state)->first();
                    $record->kode_instansi = $instansi->code ?? '-';
                })
                ->rules(['required', 'max:255']),
            ImportColumn::make('nama_penandatangan')
                ->requiredMapping()
                ->guess(['nama', 'nama penandatangan', 'penandatangan'])
                ->rules(['required', 'max:255']),
            ImportColumn::make('nip')
                ->requiredMapping()
                ->ignoreBlankState()
                ->guess(['nip'])
                ->rules(['max:255']),
            ImportColumn::make('jabatan')
                ->rules(['required', 'max:255']),
            ImportColumn::make('kode_kecamatan')
                ->guess(['kecamatan', 'kode kecamatan'])
                ->fillRecordUsing(function ($record, $state): void {
                    $kecamatan = Kecamatan::where('name', $state)->first();
                    $record->kode_kecamatan = $kecamatan->code ?? '-';
                })
                ->rules(['max:255']),
            ImportColumn::make('jumlah_kpm')
                ->guess(['jumlah kpm', 'jml kpm'])
                ->ignoreBlankState(),
            ImportColumn::make('jumlah_beras')
                ->guess(['jumlah beras', 'jumlah kg beras'])
                ->ignoreBlankState(),
            ImportColumn::make('jumlah_bulan')
                ->guess(['jumlah bulan'])
                ->ignoreBlankState(),
            ImportColumn::make('jumlah_penerimaan')
                ->guess(['jumlah beras yg diterima', 'jumlah kg beras yg diterima', 'jumlah penerimaan'])
                ->ignoreBlankState(),
            ImportColumn::make('status_penandatangan')
                ->guess(['status'])
                ->fillRecordUsing(function ($record): void {
                    $record->status_penandatangan = StatusPenandatangan::AKTIF->value;
                })
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your penandatangan import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }

    public function resolveRecord(): ?Penandatangan
    {
        // return Penandatangan::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Penandatangan();
    }
}
