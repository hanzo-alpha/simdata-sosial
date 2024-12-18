<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\AlasanBpjsEnum;
use App\Models\MutasiBpjs as UsulanMutasiBpjs;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\ImportFailed;

final class ImportMutasiBpjs implements ShouldQueue, SkipsEmptyRows, ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event): void {
                Notification::make('Import Failed')
                    ->title('Gagal Impor Mutasi BPJS')
                    ->danger()
                    ->send()
                    ->sendToDatabase(auth()->user());
            },
        ];
    }

    public function model(array $row): Model|UsulanMutasiBpjs|null
    {
        return new UsulanMutasiBpjs([
            'nama_lengkap' => $row['nama_lengkap'],
            'nokk_tmt' => $row['no_kk'],
            'nik_tmt' => $row['nik'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'nomor_kartu' => $row['nomor_kartu'],
            'alasan_mutasi' => match ($row['alasan_mutasi']) {
                AlasanBpjsEnum::MAMPU => AlasanBpjsEnum::MAMPU,
                AlasanBpjsEnum::MENINGGAL => AlasanBpjsEnum::MENINGGAL,
                AlasanBpjsEnum::GANDA => AlasanBpjsEnum::GANDA,
                AlasanBpjsEnum::PINDAH => AlasanBpjsEnum::PINDAH,
            },
            'alamat' => $row['alamat'],
            'keterangan' => $row['keterangan'],
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
}
