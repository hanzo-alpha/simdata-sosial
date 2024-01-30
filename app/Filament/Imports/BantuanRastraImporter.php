<?php

namespace App\Filament\Imports;

use App\Enums\StatusDtksEnum;
use App\Models\BantuanRastra;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Str;

class BantuanRastraImporter extends Importer
{
    protected static ?string $model = BantuanRastra::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nokk')
                ->guess(['NO KK', 'no kk', 'kk'])
                ->ignoreBlankState()
                ->requiredMapping()
                ->rules(['required', 'max:20']),
            ImportColumn::make('nik')
                ->guess(['NO NIK', 'NIK'])
                ->requiredMapping()
                ->rules(['required', 'max:20']),
            ImportColumn::make('nama_lengkap')
                ->guess(['NAMA', 'nama', 'nama lengkap'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('alamat')
                ->requiredMapping()
                ->rules(['required', 'max:65535']),
            ImportColumn::make('kecamatan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('kelurahan')
                ->guess(['DESA / KEL', 'DESA / KELURAHAN', 'DESA', 'KELURAHAN'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            //            ImportColumn::make('status_verifikasi')
            //                ->fillRecordUsing(function (BantuanRastra $record, string $state): void {
            //                    $record->status_verifikasi = StatusVerifikasiEnum::UNVERIFIED;
            //                })
            //                ->ignoreBlankState()
            //                ->rules(['max:255']),
            //            ImportColumn::make('status_aktif')
            //                ->boolean()
            //                ->ignoreBlankState()
            //                ->fillRecordUsing(function (BantuanRastra $record, string $state): void {
            //                    $record->status_aktif = StatusAktif::AKTIF;
            //                })
            //                ->rules(['boolean']),
            //            ImportColumn::make('status_rastra')
            //                ->ignoreBlankState()
            //                ->fillRecordUsing(function (BantuanRastra $record, string $state): void {
            //                    $record->status_rastra = StatusRastra::BARU;
            //                })
            //                ->rules(['integer']),
            ImportColumn::make('status_dtks')
                ->ignoreBlankState()
                ->fillRecordUsing(function (BantuanRastra $record, string $state): void {
                    $record->status_dtks = Str::of($state)->contains('TERDAFTAR DTKS') ? StatusDtksEnum::DTKS :
                        StatusDtksEnum::NON_DTKS;
                })
                ->label('STATUS DTKS')
                ->rules(['max:255']),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor bantuan rastra telah selesai dan '.number_format($import->successful_rows).' '.str('baris')
                ->plural($import->successful_rows).' berhasil di impor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' gagal mengimpor.';
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
