<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\AlasanBpjsEnum;
use App\Enums\StatusMutasi;
use App\Enums\TipeMutasiEnum;
use App\Models\MutasiBpjs as UsulanMutasiBpjs;
use App\Models\PesertaBpjs;
use App\Models\User;
use Auth;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
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
use Throwable;

final class ImportMutasiBpjs implements
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
        $user = Auth::user();
        Notification::make('Mulai Mengimpor')
            ->title('Data Mutasi Bpjs sedang di impor ke database.')
            ->info()
            ->send()
            ->sendToDatabase($user);
    }

    public static function afterImport(AfterImport $event): void
    {
        $user = Auth::user();
        Notification::make('Impor Berhasil')
            ->title('Data Mutasi BPJS Berhasil di impor.')
            ->success()
            ->send();
    }

    public static function importFailed(ImportFailed $event): void
    {
        $user = Auth::user();
        Notification::make('Import Failed')
            ->title('Gagal Impor Mutasi BPJS '.$event->e->getMessage())
            ->danger()
            ->send()
            ->sendToDatabase($user);
    }

    public static function afterChunk(AfterChunk $event): void
    {
        $user = Auth::user();
        Notification::make('Chunk Berhasil')
            ->title('Berhasil mengimport')
            ->success()
            ->send();
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => [self::class, 'beforeImport'],
            AfterImport::class => [self::class, 'afterImport'],
            ImportFailed::class => [self::class, 'importFailed'],
        ];
    }

    public function model(array $row): Model|UsulanMutasiBpjs|null
    {
        $pesertaBpjs = PesertaBpjs::query()->where('nik', $row['nik'])->first();
        $data = [
            'peserta_bpjs_id' => $pesertaBpjs->id ?? null,
            'nama_lengkap' => $pesertaBpjs->nama_lengkap ?? $row['nama_lengkap'],
            'nik' => $pesertaBpjs->nik ?? $row['nik'],
            'nomor_kartu' => $pesertaBpjs->nomor_kartu ?? $row['nomor_kartu'],
            'alasan_mutasi' => match ($row['alasan_mutasi']) {
                AlasanBpjsEnum::MAMPU => AlasanBpjsEnum::MAMPU,
                AlasanBpjsEnum::MENINGGAL => AlasanBpjsEnum::MENINGGAL,
                AlasanBpjsEnum::GANDA => AlasanBpjsEnum::GANDA,
                AlasanBpjsEnum::PINDAH => AlasanBpjsEnum::PINDAH,
            },
            'alamat_lengkap' => $pesertaBpjs->alamat ?? $row['alamat'],
            'periode_bulan' => $row['periode_bulan'] ?? now()->month,
            'periode_tahun' => $row['periode_tahun'] ?? now()->year,
            'status_mutasi' => match ($row['status_mutasi']) {
                StatusMutasi::MUTASI, 'default' => StatusMutasi::MUTASI,
                StatusMutasi::BATAL => StatusMutasi::BATAL,
            },
            'tipe_mutasi' => match ($row['tipe_mutasi']) {
                TipeMutasiEnum::PESERTA_BPJS, 'default' => TipeMutasiEnum::PESERTA_BPJS,
                TipeMutasiEnum::PROGRAM_BPJS => TipeMutasiEnum::PROGRAM_BPJS,
            },
            'model_name' => null,
            'keterangan' => $row['keterangan'],
        ];

        return UsulanMutasiBpjs::query()->firstOrCreate($data);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

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
                ->title('Baris Ke : '.$baris.' | '.$errmsg)
                ->body('NIK : '.$values['nik'] ?? '-'.' | No.KK : '.$values['no_kk'] ?? '-'.'
             | Nama : '.$values['nama_lengkap'] ?? '-')
                ->danger()
                ->sendToDatabase(auth()->user())
                ->broadcast(User::where('is_admin', 1)->get());

            Log::error($errmsg);
        }
    }

    public function rules(): array
    {
        return [
            'nik' => Rule::unique('mutasi_bpjs', 'peserta_bpjs_id'),

            // Above is alias for as it always validates in batches
            '*.nik' => Rule::unique('mutasi_bpjs', 'peserta_bpjs_id'),
        ];
    }

    public function uniqueBy(): array
    {
        return ['nik'];
    }
}
