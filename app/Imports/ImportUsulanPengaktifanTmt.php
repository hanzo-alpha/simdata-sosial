<?php

namespace App\Imports;

use App\Enums\StatusAktif;
use App\Enums\StatusUsulanEnum;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\User;
use App\Models\UsulanPengaktifanTmt as DataUsulanAktifTmt;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\NoReturn;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ImportUsulanPengaktifanTmt implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue,
    SkipsEmptyRows, WithValidation, WithUpserts
{
    use Importable, SkipsFailures, SkipsErrors;

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

        $jenkel = match ($row['jenis_kelamin']) {
            'L' => 1,
            'P' => 2,
            default => null
        };

        $bulan = match ($row['periode_bulan']) {
            'JANUARI' => 1,
            'FEBRUARI' => 2,
            'MARET' => 3,
            'APRIL' => 4,
            'MEI' => 5,
            'JUNI' => 6,
            'JULI' => 7,
            'AGUSTUS' => 8,
            'SEPTEMBER' => 10,
            'NOVEMBER' => 11,
            'DESEMBER' => 12,
            default => null
        };

        return new DataUsulanAktifTmt([
            'nokk_tmt' => $row['no_kk'] ?? 'TIDAK ADA NOMOR KK',
            'nik_tmt' => $row['nik'] ?? 'TIDAK ADA NIK',
            'nama_lengkap' => $row['nama_lengkap'] ?? 'TIDAK ADA NAMA',
            'tempat_lahir' => $row['tempat_lahir'] ?? 'TIDAK ADA',
            'tgl_lahir' => now()->subDays(random_int(0, 180))
                ->subYears(random_int(10, 50))->format('Y-m-d'),
            'jenis_kelamin' => $jenkel ?? 1,
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
            'keterangan' => $row['keterangan'] ?? $row['status_tl'],
            'bulan' => $bulan ?? 0,
            'tahun' => $row['tahun'] ?? now()->year
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            'nik' => Rule::unique('usulan_pengaktifan_tmt', 'nik_tmt'),

            // Above is alias for as it always validates in batches
            '*.nik' => Rule::unique('usulan_pengaktifan_tmt', 'nik_tmt'),
        ];
    }

    #[NoReturn] public function onError(Throwable $e): void
    {
        dd($e);
    }

    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $baris = $failure->row();
            $errmsg = $failure->errors()[0];
            $values = $failure->values();

            Notification::make('Failure Import')
                ->title('Baris Ke : ' . $baris . ' | ' . $errmsg)
                ->body('NIK : ' . $values['nik'] ?? '-' . ' | No.KK : ' . $values['no_kk'] ?? '-' . ' | Nama : ' .
                $values['nama_lengkap'] ?? '-')
                ->danger()
                ->sendToDatabase(auth()->user())
                ->broadcast(User::where('is_admin', 1)->get());
        }
    }

    public function uniqueBy(): array
    {
        return ['nik', 'no_kk'];
    }
}
