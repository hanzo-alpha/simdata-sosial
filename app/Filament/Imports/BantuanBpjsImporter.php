<?php

namespace App\Filament\Imports;

use App\Enums\StatusAktif;
use App\Enums\StatusUsulanEnum;
use App\Models\BantuanBpjs;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class BantuanBpjsImporter extends Importer
{
    protected static ?string $model = BantuanBpjs::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('jenis_bantuan_id')
                ->fillRecordUsing(function (BantuanBpjs $bantuanBpjs) {
                    $bantuanBpjs->jenis_bantuan_id = 3;
                })
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('nokk_tmt')
                ->guess(['no kk'])
                ->requiredMapping()
                ->rules(['required', 'max:20']),
            ImportColumn::make('nik_tmt')
                ->guess(['nik'])
                ->requiredMapping()
                ->rules(['required', 'max:20']),
            ImportColumn::make('nama_lengkap')
                ->guess(['nama lengkap'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('tempat_lahir')
                ->rules(['max:100']),
            ImportColumn::make('tgl_lahir')
                ->rules(['date']),
            ImportColumn::make('jenis_kelamin')
                ->guess(['jenis kelamin', 'jenkel'])
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('status_nikah')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('alamat')
                ->guess(['alamat tempat tinggal', 'almt'])
                ->requiredMapping()
                ->rules(['required', 'max:65535']),
            ImportColumn::make('nort')
                ->guess(['rt'])
                ->rules(['max:255']),
            ImportColumn::make('norw')
                ->guess(['rw'])
                ->rules(['max:255']),
            ImportColumn::make('kodepos')
                ->guess(['kode pos'])
                ->rules(['max:255']),
            ImportColumn::make('kecamatan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('kelurahan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('dusun')
                ->rules(['max:255']),
            ImportColumn::make('status_aktif')
                ->fillRecordUsing(function (BantuanBpjs $bantuanBpjs) {
                    $bantuanBpjs->status_aktif = StatusAktif::AKTIF;
                })
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('status_usulan')
                ->fillRecordUsing(function (BantuanBpjs $bantuanBpjs) {
                    $bantuanBpjs->status_usulan = StatusUsulanEnum::ONPROGRESS;
                })
                ->rules(['max:255']),
            ImportColumn::make('status_bpjs')
                ->guess(['status aktif'])
                ->rules(['max:255']),
            ImportColumn::make('bulan')
                ->rules(['max:10']),
            ImportColumn::make('tahun')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('keterangan')
                ->guess(['status tl'])
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?BantuanBpjs
    {
        // return BantuanBpjs::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new BantuanBpjs();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your bantuan bpjs import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
