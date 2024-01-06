<?php

namespace App\Imports;

use App\Enums\StatusAktif;
use App\Enums\StatusUsulanEnum;
use App\Models\BantuanBpjs as DataBantuanBpjs;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\NoReturn;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ImportBantuanBpjs implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue,
    SkipsEmptyRows, WithValidation, WithUpserts, SkipsOnFailure, SkipsOnError
{
    use Importable;

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

    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|\App\Models\BantuanBpjs|null
     * @throws \Random\RandomException
     */
    public function model(array $row): Model|DataBantuanBpjs|null
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

        $bulan = bulan_to_integer($row['periode_bulan']);

        return new DataBantuanBpjs([
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
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function rules(): array
    {
        return [
            'nik' => Rule::unique('bantuan_bpjs', 'nik_tmt'),

            // Above is alias for as it always validates in batches
            '*.nik' => Rule::unique('bantuan_bpjs', 'nik_tmt'),
        ];
    }

    #[NoReturn] public function onError(Throwable $e): void
    {
        Log::error($e);
    }

    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            Log::error($failure->errors()[0]);
//            $baris = $failure->row();
//            $errmsg = $failure->errors()[0];
//            $values = $failure->values();
//
//            Notification::make('Failure Import')
//                ->title('Baris Ke : ' . $baris . ' | ' . $errmsg)
//                ->body('NIK : ' . $values['nik'] ?? '-' . ' | No.KK : ' . $values['no_kk'] ?? '-' . ' | Nama : ' .
//                $values['nama_lengkap'] ?? '-')
//                ->danger()
//                ->sendToDatabase(auth()->user())
//                ->broadcast(User::where('is_admin', 1)->get());
        }
    }

    public function uniqueBy(): array
    {
        return ['nik'];
    }
}
