<?php

namespace App\Filament\Exports;

use App\Models\BnbaRastra;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BnbaRastraExporter extends Exporter
{
    protected static ?string $model = BnbaRastra::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('NO'),
            ExportColumn::make('nama')
                ->label('NAMA'),
            ExportColumn::make('no_kk')
                ->label('NO KK'),
            ExportColumn::make('nik')
                ->label('NO NIK'),
            ExportColumn::make('alamat')
                ->label('ALAMAT'),
            ExportColumn::make('desa_kel')
                ->label('DESA/KELURAHAN'),
            ExportColumn::make('kecamatan')
                ->label('KECAMATAN'),
            ExportColumn::make('status_dtks')
                ->label('STATUS DTKS')
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor Data BNBA Rastra anda telah selesai dan '.number_format($export->successful_rows).' '.str('baris')
                ->plural($export->successful_rows).' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' gagal diekspor.';
        }

        return $body;
    }

    public static function getCsvDelimiter(): string
    {
        return ';';
    }

    public function getJobConnection(): ?string
    {
        return 'redis';
    }

    public function getFileName(Export $export): string
    {
        return now()->format('Ymd')."-ekspor-bnba-rastra-{$export->getKey()}.csv";
    }
}
