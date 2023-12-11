<?php

namespace App\Filament\Resources\UsulanPengaktifanTmtResource\Pages;

use App\Filament\Resources\UsulanPengaktifanTmtResource;
use App\Imports\ImportUsulanPengaktifanTmt;
use App\Models\UsulanPengaktifanTmt;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;

class ManageUsulanPengaktifanTmt extends ManageRecords
{
    protected static string $resource = UsulanPengaktifanTmtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //            ExportAction::make('upload')
            //                ->label('Ekspor')
            //                ->exports(),
            Actions\Action::make('unggahData')
                ->model(UsulanPengaktifanTmt::class)
                ->label('Unggah Data')
                ->modalHeading('Unggah Usulan Pengaktifan TMT')
                ->modalDescription('Unggah Usulan Pengaktifan TMT ke database')
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
                    $import = Excel::import(new ImportUsulanPengaktifanTmt, $data['attachment'], 'public');
                    if ($import) {
                        Notification::make()
                            ->title('Usulan Pengaktifan TMT Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }
                })
//                ->icon('heroicon-o-arrow-down-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.usulan-pengaktifan-tmt.index'))
                ->modalWidth('lg'),
            Actions\CreateAction::make(),
        ];
    }
}
