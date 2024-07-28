<?php

declare(strict_types=1);

namespace App\Filament\Imports;

use App\Models\PesertaBpjs;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PesertaBpjsImporter extends Importer
{
    protected static ?string $model = PesertaBpjs::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nomor_kartu')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nik')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nama_lengkap')
                ->rules(['max:255']),
            ImportColumn::make('alamat')
                ->rules(['max:255']),
            ImportColumn::make('no_rt')
                ->rules(['max:255']),
            ImportColumn::make('no_rw')
                ->rules(['max:255']),
            ImportColumn::make('dusun')
                ->rules(['max:255']),
            ImportColumn::make('kabupaten')
                ->rules(['max:255']),
            ImportColumn::make('kecamatan')
                ->rules(['max:255']),
            ImportColumn::make('kelurahan')
                ->rules(['max:255']),
            ImportColumn::make('bulan')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('tahun')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('is_mutasi')
                ->rules(['datetime']),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your peserta bpjs import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    public function resolveRecord(): ?PesertaBpjs
    {
        // return PesertaBpjs::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new PesertaBpjs();
    }
}
