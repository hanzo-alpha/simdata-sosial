<?php

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Filament\Resources\BantuanRastraResource;
use App\Models\PenggantiRastra;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateBantuanRastra extends CreateRecord
{
    protected static string $resource = BantuanRastraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['dtks_id'] = $data['dtks_id'] ?? \Str::uuid()->toString();
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        if (isset($data['pengganti_rastra']) && count($data['pengganti_rastra']) > 0) {
            PenggantiRastra::create([
                'keluarga_yang_diganti_id' => $data['pengganti_rastra']['keluarga_id'],
                'bantuan_rastra_id' => $data['pengganti_rastra']['keluarga_id'],
                'nik_pengganti' => $data['nik'],
                'nokk_pengganti' => $data['nokk'],
                'nama_pengganti' => $data['nama_lengkap'],
//                'alamat_pengganti' => $data['alamat'],
                'alasan_dikeluarkan' => $data['pengganti_rastra']['alasan_dikeluarkan'],
            ]);
        }

        return $this->getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Bantuan Rastra berhasil disimpan';
    }
}
