<?php

namespace App\Imports;

use App\Enums\StatusPkhBpntEnum;
use App\Models\BantuanBpnt as DataBpnt;
use App\Models\JenisBantuan;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ImportBantuanBpnt implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, WithValidation,
    SkipsEmptyRows, SkipsOnFailure, SkipsOnError
{
    use Importable;

//    use SkipsFailures, SkipsErrors;
    /**
     * @param  Collection  $collection
     */
    public function model(array $row): Model|DataBpnt|null
    {
        $namaProp = isset($row['nama_prop']) ? \Str::ucfirst($row['nama_prop']) : null;
        $namaKab = isset($row['nama_kab']) ? \Str::ucfirst($row['nama_kab']) : null;
        $namaKec = isset($row['nama_kec']) ? \Str::ucfirst($row['nama_kec']) : null;
        $namaKel = isset($row['nama_kel']) ? \Str::ucfirst($row['nama_kel']) : null;

        $provinsi = Provinsi::query()->where('name', $namaProp)->first()?->code;
        $kabupaten = Kabupaten::query()->where('name', $namaKab)->first()?->code;
        $kecamatan = Kecamatan::query()->where('name', $namaKec)->first()?->code;
        $kelurahan = Kelurahan::query()->where('name', $namaKel)->first()?->code;

        $jenisBantuan = JenisBantuan::where('alias', \Str::upper($row['bansos']))->first()->id;
        return new DataBpnt([
            'dtks_id' => $row['iddtks'] ?? 'NON DTKS',
            'nokk' => $row['nokk'],
            'nik_ktp' => $row['nik_ktp'],
            'nama_penerima' => $row['nama_penerima'],
            'provinsi' => $provinsi ?? $row['nama_prop'],
            'kabupaten' => $kabupaten ?? $row['nama_kab'],
            'kecamatan' => $kecamatan ?? $row['nama_kec'],
            'kelurahan' => $kelurahan ?? $row['nama_kel'],
            'kode_wilayah' => $row['kode_wilayah'],
            'tahap' => $row['tahap'],
            'bansos' => $row['bansos'],
            'bank' => $row['bank'],
            'jenis_bantuan_id' => $jenisBantuan ?? 2,
            'alamat' => $row['alamat'] ?? 'TIDAK ADA',
            'no_rt' => $row['no_rt'] ?? '001',
            'no_rw' => $row['no_rw'] ?? '002',
            'dusun' => $row['dusun'],
            'dir' => $row['dir'],
            'gelombang' => $row['gelombang'],
            'nominal' => $row['nominal'],
            'status_bpnt' => StatusPkhBpntEnum::BPNT,
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
            'nik_ktp' => Rule::unique('bantuan_pkh', 'nik_ktp'),
            'iddtks' => Rule::unique('bantuan_pkh', 'dtks_id'),

            // Above is alias for as it always validates in batches
            '*.nik_ktp' => Rule::unique('bantuan_pkh', 'nik_ktp'),
            '*.iddtks' => Rule::unique('bantuan_pkh', 'dtks_id'),

            // Can also use callback validation rules
//            '0' => function ($attribute, $value, $onFailure) {
//                if ($value !== 'Patrick Brouwers') {
//                    $onFailure('Name is not Patrick Brouwers');
//                }
//            }
        ];
    }

    public function onError(Throwable $e)
    {
        dd($e);
    }

    public function onFailure(Failure ...$failures)
    {
        if (!blank($failures)) {
            foreach ($failures as $failure) {
                $baris = $failure->row();
                $errmsg = $failure->errors()[0];
                $values = $failure->values();

                Notification::make('Failure Import')
                    ->title('Baris Ke : ' . $baris . ' | ' . $errmsg)
                    ->body('NIK : ' . $values['nik'] . ' | No.KK : ' . $values['no_kk'] . ' | Nama : ' . $values['nama_lengkap'])
                    ->danger()
                    ->sendToDatabase(auth()->user())
                    ->broadcast(User::where('is_admin', 1)->get());
            }
        }
    }
}
