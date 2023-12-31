<?php

namespace App\Filament\Resources\BantuanPkhResource\Pages;

use App\Filament\Resources\BantuanPkhResource;
use App\Imports\ImportBantuanPkh;
use App\Models\BantuanPkh;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class ListBantuanPkh extends ListRecords
{
    protected static string $resource = BantuanPkhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('unggahData')
//                ->model(BantuanPkh::class)
                ->label('Unggah Data')
                ->modalHeading('Unggah Data Bantuan PKH')
                ->modalDescription('Unggah data PKH ke database dari file excel')
                ->modalSubmitActionLabel('Unggah')
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
                        ->hiddenOn(['edit', 'view']),
                ])
                ->action(function (array $data): void {
                    $import = new ImportBantuanPkh();
                    $import->import($data['attachment'], 'public');
//                    $import = Excel::import(new ImportBantuanPkh, $data['attachment'], 'public');


                    if ($import) {
                        Notification::make()
                            ->title('Data PKH Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    } else {
                        Notification::make()
                            ->title('Data PKH Gagal di impor')
                            ->danger()
                            ->sendToDatabase(auth()->user());
                    }

//                   Log::error($import->errors());


                })
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.bantuan-pkh.index'))
                ->modalWidth('lg'),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }

}
