<?php

namespace App\Filament\Imports;

use App\Enums\StatusDtksEnum;
use App\Models\BantuanRastra;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class BantuanRastraImporter extends Importer
{
    protected static ?string $model = BantuanRastra::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('dtks_id')
                ->requiredMapping()
                ->rules(['required', 'max:20']),
            ImportColumn::make('status_dtks')
                ->fillRecordUsing(function (BantuanRastra $record, string $state): StatusDtksEnum {
                    return match ($state) {
                        'DTKS' => StatusDtksEnum::DTKS,
                        'NON DTKS' => StatusDtksEnum::NON_DTKS,
                    };
                })
                ->rules(['max:30']),
            ImportColumn::make('nokk')
                ->requiredMapping()
                ->rules(['required', 'max:20']),
            ImportColumn::make('nik')
                ->requiredMapping()
                ->rules(['required', 'max:20']),
            ImportColumn::make('nama_lengkap')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('alamat')
                ->requiredMapping()
                ->rules(['required', 'max:65535']),
            ImportColumn::make('kecamatan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('kelurahan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('status_verifikasi')
                ->rules(['max:255']),
            ImportColumn::make('status_aktif')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('foto_ktp_kk'),
            ImportColumn::make('media')
                ->relationship(),
            ImportColumn::make('status_rastra')
                ->boolean()
                ->rules(['boolean']),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor bantuan rastra telah selesai dan ' . number_format($import->successful_rows) . ' ' . str('baris')
            ->plural($import->successful_rows) . ' berhasil di impor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal mengimpor.';
        }

        return $body;
    }

    public function resolveRecord(): ?BantuanRastra
    {
        // return BantuanRastra::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        if ($this->options['updateExisting'] ?? false) {
            return BantuanRastra::firstOrNew([
                'nokk' => $this->data['nokk'],
                'nik' => $this->data['nik'],
                'nama_lengkap' => $this->data['nama_lengkap'],
            ]);
        }

        return new BantuanRastra();
    }

    public function getJobConnection(): ?string
    {
        return 'redis';
    }
}
