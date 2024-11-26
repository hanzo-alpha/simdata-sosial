<?php

declare(strict_types=1);

namespace App\Filament\Resources\PesertaBpjsResource\Pages;

use App\Filament\Resources\PesertaBpjsResource;
use App\Filament\Resources\PesertaBpjsResource\Widgets\PesertaBpjsOverview;
use App\Imports\ImportPesertaBpjs;
use App\Models\PesertaBpjs;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;

class ManagePesertaBpjs extends ManageRecords
{
    use ExposesTableToWidgets;
    use HasInputDateLimit;

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
                ->mutateFormDataUsing(function (array $data) {
                    $data['bulan'] ??= now()->month;
                    $data['tahun'] ??= now()->year;
                    return $data;
                })
                ->action(function (array $data): void {
                    PesertaBpjs::query()->forceDelete();
                    Notification::make()
                        ->title('Data Peserta BPJS sedang diimpor secara background')
                        ->info()
                        ->sendToDatabase(auth()->user());
                    Excel::import(new ImportPesertaBpjs(), $data['attachment'], 'public');
                })
                ->after(function (): void {
                    Notification::make()
                        ->title('Data Peserta BPJS berhasil diunggah')
                        ->success()
                        ->sendToDatabase(auth()->user());
                })
                ->icon('heroicon-o-arrow-down-tray')
//                ->disabled($this->enableInputLimitDate('bpjs'))
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.peserta-bpjs.index'))
                ->modalWidth('lg'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PesertaBpjsOverview::class,
        ];
    }

}
