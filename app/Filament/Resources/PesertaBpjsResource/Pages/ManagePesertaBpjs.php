<?php

namespace App\Filament\Resources\PesertaBpjsResource\Pages;

use App\Filament\Resources\PesertaBpjsResource;
use App\Imports\ImportPesertaBpjs;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;

class ManagePesertaBpjs extends ManageRecords
{
    protected static string $resource = PesertaBpjsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Unggah Data')
                ->createAnother(false)
                ->modalHeading('Unggah Data Peserta BPJS')
                ->modalDescription('Unggah Peserta BPJS ke database')
                ->modalSubmitActionLabel('Unggah')
                ->modalIcon('heroicon-o-arrow-down-tray')
                ->action(function (array $data): void {
                    $import = Excel::import(new ImportPesertaBpjs, $data['attachment'], 'public');
                    if ($import) {
                        Notification::make()
                            ->title('Usulan Peserta BPJS Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }
                })
                ->icon('heroicon-o-arrow-down-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.peserta-bpjs.index'))
                ->modalWidth('lg'),
        ];
    }
}