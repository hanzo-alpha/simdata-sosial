<?php

namespace App\Filament\Resources\DataRastraResource\Pages;

use App\Enums\StatusVerifikasiEnum;
use App\Filament\Resources\DataRastraResource;
use App\Models\PenggantiRastra;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDataRastra extends CreateRecord
{
    protected static string $resource = DataRastraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['dtks_id'] = $data['dtks_id'] ?? \Str::uuid()->toString();
        $data['jenis_bantuan_id'] = $data['jenis_bantuan_id'] ?? 5;
        $data['tgl_penyerahan'] = $data['tgl_penyerahan'] ?? now();
        $data['lokasi_map'] = $data['location'];
        $data['status_verifikasi'] = (auth()->user()?->hasRole(['operator']))
            ? StatusVerifikasiEnum::UNVERIFIED
            : $data['status_verifikasi'];
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        if (isset($data['pengganti_rastra']) && count($data['pengganti_rastra']) > 0) {
            PenggantiRastra::create([
                'keluarga_yang_diganti_id' => $data['pengganti_rastra']['keluarga_id'],
                'bantuan_rastra_id' => $data['pengganti_rastra']['keluarga_id'],
                'nik_pengganti' => $data['nik_kpm'],
                'nokk_pengganti' => $data['nokk_kpm'],
                'nama_pengganti' => $data['nama_kpm'],
                'alamat_pengganti' => $data['alamat_kpm'],
                'alasan_dikeluarkan' => $data['pengganti_rastra']['alasan_dikeluarkan'],
            ]);
        }

        return $this->getModel()::create($data);
    }
}
