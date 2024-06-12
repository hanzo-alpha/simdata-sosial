<?php

declare(strict_types=1);

namespace App\Filament\Imports;

use App\Models\BantuanBpnt;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class BantuanBpntImporter extends Importer
{
    protected static ?string $model = BantuanBpnt::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('no_nik')
                ->guess(['nik', 'no nik', 'nik ktp'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nama_penerima')
                ->guess(['nama', 'nama penerima'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('provinsi')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanBpnt $record, $state): void {
                    $prov = Provinsi::where('name', $state)->first();
                    $record->provinsi = $prov?->code;
                }),
            ImportColumn::make('kabupaten')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanBpnt $record, $state): void {
                    $kab = Kabupaten::query()
                        ->where('provinsi_code', setting('app.kodeprov', config('custom.default.kodeprov')))
                        ->where('name', $state)
                        ->first();
                    $record->kabupaten = $kab?->code;
                }),
            ImportColumn::make('kecamatan')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanBpnt $record, $state): void {
                    $kec = Kecamatan::query()
                        ->where('kabupaten_code', setting('app.kodekab', config('custom.default.kodekab')))
                        ->where('name', $state)
                        ->first();
                    $record->kecamatan = $kec?->code;
                }),
            ImportColumn::make('kelurahan')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanBpnt $record, $state): void {
                    $kel = Kelurahan::whereIn('kecamatan_code', config('custom.kode_kecamatan'))
                        ->where('name', $state)->first();
                    $record->kelurahan = $kel?->code;
                }),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your bantuan bpnt import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    public function resolveRecord(): ?BantuanBpnt
    {
        // return BantuanBpnt::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new BantuanBpnt();
    }

    public function getJobConnection(): ?string
    {
        return 'redis';
    }
}
