<?php

declare(strict_types=1);

namespace App\Filament\Imports;

use App\Enums\StatusDtksEnum;
use App\Enums\StatusKawinUmumEnum;
use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Models\BansosDiterima;
use App\Models\BantuanPpks;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
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
                ->guess(['Kartu Keluarga', 'KK', 'NO KK', 'No.KK'])
                ->fillRecordUsing(function ($record, $state): void {
                    $record->nokk = $state ?? '-';
                }),
            ImportColumn::make('nik')
                ->requiredMapping()
                ->guess(['NIK', 'N I K', 'nik', 'No.NIK'])
                ->fillRecordUsing(function ($record, $state): void {
                    $record->nik = $state ?? '-';
                })
                ->rules(['required']),
            ImportColumn::make('nama_lengkap')
                ->requiredMapping()
                ->guess(['Nama Lengkap', 'NAMA', 'NAMA LENGKAP'])
                ->rules(['required', 'max:255']),
            ImportColumn::make('nama_ibu_kandung')
                ->requiredMapping()
                ->ignoreBlankState()
                ->guess(['NAMA IBU KANDUNG', 'NAMA IBU'])
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $record->nama_ibu_kandung = $state ?? '-';
                })
                ->rules(['max:255']),
            ImportColumn::make('tempat_lahir')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $record->tempat_lahir = $state;
                })
                ->rules(['max:50']),
            ImportColumn::make('tgl_lahir')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $record->tgl_lahir = now()
                        ->subDays(random_int(0, 180))
                        ->subYears(random_int(10, 50))->format('Y-m-d');
                })
                ->guess(['Tgl Lahir', 'TGL LAHIR', 'Tanggal Lahir']),
            ImportColumn::make('jenis_kelamin')
                ->guess(['JENIS KELAMIN (1=LAKI, 2=PEREMPUAN)'])
                ->requiredMapping()
                ->ignoreBlankState()
                ->fillRecordUsing(function ($record, $state): void {
                    $record->jenis_kelamin = (int) $state;
                }),
            ImportColumn::make('jenis_pekerjaan')
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama_pekerjaan'),
            ImportColumn::make('pendidikan_terakhir')
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama_pendidikan'),
            ImportColumn::make('hubungan_keluarga')
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama_hubungan'),
            ImportColumn::make('status_kawin')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $record->status_kawin = match ((int) $state) {
                        1, '1' => StatusKawinUmumEnum::KAWIN_TERCATAT,
                        2, '2' => StatusKawinUmumEnum::KAWIN_BELUM_TERCATAT,
                        5, '5' => StatusKawinUmumEnum::CERAI_MATI,
                        4, '4' => StatusKawinUmumEnum::CERAI_HIDUP,
                        6, '6' => StatusKawinUmumEnum::CERAI_BELUM_TERCATAT,
                        3, '3' => StatusKawinUmumEnum::BELUM_KAWIN,
                    };
                }),
            ImportColumn::make('penghasilan_rata_rata')
                ->guess(['PENGHASILAN RATA-RATA'])
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $record->penghasilan_rata_rata = (0 !== $state) ? $state : 0;
                }),
            ImportColumn::make('nama_bantuan')
                ->requiredMapping()
                ->guess(['NAMA BANTUAN'])
                ->rules(['max:255']),
            ImportColumn::make('jumlah_bantuan')
                ->requiredMapping()
                ->guess(['JUMLAH BANTUAN'])
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $record->jumlah_bantuan = $state ?? 0;
                }),
            ImportColumn::make('alamat')
                ->requiredMapping()
                ->guess(['ALAMAT'])
                ->rules(['max:255']),
            ImportColumn::make('provinsi')
                ->guess(['PROVINSI', 'PROV'])
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $provinsi = Provinsi::query()
                        ->where('name', 'like', '%' . Str::ucfirst($state) . '%')
                        ->first()?->code;
                    $record->provinsi = $provinsi;
                })
                ->rules(['max:255']),
            ImportColumn::make('kabupaten')
                ->guess(['KABUPATEN', 'KAB'])
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $kabupaten = Kabupaten::query()
                        ->where('name', 'like', '%' . Str::ucfirst($state) . '%')
                        ->first()?->code;

                    $record->kabupaten = $kabupaten;
                })
                ->rules(['max:255']),
            ImportColumn::make('kecamatan')
                ->requiredMapping()
                ->guess(['KECAMATAN', 'KEC'])
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $kecamatan = Kecamatan::query()
                        ->whereIn('kabupaten_code', ['7308', '7312', '7371', '7604', '9171'])
                        ->where('name', 'like', '%' . Str::upper($state) . '%')
                        ->first()?->code;
                    $record->kecamatan = $kecamatan ?? null;
                })
                ->rules(['max:255']),
            ImportColumn::make('kelurahan')
                ->requiredMapping()
                ->guess(['Kelurahan/Desa', 'Kelurahan', 'Kel'])
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $kelurahan = Kelurahan::query()
                        ->where('name', 'like', '%' . Str::ucfirst($state) . '%')
                        ->first()?->code;
                    $record->kelurahan = $kelurahan;
                })
                ->rules(['max:255']),
            ImportColumn::make('kriteria_ppks')
                ->guess(['BANSOS DITERIMA', 'BANTUAN YANG PERNAH DITERIMA'])
                ->requiredMapping()
                ->fillRecordUsing(function ($record, $state): void {
                    $bansos = BansosDiterima::where('nama_bansos', 'like', '%' . Str::upper($state) . '%')->first();
                    $record->kriteria_ppks = [$bansos->nama_bansos];
                }),
            ImportColumn::make('tahun_anggaran')
                ->guess(['TAHUN', 'TAHUN ANGGARAN'])
                ->requiredMapping()
                ->integer(),
            ImportColumn::make('jenis_anggaran')
                ->requiredMapping(),
            ImportColumn::make('tipe_ppks')
                ->guess(['Kategori PPKS', 'PPKS'])
                ->requiredMapping()
                ->relationship(resolveUsing: 'nama_tipe'),
            //            ImportColumn::make('kriteria_ppks')
            //                ->requiredMapping()
            //                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
            //                    $kriteriaIds = collect();
            //                    $kriteria = KriteriaPpks::query()
            //                        ->where('nama_kriteria', 'like', '%' . $state . '%')
            //                        ->first();
            //                    $kriteriaIds->push($kriteria->id);
            //                    $record->kriteria_ppks[] = json_encode($kriteriaIds->toArray());
            //                }),
            ImportColumn::make('kategori_tags_ppks')
                ->guess(['KATEGORI TAGS PPKS', 'KRITERIA TAGS'])
                ->fillRecordUsing(function ($record, $state): void {
                    $record->kategori_tags_ppks = [$state];
                })
                ->requiredMapping(),
            ImportColumn::make('kriteria_tags_ppks')
                ->guess(['KRITERIA TAGS PPKS', 'KRITERIA TAGS'])
                ->fillRecordUsing(function ($record, $state): void {
                    $record->kriteria_tags_ppks = [$state];
                })
                ->requiredMapping(),
            ImportColumn::make('status_rumah_tinggal')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $record->status_rumah_tinggal = (1 === (int) $state) ? StatusRumahEnum::MILIK_SENDIRI :
                        StatusRumahEnum::MENUMPANG;
                }),
            ImportColumn::make('status_kondisi_rumah')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, $state): void {
                    $record->status_kondisi_rumah = match ((int) $state) {
                        1, '1' => StatusKondisiRumahEnum::BAIK,
                        3, '3' => StatusKondisiRumahEnum::RUSAK,
                        4, '4' => StatusKondisiRumahEnum::RUSAK_BERAT,
                        2, '2' => StatusKondisiRumahEnum::SEDANG,
                    };
                }),
            ImportColumn::make('status_verifikasi')
                ->requiredMapping()
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->status_verifikasi = match ($state) {
                        'TERVERIFIKASI' => StatusVerifikasiEnum::VERIFIED,
                        'BELUM DIVERIFIKASI', 'default' => StatusVerifikasiEnum::UNVERIFIED,
                        'SEDANG DITINJAU' => StatusVerifikasiEnum::REVIEW,
                    };
                })
                ->rules(['max:255']),
            ImportColumn::make('status_dtks')
                ->requiredMapping()
                ->guess(['DTKS', 'STATUS DTKS'])
                ->fillRecordUsing(function (BantuanPpks $record, string $state): void {
                    $record->status_dtks = Str::of($state)->contains('TERDAFTAR') ? StatusDtksEnum::DTKS : StatusDtksEnum::NON_DTKS;
                })
                ->label('STATUS DTKS'),
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
        $body = 'Impor Data Bantuan PPKS telah selesai dan ' . number_format($import->successful_rows) . ' ' . str('baris')
            ->plural($import->successful_rows) . ' berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal diimpor.';
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
