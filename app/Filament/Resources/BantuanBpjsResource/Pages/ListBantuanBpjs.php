<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanBpjsResource\Pages;

use App\Exports\ExportBantuanBpjs;
use App\Filament\Resources\BantuanBpjsResource;
use App\Filament\Widgets\BantuanBpjsOverview;
use App\Imports\ImportBantuanBpjs;
use App\Models\BantuanBpjs;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBantuanBpjs extends ListRecords
{
    use HasInputDateLimit;

    protected static string $resource = BantuanBpjsResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            BantuanBpjsOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Ekspor Data')
                ->color('success')
                ->exports([
                    ExportBantuanBpjs::make()
                        ->except(['created_at', 'updated_at', 'deleted_at']),
                ]),

            Actions\Action::make('import')
                ->model(BantuanBpjs::class)
                ->label('Impor Data')
                ->modalHeading('Unggah Bantuan BPJS')
                ->modalDescription('Unggah Bantuan BPJS ke database')
                ->modalSubmitActionLabel('Unggah')
                ->color('info')
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
                        ]),
                ])
                ->action(function (array $data): void {
                    $import = new ImportBantuanBpjs();
                    $import->import($data['attachment'], 'public');
                })
                ->after(function (): void {
                    Notification::make()
                        ->title('Bantuan BPJS Berhasil di impor')
                        ->success()
                        ->send()
                        ->sendToDatabase(auth()->user());
                })
                ->icon('heroicon-o-arrow-down-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->successRedirectUrl(route('filament.admin.resources.program-bpjs.index'))
                ->modalWidth('md'),

            Actions\CreateAction::make()
                ->disabled($this->enableInputLimitDate())
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }
}
