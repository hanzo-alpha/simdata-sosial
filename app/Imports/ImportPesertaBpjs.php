<?php

namespace App\Imports;

use App\Models\PesertaBpjs as PesertaJamkesda;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\ImportFailed;

class ImportPesertaBpjs implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue, SkipsEmptyRows
{
    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event) {
                Notification::make('Import Failed')
                    ->title('Gagal Impor Peserta JAMKESDA')
                    ->danger()
                    ->send()
                    ->sendToDatabase(auth()->user());
            },
        ];
    }

    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|\App\Models\MutasiBpjs|null
     */
    public function model(array $row): Model|PesertaJamkesda|null
    {
        return new PesertaJamkesda([
            'nomor_kartu' => $row['no_kartu'] ?? 'NO KARTU',
            'nik' => $row['nik'] ?? 'NO NIK',
            'nama_lengkap' => $row['nama'] ?? 'NO NAME',
            'alamat' => $row['alamat'] ?? 'NO ALAMAT',
            'no_rt' => null,
            'no_rw' => null,
            'kabupaten' => null,
            'kecamatan' => null,
            'kelurahan' => null,
            'dusun' => null,
        ]);
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