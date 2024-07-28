<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\PesertaBpjs as PesertaJamkesda;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\NoReturn;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ImportPesertaBpjs implements ShouldQueue, SkipsEmptyRows, ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    use Importable;
    use SkipsErrors;
    use SkipsFailures;

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event): void {
                Notification::make()
                    ->title('Gagal Impor Peserta BPJS')
                    ->danger()
                    ->send()
                    ->sendToDatabase(auth()->user());
            },
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|\App\Models\MutasiBpjs|null
     */
    public function model(array $row): Model|PesertaJamkesda|null
    {
        $kab = Kabupaten::query()
            ->where('name', $row['kabupaten'])
            ->where('provinsi_code', setting('app.kodeprov'))
            ->first();
        $kec = Kecamatan::query()
            ->where('name', $row['kecamatan'])
            ->where('kabupaten_code', setting('app.kodekab'))
            ->first();
        $kel = Kelurahan::query()
            ->whereIn('kecamatan_code', config('custom.kode_kecamatan'))
            ->where('name', $row['kelurahan'])
            ->first();

        return new PesertaJamkesda([
            'nomor_kartu' => $row['no_kartu'] ?? '-',
            'nik' => $row['nik'] ?? '-',
            'nama_lengkap' => $row['nama'] ?? '-',
            'alamat' => $row['alamat'] ?? '-',
            'no_rt' => $row['rt'] ?? null,
            'no_rw' => $row['rw'] ?? null,
            'kabupaten' => $kab->code ?? $row['kabupaten'] ?? null,
            'kecamatan' => $kec->code ?? $row['kecamatan'] ?? null,
            'kelurahan' => $kel->code ?? $row['kelurahan'] ?? null,
            'dusun' => $row['desa'] ?? null,
        ]);
    }

    #[NoReturn]
    public function onError(Throwable $e): void
    {
        Log::error($e);
    }

    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $baris = $failure->row();
            $errmsg = $failure->errors()[0];
            $values = $failure->values();

            Notification::make('Terjadi Kesalahan Impor')
                ->title('Baris Ke : ' . $baris . ' | ' . $errmsg)
                ->body('NIK : ' . $values['nik'] ?? '-' . ' | Nama : ' . $values['nama_lengkap'] ?? '-')
                ->danger()
                ->sendToDatabase(auth()->user())
                ->broadcast(User::where('is_admin', 1)->get());

            Log::error($errmsg);
        }
    }


    public function batchSize(): int
    {
        return 3000;
    }

    public function chunkSize(): int
    {
        return 3000;
    }
}
