<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanRastraResource\Pages;

use App\Enums\StatusAktif;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Filament\Resources\BantuanRastraResource;
use App\Models\BantuanRastra;
use App\Models\PenggantiRastra;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateBantuanRastra extends CreateRecord
{
    protected static string $resource = BantuanRastraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['jenis_bantuan_id'] = 5;
        $data['status_verifikasi'] ??= StatusVerifikasiEnum::UNVERIFIED;
        $data['status_rastra'] ??= StatusRastra::BARU;
        $data['status_aktif'] ??= StatusAktif::AKTIF;
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        if (isset($data['penggantiRastra']) && count($data['penggantiRastra']) > 0) {
            $rastra = BantuanRastra::find($data['penggantiRastra']['keluarga_id']);
            PenggantiRastra::create([
                'bantuan_rastra_id' => $data['penggantiRastra']['keluarga_id'],
                'nokk_lama' => $rastra?->nokk,
                'nik_lama' => $rastra?->nik,
                'nama_lama' => $rastra?->nama_lengkap,
                'alamat_lama' => $rastra?->alamat,
                'nik_pengganti' => $data['nik'],
                'nokk_pengganti' => $data['nokk'],
                'nama_pengganti' => $data['nama_lengkap'],
                'alamat_pengganti' => $data['alamat'],
                'alasan_dikeluarkan' => $data['penggantiRastra']['alasan_dikeluarkan'],
                'media_id' => $data['penggantiRastra']['media_id'],
            ]);

            $rastra->pengganti_rastra = $data['penggantiRastra'];
            $rastra->status_rastra = StatusRastra::PENGGANTI;
            $rastra->status_aktif = StatusAktif::NONAKTIF;
            $rastra->status_verifikasi = StatusVerifikasiEnum::UNVERIFIED;

            $rastra->keterangan = 'TELAH DIGANTIKAN DENGAN NIK:' . $data['nik'];
            $rastra->save();
        }

        unset($data['penggantiRastra']);


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
