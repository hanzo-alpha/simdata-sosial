<?php

namespace App\Filament\Imports;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusDtksEnum;
use App\Enums\StatusKawinUmumEnum;
use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Models\BantuanPpks;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KriteriaPpks;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Str;

class BantuanPpksImporter extends Importer
{
    protected static ?string $model = BantuanPpks::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nokk')
                ->requiredMapping()
                ->guess(['No. Kartu Keluarga (KK)', 'KK', 'NO KK', 'No.KK'])
                ->ignoreBlankState()
                ->rules(['required', 'max:20']),
            ImportColumn::make('nik')
                ->requiredMapping()
                ->guess(['NIK', 'N I K', 'nik', 'No.NIK'])
                ->rules(['required', 'max:20']),
            ImportColumn::make('nama_lengkap')
                ->requiredMapping()
                ->guess(['Nama Lengkap', 'NAMA', 'NAMA LENGKAP'])
                ->rules(['required', 'max:255']),
            ImportColumn::make('nama_ibu_kandung')
                ->requiredMapping()
                ->ignoreBlankState()
                ->guess(['Nama Ibu', 'NAMA IBU', 'NM IBU'])
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->nama_ibu_kandung = !blank($state) ? $state : '-';
                })
                ->rules(['max:255']),
            ImportColumn::make('tempat_lahir')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->tempat_lahir = !blank($state) ? $state : '-';
                })
                ->rules(['max:50']),
            ImportColumn::make('tgl_lahir')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->tgl_lahir = now()
                        ->subDays(random_int(0, 180))
                        ->subYears(random_int(10, 50))->format('Y-m-d');
                })
                ->guess(['Tgl Lahir', 'TGL LAHIR', 'Tanggal Lahir']),
            ImportColumn::make('penghasilan_rata_rata')
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->penghasilan_rata_rata = !blank($state) ? $state : 0;
                }),
            ImportColumn::make('jenis_kelamin')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->jenis_kelamin = Str::of($state)->contains('LAKI-LAKI') ? JenisKelaminEnum::LAKI : JenisKelaminEnum::PEREMPUAN;
                }),
            ImportColumn::make('jenis_pekerjaan')
                ->ignoreBlankState()
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama_pekerjaan'),
            ImportColumn::make('pendidikan_terakhir')
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama_pendidikan')
                ->rules(['required']),
            ImportColumn::make('hubungan_keluarga')
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama_hubungan')
                ->rules(['required']),
            ImportColumn::make('status_kawin')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->status_kawin = match ($state) {
                        'KAWIN TERCATAT', 'default' => StatusKawinUmumEnum::KAWIN_TERCATAT,
                        'KAWIN BELUM TERCATAT' => StatusKawinUmumEnum::KAWIN_BELUM_TERCATAT,
                        'CERAI MATI' => StatusKawinUmumEnum::CERAI_MATI,
                        'CERAI HIDUP' => StatusKawinUmumEnum::CERAI_HIDUP,
                        'CERAI BELUM TERCATAT' => StatusKawinUmumEnum::CERAI_BELUM_TERCATAT,
                        'BELUM KAWIN' => StatusKawinUmumEnum::BELUM_KAWIN
                    };
                }),
            ImportColumn::make('nama_bantuan')
                ->rules(['max:255']),
            ImportColumn::make('jumlah_bantuan')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->jumlah_bantuan = !blank($state) ? $state : 0;
                }),
            ImportColumn::make('alamat')
                ->requiredMapping()
                ->rules(['max:255']),
            ImportColumn::make('kecamatan')
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $kecamatan = Kecamatan::query()
                        ->where('kabupaten_code', config('custom.default.kodekab'))
                        ->where('name', 'like', '%'.Str::ucfirst($state).'%')
                        ->first()?->code;
                    $record->kecamatan = $kecamatan;
                })
                ->rules(['max:255']),
            ImportColumn::make('kelurahan')
                ->guess(['Kelurahan/Desa', 'Kelurahan', 'Kel'])
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $kelurahan = Kelurahan::query()
                        ->where('name', 'like', '%'.Str::ucfirst($state).'%')
                        ->first()?->code;
                    $record->kelurahan = $kelurahan;
                })
                ->rules(['max:255']),
            ImportColumn::make('dusun')
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->dusun = $state;
                })
                ->rules(['max:255']),
            ImportColumn::make('rt')
                ->ignoreBlankState()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->no_rt = $state;
                })
                ->rules(['max:255']),
            ImportColumn::make('rw')
                ->ignoreBlankState()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->no_rw = $state;
                })
                ->rules(['max:255']),
            //            ImportColumn::make('bantuan_yang_pernah_diterima')
            //                ->relationship('bansos_diterima', 'nama_bansos'),
            ImportColumn::make('tahun_anggaran')
                ->requiredMapping()
                ->integer()
                ->rules(['required', 'integer']),
            ImportColumn::make('jenis_anggaran')
                ->requiredMapping()
                ->rules(['required', 'max:10']),
            ImportColumn::make('tipe_ppks')
                ->guess(['Kategori PPKS', 'PPKS'])
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama_tipe'),
            ImportColumn::make('kriteria_ppks')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    //                    $search = Str::of($state)->contains($state);
                    $kriteria = KriteriaPpks::where('nama_kriteria', 'like', '%'.$state.'%')
                        ->first();
                    $record->kriteria_ppks = [$kriteria->id];
                }),
            ImportColumn::make('status_rumah_tinggal')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->status_rumah_tinggal = Str::of($state)->contains('MILIK SENDIRI') ?
                        StatusRumahEnum::MILIK_SENDIRI :
                        StatusRumahEnum::MENUMPANG;
                }),
            ImportColumn::make('status_kondisi_rumah')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->status_kondisi_rumah = match ($state) {
                        'BAIK', 'default' => StatusKondisiRumahEnum::BAIK,
                        'RUSAK' => StatusKondisiRumahEnum::RUSAK,
                        'RUSAK BERAT' => StatusKondisiRumahEnum::RUSAK_BERAT,
                        'SEDANG' => StatusKondisiRumahEnum::SEDANG,
                    };
                })
                ->rules(['max:255']),
            ImportColumn::make('status_verifikasi')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->status_verifikasi = match ($state) {
                        'VERIFIED' => StatusVerifikasiEnum::VERIFIED,
                        'UNVERIFIED', 'default' => StatusVerifikasiEnum::UNVERIFIED,
                        'REVIEW' => StatusVerifikasiEnum::REVIEW,
                    };
                })
                ->rules(['max:255']),
            ImportColumn::make('status_dtks')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->status_dtks = Str::of($state)->contains('Terdaftar') ? StatusDtksEnum::DTKS :
                        StatusDtksEnum::NON_DTKS;
                })
                ->label('STATUS DTKS'),
            ImportColumn::make('keterangan')
                ->rules(['max:65535']),
        ];
    }

    public static function getOptionsFormComponents(): array
    {
        return [
            Checkbox::make('updateExisting')
                ->label('Update Data Yang Sudah Ada'),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor Data Bantuan PPKS telah selesai dan '.number_format($import->successful_rows).' '.str('baris')
                ->plural($import->successful_rows).' berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' gagal diimpor.';
        }

        return $body;
    }

    public function resolveRecord(): ?BantuanPpks
    {
        if ($this->options['updateExisting'] ?? false) {
            return BantuanPpks::firstOrNew([
                'nik' => $this->data['nik'],
            ]);
        }

        return new BantuanPpks();
    }

    public function getJobConnection(): ?string
    {
        return 'redis';
    }
}
