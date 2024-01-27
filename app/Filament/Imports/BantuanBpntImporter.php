<?php

namespace App\Filament\Imports;

use App\Models\BantuanBpnt;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class BantuanBpntImporter extends Importer
{
    protected static ?string $model = BantuanBpnt::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('jenis_bantuan')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('dtks_id')
                ->requiredMapping()
                ->rules(['required', 'max:36']),
            ImportColumn::make('nokk')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nik_ktp')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nama_penerima')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('kode_wilayah')
                ->requiredMapping()
                ->rules(['required', 'max:10']),
            ImportColumn::make('tahap')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('bansos')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('bank')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nominal')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('provinsi')
                ->rules(['max:2']),
            ImportColumn::make('kabupaten')
                ->rules(['max:5']),
            ImportColumn::make('kecamatan')
                ->rules(['max:7']),
            ImportColumn::make('kelurahan')
                ->rules(['max:10']),
            ImportColumn::make('alamat')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('no_rt')
                ->rules(['max:255']),
            ImportColumn::make('no_rw')
                ->rules(['max:255']),
            ImportColumn::make('dusun')
                ->rules(['max:255']),
            ImportColumn::make('dir')
                ->rules(['max:255']),
            ImportColumn::make('gelombang')
                ->rules(['max:255']),
            ImportColumn::make('status_bpnt')
                ->rules(['max:255']),
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
}
