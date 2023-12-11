<?php

namespace App\Filament\Resources\UsulanMutasiTmtResource\Pages;

use App\Filament\Resources\UsulanMutasiTmtResource;
use App\Imports\ImportUsulanMutasiTmt;
use App\Models\UsulanPengaktifanTmt;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;

class ManageUsulanMutasiTmt extends ManageRecords
{
    protected static string $resource = UsulanMutasiTmtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('unggahData')
                ->model(UsulanPengaktifanTmt::class)
                ->label('Unggah Data')
                ->modalHeading('Unggah Usulan Mutasi TMT')
                ->modalDescription('Unggah Usulan Mutasi TMT ke database')
                ->modalSubmitActionLabel('Unggah')
                ->color('success')
                ->modalIcon('heroicon-o-arrow-down-tray')
                ->form([
                    FileUpload::make('attachment')
                        ->label('Impor')
                        ->hiddenLabel()
                        ->columnSpanFull()
                        ->preserveFilenames()
                        ->previewable(false)
                        ->directory('upload')
                        ->maxSize(5120)
                        ->reorderable()
                        ->appendFiles()
                        ->storeFiles(false)
                        ->acceptedFileTypes([
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/csv'
                        ])
//                        ->hiddenOn(['edit', 'view']),
                ])
                ->action(function (array $data): void {
                    $import = Excel::import(new ImportUsulanMutasiTmt, $data['attachment'], 'public');
                    if ($import) {
                        Notification::make()
                            ->title('Usulan Mutasi TMT Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }
                })
//                ->icon('heroicon-o-arrow-down-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.usulan-mutasi-tmt.index'))
                ->modalWidth('lg'),

            Actions\CreateAction::make()
        ];
    }
}
