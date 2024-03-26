<?php

namespace App\Filament\Imports;

use App\Enums\StatusDtksEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Models\BantuanRastra;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
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
                ->guess(['NAMA', 'NAMA LENGKAP'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('alamat')
                ->requiredMapping()
                ->rules(['required', 'max:65535']),
            ImportColumn::make('kecamatan')
                ->fillRecordUsing(function (BantuanRastra $record, string $state): void {
                    $kecamatan = Kecamatan::query()->where('name', Str::upper($state))->first()?->code;
                    $record->kecamatan = $kecamatan ?? $state;
                })
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('kelurahan')
                ->guess(['DESA / KEL', 'DESA / KELURAHAN', 'DESA', 'KELURAHAN'])
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanRastra $record, string $state): void {
                    $kelurahan = Kelurahan::query()->where('name', Str::upper($state))->first()?->code;
                    $record->kelurahan = $kelurahan ?? $state;
                })
                ->rules(['required', 'max:255']),
            ImportColumn::make('status_verifikasi')
                ->guess(['STATUS VERIFIKASI', 'VERIFIKASI'])
                ->fillRecordUsing(function (BantuanRastra $record, string $state): void {
                    $record->status_verifikasi = match ($state) {
                        'TERVERIFIKASI', 'default' => StatusVerifikasiEnum::VERIFIED,
                        'BELUM DIVERIFIKASI' => StatusVerifikasiEnum::UNVERIFIED,
                        'SEDANG DITINJAU' => StatusVerifikasiEnum::REVIEW,
                    };
                })
                ->ignoreBlankState(),
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
        $body = 'Impor bantuan rastra telah selesai dan ' . number_format($import->successful_rows) . ' ' . str('baris')
            ->plural($import->successful_rows) . ' berhasil di impor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal mengimpor.';
        }

        return $body;
    }

    public function resolveRecord(): ?BantuanRastra
    {
        if ($this->options['updateExisting'] ?? false) {
            return BantuanRastra::firstOrNew([
                'nik' => $this->data['nik'],
            ]);
        }

        return new BantuanRastra();
    }

    public function getJobConnection(): ?string
    {
        return 'redis';
    }
}
