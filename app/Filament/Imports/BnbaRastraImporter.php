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
            ImportColumn::make('dtks_id')
                ->castStateUsing(fn($state) => Str::isUuid($state) ? StatusDtksEnum::DTKS : StatusDtksEnum::NON_DTKS)
                ->label('DTKS ID')
                ->rules(['max:255']),
            ImportColumn::make('nama')
                ->label('NAMA')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('no_kk')
                ->label('NO KK')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nik')
                ->label('NIK')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('alamat')
                ->label('ALAMAT')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('desa_kel')
                ->label('DESA/KELURAHAN')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('kecamatan')
                ->label('KECAMATAN')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Data BNBA Rastra anda telah selesai dan '.number_format($import->successful_rows)
            .' '
            .str('row')
                ->plural($import->successful_rows).' berhasil di impor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }

    public function resolveRecord(): ?BnbaRastra
    {
        // return BnbaRastra::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);
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
