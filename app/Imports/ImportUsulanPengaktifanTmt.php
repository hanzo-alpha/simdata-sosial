<?php

namespace App\Imports;

use App\Enums\StatusAktif;
use App\Enums\StatusUsulanEnum;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\UsulanPengaktifanTmt as DataUsulanAktifTmt;
use Filament\Notifications\Notification;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\ImportFailed;

class ImportUsulanPengaktifanTmt implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue,
    SkipsEmptyRows
{

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event) {
                Notification::make('Import Failed')
                    ->title('Gagal Impor Usulan Pengaktifan TMT')
                    ->danger()
                    ->send()
                    ->sendToDatabase(auth()->user());
            },
        ];
    }

//    public function mapping(): array
//    {
//        return [
//            'no_kk' => 'B2',
//            'nik' => 'C2',
//            'nama_lengkap_tmt' => 'D2',
//            'tempat_lahir' => 'E2',
//            'tgl_lahir' => 'F2',
//            'jenis_kelamin' => 'G2',
//            'status_nikah' => 'H2',
//            'alamat_tempat_tinggal' => 'I2',
//            'rt' => 'J2',
//            'rw' => 'K2',
//            'kode_pos' => 'L2',
//            'kecamatan' => 'M2',
//            'kelurahan' => 'N2',
//            'status_aktif' => 'O2',
//        ];
//    }

    /**
     * @param  Collection  $collection
     */
    public function model(array $row): Model|DataUsulanAktifTmt|null
    {
        $kecamatan = Kecamatan::query()
            ->where('kabupaten_code', config('custom.default.kodekab'))
            ->where('name', \Str::ucfirst($row['kecamatan']))
            ->first()?->code;

        $kelurahan = Kelurahan::query()
            ->where('kecamatan_code', $kecamatan)
            ->where('name', \Str::ucfirst($row['kelurahan']))
            ->first()?->code;

        return new DataUsulanAktifTmt([
            'nokk_tmt' => $row['no_kk'] ?? 'TIDAK ADA NOMOR KK',
            'nik_tmt' => $row['nik'] ?? 'TIDAK ADA NIK',
            'nama_lengkap' => $row['nama_lengkap'] ?? 'TIDAK ADA NAMA',
            'tempat_lahir' => $row['tempat_lahir'] ?? 'TIDAK ADA',
            'tgl_lahir' => now()->format('Y-m-d'),
            'jenis_kelamin' => $row['jenis_kelamin'] ?? 1,
            'status_nikah' => $row['status_nikah'] ?? 1,
            'alamat' => $row['alamat_tempat_tinggal'] ?? '-',
            'nort' => $row['rt'] ?? '001',
            'norw' => $row['rw'] ?? '002',
            'kodepos' => $row['kode_pos'],
            'kecamatan' => $kecamatan ?? $row['kecamatan'],
            'kelurahan' => $kelurahan ?? $row['kelurahan'],
            'status_aktif' => StatusAktif::AKTIF,
            'status_bpjs' => $row['status_aktif'] ?? StatusAktif::AKTIF,
            'status_usulan' => StatusUsulanEnum::ONPROGRESS,
            'keterangan' => $row['keterangan'],
            'bulan' => $row['periode_bulan'] ?? now()->month,
            'tahun' => $row['tahun'] ?? now()->year
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

//    public function rules(): array
//    {
//        return [
//            'nik' => Rule::unique('usulan_pengaktifan_tmt', 'nik_tmt'),
//
//            // Above is alias for as it always validates in batches
//            '*.nik' => Rule::unique('usulan_pengaktifan_tmt', 'nik_tmt'),
//
//            // Can also use callback validation rules
////            '0' => function ($attribute, $value, $onFailure) {
////                if ($value !== 'Patrick Brouwers') {
////                    $onFailure('Name is not Patrick Brouwers');
////                }
////            }
//        ];
//    }
//
//    public function uniqueBy(): string
//    {
//        return 'nik_tmt';
//    }
}
