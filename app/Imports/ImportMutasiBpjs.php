<?php

namespace App\Imports;

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

class ImportMutasiBpjs implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, ShouldQueue, SkipsEmptyRows
{
    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $event) {
                Notification::make('Import Failed')
                    ->title('Gagal Impor Mutasi BPJS')
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
    public function model(array $row): Model|UsulanMutasiBpjs|null
    {
        return new UsulanMutasiBpjs([
            'nama_lengkap' => $row['nama_lengkap'],
            'nokk_tmt' => $row['no_kk'],
            'nik_tmt' => $row['nik'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'nomor_kartu' => $row['nomor_kartu'],
            'alasan_mutasi' => $row['alasan_mutasi'],
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
