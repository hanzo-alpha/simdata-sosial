<?php

namespace App\Filament\Imports;

use App\Enums\JabatanEnum;
use App\Enums\StatusPenandatangan;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Penandatangan;
use Filament\Actions\Imports\Exceptions\RowImportFailedException;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Forms\Components\Checkbox;
use Str;

class PenandatanganImporter extends Importer
{
    protected static ?string $model = Penandatangan::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('kode_kecamatan')
                ->requiredMapping()
                ->guess(['kecamatan', 'kode kecamatan'])
                ->fillRecordUsing(function ($record, $state): void {
                    $kecamatan = Kecamatan::where('name', $state)->first();
                    $record->kode_kecamatan = $kecamatan->code ?? '-';
                })
                ->rules(['max:255']),
            ImportColumn::make('kode_instansi')
                ->guess(['instansi', 'kelurahan', 'kode instansi', 'kode kelurahan'])
                ->requiredMapping()
                ->fillRecordUsing(function ($record, $state): void {
                    $instansi = Kelurahan::query()
                        ->whereIn('kecamatan_code', [
                            '731201', '731202', '731203', '731204', '731205', '731206',
                            '731207', '731208',
                        ])
                        ->where('name', $state)->first();
                    $record->kode_instansi = $instansi?->code ?? '-';
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
                ->requiredMapping()
                ->fillRecordUsing(function ($record, string $state): void {
                    $record->jabatan = match (Str::upper($state)) {
                        'KEPALA DESA', 'default' => JabatanEnum::KEPALA_DESA,
                        'SEKRETARIS DESA', 'SEKERTARIS DESA' => JabatanEnum::SEKRETARIS_DESA,
                        'LURAH' => JabatanEnum::LURAH,
                        'PJ. KEPALA DESA', 'PJ. KEPDES', 'PJ KEPALA DESA' => JabatanEnum::PEJABAT_SEMENTARA_KEPDES,
                    };
                })
                ->rules(['required', 'max:255']),
            ImportColumn::make('jumlah_kpm')
                ->requiredMapping()
                ->guess(['jumlah kpm', 'jml kpm'])
                ->ignoreBlankState(),
            ImportColumn::make('jumlah_beras')
                ->requiredMapping()
                ->guess(['jumlah beras', 'jumlah kg beras'])
                ->ignoreBlankState(),
            ImportColumn::make('jumlah_bulan')
                ->guess(['jumlah bulan'])
                ->requiredMapping()
                ->ignoreBlankState(),
            ImportColumn::make('jumlah_penerimaan')
                ->guess(['jumlah beras yg diterima', 'jumlah kg beras yg diterima', 'jumlah penerimaan'])
                ->requiredMapping()
                ->ignoreBlankState(),
            ImportColumn::make('status_penandatangan')
                ->guess(['status'])
                ->fillRecordUsing(function ($record): void {
                    $record->status_penandatangan = StatusPenandatangan::AKTIF->value ?? 1;
                }),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'import penandatangan telah selesai dan ' . number_format($import->successful_rows) . ' ' .
            str('row')->plural($import->successful_rows) . ' berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal di impor.';
        }

        return $body;
    }

    public static function getOptionsFormComponents(): array
    {
        return [
            Checkbox::make('updateExisting')
                ->label('Update existing records'),
        ];
    }

    /**
     * @throws \Filament\Actions\Imports\Exceptions\RowImportFailedException
     */
    public function resolveRecord(): ?Penandatangan
    {
        if ($this->options['updateExisting'] ?? false) {
            $penandatangan = Penandatangan::query()
                ->whereIn('kecamatan_code', [
                    '731201', '731202', '731203', '731204', '731205', '731206',
                    '731207', '731208',
                ])
                ->where('name', $this->data['kode_instansi'])->first();

            if ( ! $penandatangan) {
                throw new RowImportFailedException('Tidak ditemukan penandatangan dengan instansi: ' . $this->data['kode_instansi']);
            }
            return $penandatangan;
        }

        return new Penandatangan();
    }

    public function getJobConnection(): ?string
    {
        return 'redis';
    }
}
