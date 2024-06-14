<?php

declare(strict_types=1);

namespace App\Filament\Imports;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\RekapPenerimaBpjs;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class RekapPenerimaBpjsImporter extends Importer
{
    protected static ?string $model = RekapPenerimaBpjs::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('provinsi')
                ->guess(['PROVINSI', 'PROV', 'NO'])
                ->requiredMapping()
                ->fillRecordUsing(fn($record) => $record->provinsi = setting('app.kodeprov', '73')),
            ImportColumn::make('kabupaten')
                ->guess(['KABUPATEN', 'KAB', 'NO'])
                ->requiredMapping()
                ->fillRecordUsing(fn($record) => $record->kabupaten = setting('app.kodekab', '7312')),
            ImportColumn::make('kecamatan')
                ->requiredMapping()
                ->fillRecordUsing(function ($record, $state): void {
                    $kecamatan = Kecamatan::query()
                        ->where('kabupaten_code', setting('app.kodekab'))
                        ->where('name', 'like', '%' . $state . '%')
                        ->first();

                    $record->kecamatan = $kecamatan->code;
                }),
            ImportColumn::make('kelurahan')
                ->guess(['DESA/KELURAHAN'])
                ->requiredMapping()
                ->fillRecordUsing(function ($record, $state): void {
                    $kecamatanIds = Kecamatan::query()
                        ->where('kabupaten_code', setting('app.kodekab'))
                        ->pluck('code')
                        ->toArray();

                    $kelurahan = Kelurahan::query()
                        ->whereIn('kecamatan_code', $kecamatanIds)
                        ->where('name', 'like', '%' . $state . '%')
                        ->first();

                    $record->kelurahan = $kelurahan->code;
                }),
            ImportColumn::make('bulan')
                ->guess(['BULAN', 'PERIODE', 'PERIODE BULAN'])
                ->requiredMapping()
                ->fillRecordUsing(function ($record, string  $state): void {
                    $record->bulan = (int) bulan_to_integer($state, short: true) ?: now()->month;
                }),
            ImportColumn::make('jumlah')
                ->guess(['JUMLAH PENERIMA APBD'])
                ->requiredMapping(),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your rekap penerima bpjs import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    public function resolveRecord(): ?RekapPenerimaBpjs
    {
        return RekapPenerimaBpjs::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'kecamatan' => $this->data['kecamatan'],
            'kelurahan' => $this->data['kelurahan'],
            'jumlah' => $this->data['jumlah'],
        ]);

        //        return new RekapPenerimaBpjs();
    }
}
