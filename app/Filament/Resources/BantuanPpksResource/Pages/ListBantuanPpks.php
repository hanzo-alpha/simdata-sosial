<?php

namespace App\Filament\Resources\BantuanPpksResource\Pages;

use App\Exports\ExportBantuanPpks;
use App\Filament\Resources\BantuanPpksResource;
use App\Models\BantuanPpks;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBantuanPpks extends ListRecords
{
    protected static string $resource = BantuanPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Ekspor XLS')
                ->color('success')
                ->exports([
                    ExportBantuanPpks::make()
                ]),

            Actions\CreateAction::make(),

            Actions\Action::make('import')
                ->model(BantuanPpks::class)
                ->label('Impor Data')
                ->modalHeading('Unggah Data Bantuan PPKS')
                ->modalDescription('Unggah data PPKS ke database dari file excel')
                ->modalSubmitActionLabel('Unggah')
                ->modalIcon('heroicon-o-arrow-up-tray')
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
                    $import = Excel::import(new ImportBantuanPpks, $data['attachment'], 'public');
                    if ($import) {
                        Notification::make()
                            ->title('Data PPKS Berhasil di impor')
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }
                })
                ->icon('heroicon-o-arrow-up-tray')
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
