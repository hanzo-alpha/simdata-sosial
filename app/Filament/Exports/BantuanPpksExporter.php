<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\BantuanPpks;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BantuanPpksExporter extends Exporter
{
    protected static ?string $model = BantuanPpks::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('jenis_bantuan.id'),
            ExportColumn::make('pendidikan_terakhir.id'),
            ExportColumn::make('hubungan_keluarga.id'),
            ExportColumn::make('jenis_pekerjaan.id'),
            ExportColumn::make('tipe_ppks.id'),
            ExportColumn::make('status_dtks'),
            ExportColumn::make('nokk'),
            ExportColumn::make('nik'),
            ExportColumn::make('nama_lengkap'),
            ExportColumn::make('tempat_lahir'),
            ExportColumn::make('tgl_lahir'),
            ExportColumn::make('notelp'),
            ExportColumn::make('nama_ibu_kandung'),
            ExportColumn::make('status_kawin'),
            ExportColumn::make('jenis_kelamin'),
            ExportColumn::make('kriteria_ppks'),
            ExportColumn::make('penghasilan_rata_rata'),
            ExportColumn::make('bantuan_yang_pernah_diterima'),
            ExportColumn::make('tahun_anggaran'),
            ExportColumn::make('jenis_anggaran'),
            ExportColumn::make('jumlah_bantuan'),
            ExportColumn::make('nama_bantuan'),
            ExportColumn::make('status_rumah_tinggal'),
            ExportColumn::make('status_kondisi_rumah'),
            ExportColumn::make('bukti_foto'),
            ExportColumn::make('status_verifikasi'),
            ExportColumn::make('status_aktif'),
            ExportColumn::make('keterangan'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your bantuan ppks export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
