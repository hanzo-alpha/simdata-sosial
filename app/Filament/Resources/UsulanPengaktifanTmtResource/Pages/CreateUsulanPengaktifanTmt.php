<?php

namespace App\Filament\Resources\UsulanPengaktifanTmtResource\Pages;

use App\Filament\Resources\UsulanPengaktifanTmtResource;
use App\Imports\ImportUsulanPengaktifanTmt;
use App\Models\UsulanPengaktifanTmt;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;

class CreateUsulanPengaktifanTmt extends CreateRecord
{
    protected static string $resource = UsulanPengaktifanTmtResource::class;

//    protected function mutateFormDataBeforeCreate(array $data): array
//    {
//        $data['dtks_id'] = $data['dtks_id'] ?? \Str::uuid()->toString();
//        return $data;
//    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Usulan Pengaktifan TMT berhasil disimpan';
    }

}
