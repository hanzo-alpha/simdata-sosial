<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusBpjsEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusUsulanEnum;
use App\Models\BantuanBpjs as DataBantuanBpjs;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
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
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterChunk;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Validators\Failure;
use Str;
use Throwable;

class ImportBantuanBpjs implements
    ShouldQueue,
    SkipsEmptyRows,
    SkipsOnError,
    SkipsOnFailure,
    ToModel,
    WithBatchInserts,
    WithChunkReading,
    WithHeadingRow,
    WithUpserts,
    WithValidation,
    WithEvents
{
    use Importable;
    use RegistersEventListeners;
    use SkipsErrors;
    use SkipsFailures;

    public static function beforeImport(BeforeImport $event): void
    {
        Notification::make('Mulai Mengimpor')
            ->title('Data Bantuan Bpjs sedang di impor ke database.')
            ->info()
            ->sendToDatabase(auth()->user());
    }

    public static function afterImport(AfterImport $event): void
    {
        Notification::make('Impor Berhasil')
            ->title('Data Bantuan BPJS Berhasil di impor')
            ->success()
            ->sendToDatabase(auth()->user());
    }

    public static function afterChunk(AfterChunk $event): void
    {
        Notification::make('Impor Berhasil')
            ->title('Data Bantuan BPJS Berhasil di impor')
            ->success()
            ->sendToDatabase(auth()->user());
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event): void {
                Notification::make('Import Failed')
                    ->title('Gagal mengimpor usulan BPJS')
                    ->danger()
                    ->sendToDatabase(auth()->user());
            },
            //            AfterImport::class => function (AfterImport $event): void {
            //                Notification::make('Impor Berhasil')
            //                    ->title('Data Bantuan BPJS Berhasil di impor')
            //                    ->success()
            //                    ->sendToDatabase(auth()->user());
            //            },
            //            BeforeImport::class => function (BeforeImport $event): void {
            //                Notification::make('Mulai Mengimpor')
            //                    ->title('Data Bantuan Bpjs sedang di impor ke database.')
            //                    ->info()
            //                    ->sendToDatabase(auth()->user());
            //            },
        ];
    }

    /**
     * @throws \Random\RandomException
     */
    public function model(array $row): Model|DataBantuanBpjs|null
    {
        $kecamatan = Kecamatan::query()
            ->where('kabupaten_code', config('custom.default.kodekab'))
            ->where('name', Str::ucfirst($row['kecamatan']))
            ->first()?->code;

        $kelurahan = Kelurahan::query()
            ->where('kecamatan_code', $kecamatan)
            ->where('name', Str::ucfirst($row['kelurahan']))
            ->first()?->code;

        $jenkel = match ($row['jenis_kelamin']) {
            'P', 2 => JenisKelaminEnum::PEREMPUAN,
            default => JenisKelaminEnum::LAKI,
        };

        $bulan = (isset($row['periode_bulan']) && 0 !== $row['periode_bulan']) ? (int) bulan_to_integer($row['periode_bulan']) : now()->month;
        $rowStatus = $row['status_usulan'] ?: $row['status_tl'];

        $statusUsulan = Str::of($rowStatus)->matchAll('/[a-zA-Z]+/');

        $usulan = match ($statusUsulan[0]) {
            'BERHASIL' => StatusUsulanEnum::BERHASIL,
            'GAGAL', 'DOMISILI', 'NIK' => StatusUsulanEnum::GAGAL,
            default => StatusUsulanEnum::ONPROGRESS,
        };

        $aktif = match ($statusUsulan[0]) {
            'BERHASIL' => StatusAktif::AKTIF,
            default => StatusAktif::NONAKTIF,
        };

        $statusNikah = match ($row['status_nikah']) {
            StatusKawinBpjsEnum::KAWIN->getLabel() => StatusKawinBpjsEnum::KAWIN,
            StatusKawinBpjsEnum::BELUM_KAWIN->getLabel() => StatusKawinBpjsEnum::BELUM_KAWIN,
            StatusKawinBpjsEnum::JANDA->getLabel() => StatusKawinBpjsEnum::JANDA,
            StatusKawinBpjsEnum::DUDA->getLabel() => StatusKawinBpjsEnum::DUDA,
        };

        $statusBpjs = match ($row['status_bpjs']) {
            default => StatusBpjsEnum::PENGAKTIFAN,
            StatusBpjsEnum::PENGALIHAN->getLabel() => StatusBpjsEnum::PENGALIHAN,
            StatusBpjsEnum::BARU->getLabel() => StatusBpjsEnum::BARU,
        };

        return new DataBantuanBpjs([
            'nomor_kartu' => null,
            'dtks_id' => Str::upper(Str::orderedUuid()->toString()),
            'nokk_tmt' => $row['no_kk'] ?? '-',
            'nik_tmt' => $row['nik'] ?? '-',
            'nama_lengkap' => $row['nama_lengkap'] ?? '-',
            'tempat_lahir' => $row['tempat_lahir'] ?? '-',
            'tgl_lahir' => now()->subDays(random_int(0, 180))
                ->subYears(random_int(10, 50))->format('Y-m-d'),
            'tgl_lahir_tmp' => $row['tgl_lahir'] ?? null,
            'jenis_kelamin' => $jenkel ?? 1,
            'status_nikah' => $statusNikah ?? 1,
            'alamat' => $row['alamat_tempat_tinggal'] ?? '-',
            'nort' => $row['rt'] ?? '001',
            'norw' => $row['rw'] ?? '002',
            'kodepos' => $row['kode_pos'],
            'kecamatan' => $kecamatan ?? $row['kecamatan'],
            'kelurahan' => $kelurahan ?? $row['kelurahan'],
            'status_aktif' => $aktif,
            'status_bpjs' => $statusBpjs,
            'status_usulan' => $usulan,
            'keterangan' => $row['keterangan'] ?? $rowStatus,
            'bulan' => $bulan,
            'tahun' => $row['tahun'] ?? now()->year,
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

            //            Notification::make('Failure Import')
            //                ->title('Baris Ke : ' . $baris . ' | ' . $errmsg)
            //                ->body('NIK : ' . $values['nik'] ?? '-' . ' | No.KK : ' . $values['no_kk'] ?? '-' . '
            // | Nama : ' . $values['nama_lengkap'] ?? '-')
            //                ->danger()
            //                ->sendToDatabase(auth()->user())
            //                ->broadcast(User::where('is_admin', 1)->get());

            Log::error($errmsg);
        }
    }

    public function uniqueBy(): array
    {
        return ['nik'];
    }
}
