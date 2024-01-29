<?php

namespace App\Filament\Imports;

use App\Enums\StatusDtksEnum;
use App\Models\BnbaRastra;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Str;

class BnbaRastraImporter extends Importer
{
    protected static ?string $model = BnbaRastra::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->label('NAMA')
                ->guess(['NAMA', 'nama', 'nama lengkap'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('no_kk')
                ->label('NO KK')
                ->ignoreBlankState()
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nik')
                ->guess(['NO NIK', 'NIK'])
                ->label('NIK')
                ->ignoreBlankState()
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('alamat')
                ->label('ALAMAT')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('desa_kel')
                ->guess(['DESA / KEL', 'DESA / KELURAHAN', 'DESA', 'KELURAHAN'])
                ->label('DESA/KELURAHAN')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('kecamatan')
                ->label('KECAMATAN')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('status_dtks')
                ->fillRecordUsing(function (BnbaRastra $record, string $state): void {
                    $record->status_dtks = Str::of($state)->contains('TERDAFTAR DTKS') ? StatusDtksEnum::DTKS :
                        StatusDtksEnum::NON_DTKS;
                })
                ->label('STATUS DTKS')
                ->rules(['max:255']),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Data BNBA Rastra anda telah selesai dan ' . number_format($import->successful_rows)
            . ' '
            . str('baris')
                ->plural($import->successful_rows) . ' berhasil di impor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal di impor.';
        }

        return $body;
    }

    public function resolveRecord(): ?BnbaRastra
    {
        if ($this->options['updateExisting'] ?? false) {
            return BnbaRastra::firstOrNew([
                'nik' => $this->data['nik'],
            ]);
        }

        return new BnbaRastra();
    }

    public function getJobConnection(): ?string
    {
        return 'redis';
    }
}
