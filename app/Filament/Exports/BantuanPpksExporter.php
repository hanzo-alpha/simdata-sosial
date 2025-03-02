<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Enums\JenisAnggaranEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusKawinUmumEnum;
use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Enums\StatusVerifikasiEnum;
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
                ->label('NO'),
            ExportColumn::make('nokk')
                ->label('No. KK'),
            ExportColumn::make('nik')
                ->label('NIK'),
            ExportColumn::make('nama_lengkap')
                ->label('Nama Lengkap'),
            ExportColumn::make('tempat_lahir')
                ->label('Tempat Lahir'),
            ExportColumn::make('tgl_lahir')
                ->label('Tanggal Lahir')
                ->state(fn($record) => $record->tgl_lahir->format('d-m-Y')),
            ExportColumn::make('nama_ibu_kandung')
                ->label('Nama Ibu Kandung'),
            ExportColumn::make('pendidikan_terakhir.nama_pendidikan')
                ->label('Pendidikan Terakhir'),
            ExportColumn::make('hubungan_keluarga.nama_hubungan')
                ->label('Hubungan Keluarga'),
            ExportColumn::make('jenis_pekerjaan.nama_pekerjaan')
                ->label('Jenis Pekerjaan'),
            //            ExportColumn::make('bansos_diterima.nama_bansos')
            //                ->label('Bansos Yang Pernah Diterima'),
            ExportColumn::make('alamat')
                ->label('Alamat'),
            ExportColumn::make('prov.name')
                ->label('Provinsi'),
            ExportColumn::make('kab.name')
                ->label('Kabupaten'),
            ExportColumn::make('kec.name')
                ->label('Kecamatan'),
            ExportColumn::make('kel.name')
                ->label('Kelurahan'),
            ExportColumn::make('dusun')
                ->label('Dusun'),
            ExportColumn::make('no_rt')
                ->label('No. RT'),
            ExportColumn::make('no_rw')
                ->label('No. RW'),
            ExportColumn::make('status_kawin')
                ->label('Status Kawin')
                ->state(function (BantuanPpks $record) {
                    $value = $record->status_kawin->value ?? null;
                    return match ($value) {
                        1 => StatusKawinUmumEnum::KAWIN_TERCATAT->getLabel(),
                        2 => StatusKawinUmumEnum::KAWIN_BELUM_TERCATAT->getLabel(),
                        default => StatusKawinUmumEnum::BELUM_KAWIN->getLabel(),
                        4 => StatusKawinUmumEnum::CERAI_HIDUP->getLabel(),
                        5 => StatusKawinUmumEnum::CERAI_MATI->getLabel(),
                        6 => StatusKawinUmumEnum::CERAI_BELUM_TERCATAT->getLabel(),
                    };
                }),
            ExportColumn::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->state(function (BantuanPpks $record) {
                    return match ($record->jenis_kelamin->value) {
                        default => JenisKelaminEnum::LAKI->getLabel(),
                        2 => JenisKelaminEnum::PEREMPUAN->getLabel(),
                    };
                }),
            ExportColumn::make('tipe_ppks.nama_tipe')
                ->label('Tipe PPKS'),
            ExportColumn::make('penghasilan_rata_rata')
                ->label('Penghasilan Rata Rata'),
            ExportColumn::make('kriteriaPpks.nama_kriteria')
                ->label('Kriteria PPKS'),
            ExportColumn::make('tahun_anggaran')
                ->label('Tahun Anggaran'),
            ExportColumn::make('jenis_anggaran')
                ->label('Jenis Anggaran')
                ->state(function (BantuanPpks $record) {
                    return match ($record->jenis_anggaran->value) {
                        default => JenisAnggaranEnum::APBD->getLabel(),
                        'APBN' => JenisAnggaranEnum::APBN->getLabel(),
                    };
                }),
            ExportColumn::make('jumlah_bantuan')
                ->label('Jumlah Bantuan'),
            ExportColumn::make('barang.nama_barang')
                ->label('Nama Barang'),
            ExportColumn::make('nama_bantuan')
                ->label('Nama Bantuan'),
            ExportColumn::make('penandatangan.nama_penandatangan')
                ->label('Penandatangan'),
            ExportColumn::make('status_rumah_tinggal')
                ->label('Status Rumah Tinggal')
                ->state(function (BantuanPpks $record) {
                    $value = $record->status_rumah_tinggal->value ?? null;
                    return match ($value) {
                        default => StatusRumahEnum::MILIK_SENDIRI->getLabel(),
                        2 => StatusRumahEnum::MENUMPANG->getLabel(),
                    };
                }),
            ExportColumn::make('status_kondisi_rumah')
                ->label('Status Kondisi Rumah')
                ->state(function (BantuanPpks $record) {
                    $value = $record->status_kondisi_rumah->value ?? null;
                    return match ($value) {
                        default => StatusKondisiRumahEnum::BAIK->getLabel(),
                        2 => StatusKondisiRumahEnum::SEDANG->getLabel(),
                        3 => StatusKondisiRumahEnum::RUSAK->getLabel(),
                        4 => StatusKondisiRumahEnum::RUSAK_BERAT->getLabel(),
                    };
                }),
            ExportColumn::make('status_dtks')
                ->label('Status DTKS')
                ->state(function (BantuanPpks $record) {
                    return match ($record->status_dtks->value) {
                        default => StatusDtksEnum::DTKS->getLabel(),
                        'NON DTKS' => StatusDtksEnum::NON_DTKS->getLabel(),
                    };
                }),
            //            ExportColumn::make('bukti_foto')
            //                ->label('Bukti Foto'),
            ExportColumn::make('status_verifikasi')
                ->label('Status Verifikasi')
                ->state(function (BantuanPpks $record) {
                    $value = $record->status_verifikasi->value ?? null;
                    return match ($value) {
                        'TERVERIFIKASI' => StatusVerifikasiEnum::VERIFIED->getLabel(),
                        default => StatusVerifikasiEnum::UNVERIFIED->getLabel(),
                        'SEDANG DITINJAU' => StatusVerifikasiEnum::REVIEW->getLabel(),
                    };
                }),
            ExportColumn::make('status_aktif')
                ->label('Status Aktif')
                ->state(function (BantuanPpks $record) {
                    $value = $record->status_aktif->value ?? null;
                    return match ($value) {
                        1 => StatusAktif::AKTIF->getLabel(),
                        default => StatusAktif::NONAKTIF->getLabel(),
                    };
                }),
            ExportColumn::make('keterangan')
                ->label('Keterangan'),
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
