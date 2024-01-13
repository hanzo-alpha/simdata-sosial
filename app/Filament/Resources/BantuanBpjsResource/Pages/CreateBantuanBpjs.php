<?php

namespace App\Filament\Resources\BantuanBpjsResource\Pages;

use App\Filament\Resources\BantuanBpjsResource;
use App\Models\MutasiBpjs;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateBantuanBpjs extends CreateRecord
{
    protected static string $resource = BantuanBpjsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['dtks_id'] = $data['dtks_id'] ?? \Str::uuid()->toString();
        $data['bulan'] = now()->month;
        $data['tahun'] = now()->year;

        return $data;
    }

    //    protected function handleRecordCreation(array $data): Model
    //    {
    //        if (isset($data['mutasi']) && count($data['mutasi']) > 0) {
    //            MutasiBpjs::create([
    //                'keluarga_yang_dimutasi_id' => $data['mutasi']['keluarga_id'],
    //                'bantuan_bpjs_id' => $data['id'] ?? 1,
    //                'alasan_mutasi' => $data['mutasi']['alasan_dimutasi'],
    //            ]);
    //        }
    //
    //        return $this->getModel()::create($data);
    //    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Bantuan BPJS berhasil disimpan';
    }
}
