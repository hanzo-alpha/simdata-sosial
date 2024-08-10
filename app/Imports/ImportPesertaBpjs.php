<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\PesertaBpjs as PesertaJamkesda;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\NoReturn;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Events\AfterChunk;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Validators\Failure;
use Str;
use Throwable;

class ImportPesertaBpjs implements
    ShouldQueue,
    SkipsEmptyRows,
    SkipsOnError,
    SkipsOnFailure,
    ToModel,
    WithBatchInserts,
    WithChunkReading,
    WithHeadingRow,
    WithUpserts,
    WithEvents
{
    use Importable;
    use RegistersEventListeners;
    use SkipsErrors;
    use SkipsFailures;

    public static function beforeImport(BeforeImport $event): void
    {
        Notification::make('Mulai Mengimpor')
            ->title('Data Peserta Bpjs sedang di impor ke database.')
            ->info()
            ->sendToDatabase(auth()->user());
    }

    public static function afterImport(AfterImport $event): void
    {
        Notification::make('Impor Berhasil')
            ->title('Data Peserta BPJS Berhasil di impor')
            ->success()
            ->sendToDatabase(auth()->user());
    }

    public static function afterChunk(AfterChunk $event): void
    {
        Notification::make('Impor Berhasil')
            ->title('Data Peserta BPJS Berhasil di impor')
            ->success()
            ->sendToDatabase(auth()->user());
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event): void {
                Notification::make()
                    ->title('Gagal Impor Peserta BPJS')
                    ->danger()
                    ->sendToDatabase(auth()->user());
            },
        ];
    }

    public function model(array $row): Model|PesertaJamkesda|null
    {
        return new PesertaJamkesda([
            'nomor_kartu' => $row['no_kartu'] ?? '-',
            'nik' => Str::replaceFirst("'", "", $row['nik']) ?? '-',
            'nama_lengkap' => $row['nama'] ?? '-',
            'alamat' => $row['alamat'] ?? '-',
            'no_rt' => $row['rt'] ?? null,
            'no_rw' => $row['rw'] ?? null,
            'kabupaten' => $row['kabupaten'] ?? null,
            'kecamatan' => $row['kecamatan'] ?? null,
            'kelurahan' => $row['kelurahan'] ?? null,
            'dusun' => $row['desa'] ?? null,
        ]);
    }

    #[NoReturn]
    public function onError(Throwable $e): void
    {
        Log::error($e);
        Notification::make('Error Impor')
            ->title('Terjadi kesalahan saat mengimpor. Import Di batalkan')
            ->body($e)
            ->danger()
            ->sendToDatabase(auth()->user());
    }

    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $baris = $failure->row();
            $errmsg = $failure->errors()[0];
            $values = $failure->values();

            Notification::make('Failure Import')
                ->title('Baris Ke : ' . $baris . ' | ' . $errmsg)
                ->body('NIK : ' . $values['nik'] ?? '-' . ' | No.KK : ' . $values['no_kk'] ?? '-' . '
             | Nama : ' . $values['nama_lengkap'] ?? '-')
                ->danger()
                ->sendToDatabase(auth()->user())
                ->broadcast(User::where('is_admin', 1)->get());

            Log::error($errmsg);
        }
    }

    public function rules(): array
    {
        return [
            'nik' => Rule::unique('peserta_bpjs', 'nik'),

            // Above is alias for as it always validates in batches
            '*.nik' => Rule::unique('peserta_bpjs', 'nik'),
        ];
    }

    public function uniqueBy(): array
    {
        return ['nik'];
    }


    public function batchSize(): int
    {
        return 2000;
    }

    public function chunkSize(): int
    {
        return 2000;
    }
}
