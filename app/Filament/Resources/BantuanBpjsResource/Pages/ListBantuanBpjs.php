<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanBpjsResource\Pages;

use App\Exports\ExportBantuanBpjs;
use App\Filament\Resources\BantuanBpjsResource;
use App\Filament\Widgets\BantuanBpjsOverview;
use App\Imports\ImportBantuanBpjs;
use App\Models\BantuanBpjs;
use App\Models\Kecamatan;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBantuanBpjs extends ListRecords
{
    use HasInputDateLimit;

    protected static string $resource = BantuanBpjsResource::class;

    public function getTabs(): array
    {
        $results = collect();

        if (auth()->user()->hasRole(['admin','super_admin'])) {
            $bantuan = Kecamatan::query()->where('kabupaten_code', setting('app.kodekab'))->get();
            $bantuan->each(function ($item, $key) use (&$results): void {
                $results->put('semua', Tab::make()
                    ->badge(BantuanBpjs::query()->count()));
                $results->put(Str::lower($item->name), Tab::make()
                    ->badge(BantuanBpjs::query()->whereHas(
                        'kec',
                        function (Builder $query) use ($item): void {
                            $query->where('bantuan_bpjs.kecamatan', $item->code);

                        },
                    )->count())
                    ->modifyQueryUsing(
                        fn(Builder $query) => $query->whereHas(
                            'kec',
                            function (Builder $query) use ($item): void {
                                $query->where('bantuan_bpjs.kecamatan', $item->code);

                            },
                        ),
                    ));
            });

            return $results->toArray();
        }

        return $results->toArray();

    }

//    protected function getHeaderWidgets(): array
//    {
//        return [
//            BantuanBpjsOverview::class,
//        ];
//    }

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Download')
                ->color('success')
                ->exports([
                    ExportBantuanBpjs::make()
                        ->except(['foto_ktp','dusun','tahun','bulan','created_at', 'updated_at', 'deleted_at']),
                ])
                ->disabled(fn(): bool => cek_batas_input(setting('app.batas_tgl_input'))),

            Actions\Action::make('Upload')
                ->model(BantuanBpjs::class)
                ->label('Upload')
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
                ->icon('heroicon-o-arrow-up-tray')
                ->modalAlignment(Alignment::Center)
                ->closeModalByClickingAway(false)
                ->disabled(fn(): bool => cek_batas_input(setting('app.batas_tgl_input')))
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
