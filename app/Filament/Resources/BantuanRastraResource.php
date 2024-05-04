<?php

namespace App\Filament\Resources;

use App\Enums\AlasanEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Exports\ExportBantuanRastra;
use App\Filament\Resources\BantuanRastraResource\Pages;
use App\Models\BantuanRastra;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\PenggantiRastra;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class BantuanRastraResource extends Resource
{
    protected static ?string $model = BantuanRastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $slug = 'program-rastra';
    protected static ?string $label = 'Program Rastra';
    protected static ?string $pluralLabel = 'Program Rastra';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 4;

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->deferLoading()
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->description(fn($record) => $record->nik)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('N I K')
                    ->alignCenter()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->label('No. KK')
                    ->alignCenter()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->sortable()
                    ->toggleable()
                    ->description(function ($record): void {
                        'Kec. ' . $record->kec->name . ' Kel. ' . $record->kel->name;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_rastra')
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label('Status Rastra')
                    ->badge(),
                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label('Status Verifikasi')
                    ->badge(),
                Tables\Columns\TextColumn::make('status_aktif')
                    ->alignCenter()
                    ->toggleable()
                    ->label('Status Aktif')
                    ->sortable()
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('kecamatan')
                    ->options(function () {
                        return Kecamatan::query()
                            ->where('kabupaten_code', setting('app.kodekab'))
                            ->pluck('name', 'code');
                    })
                    ->searchable()
                    ->native(false),
                SelectFilter::make('kelurahan')
                    ->options(function () {
                        return Kelurahan::query()
                            ->whereIn('kecamatan_code', config('custom.kode_kecamatan'))
                            ->pluck('name', 'code');
                    })
                    ->searchable()
                    ->native(false),
                SelectFilter::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options(StatusVerifikasiEnum::class)
                    ->native(false)
                    ->searchable(),
                SelectFilter::make('status_rastra')
                    ->label('Status Rastra')
                    ->options(StatusRastra::class)
                    ->native(false)
                    ->searchable(),
                SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(list_tahun())
                    ->attribute('tahun')
                    ->searchable(),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->deferFilters()
            ->persistFiltersInSession()
            ->deselectAllRecordsWhenFiltered()
            ->hiddenFilterIndicators()
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\Action::make('Toggle Aktif')
                        ->icon('heroicon-s-arrow-path-rounded-square')
                        ->action(function ($record): void {
                            $record->status_aktif = match ($record->status_aktif) {
                                StatusAktif::AKTIF => StatusAktif::NONAKTIF,
                                StatusAktif::NONAKTIF => StatusAktif::AKTIF,
                            };

                            $record->save();
                        })
                        ->after(function (): void {
                            Notification::make()
                                ->success()
                                ->title('Status Berhasil Diubah')
                                ->send();
                        })
                        ->close(),
                    //                    Tables\Actions\Action::make('Toggle Status Rastra')
                    //                        ->icon('heroicon-s-arrow-path-rounded-square')
                    //                        ->form([
                    //                            //                            Select::make('pengganti_rastra.keluarga_id')
                    //                            //                                ->label('Keluarga Yang Diganti')
                    //                            //                                ->required()
                    //                            //                                ->options(BantuanRastra::query()
                    //                            //                                    ->where('status_rastra', StatusRastra::BARU)
                    //                            //                                    ->pluck('nama_lengkap', 'id'))
                    //                            //                                ->searchable(['nama_lengkap', 'nik', 'nokk'])
                    //                            //                                ->lazy()
                    //                            //                                ->preload(),
                    //                            Select::make('pengganti_rastra.alasan_dikeluarkan')
                    //                                ->searchable()
                    //                                ->options(AlasanEnum::class)
                    //                                ->enum(AlasanEnum::class)
                    //                                ->native(false)
                    //                                ->preload()
                    //                                ->lazy()
                    //                                ->required()
                    //                                ->default(AlasanEnum::PINDAH),
                    //                        ])
                    //                        ->modalWidth(MaxWidth::Medium)
                    //                        ->action(function ($record, array $data): void {
                    //                            PenggantiRastra::create([
                    //                                'keluarga_yang_diganti_id' => $record->id,
                    //                                'bantuan_rastra_id' => $data['pengganti_rastra']['keluarga_id'],
                    //                                'nik_pengganti' => $record->nik,
                    //                                'nokk_pengganti' => $record->nokk,
                    //                                'nama_pengganti' => $record->nama_lengkap,
                    //                                'alamat_pengganti' => $record->alamat,
                    //                                'alasan_dikeluarkan' => $data['pengganti_rastra']['alasan_dikeluarkan'],
                    //                            ]);
                    //
                    //                            $record->status_rastra = match ($record->status_rastra) {
                    //                                StatusRastra::BARU => StatusRastra::PENGGANTI,
                    //                                StatusRastra::PENGGANTI => StatusRastra::BARU,
                    //                            };
                    //
                    //                            $record->save();
                    //                        })
                    //                        ->after(function (): void {
                    //                            Notification::make()
                    //                                ->success()
                    //                                ->title('Status Berhasil Diubah')
                    //                                ->send();
                    //                        })
                    //                        ->close(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    ExportBulkAction::make()
                        ->label('Ekspor Ke Excel')
                        ->exports([
                            ExportBantuanRastra::make(),
                        ]),
                    Tables\Actions\BulkAction::make('toggle aktif')
                        ->label('Toggle Status Aktif')
                        ->icon('heroicon-o-cursor-arrow-ripple')
                        ->action(function ($records): void {
                            $records->each(function ($records): void {
                                $records->status_aktif = match ($records->status_aktif) {
                                    StatusAktif::AKTIF => StatusAktif::NONAKTIF,
                                    StatusAktif::NONAKTIF => StatusAktif::AKTIF,
                                };

                                $records->save();
                            });
                        })
                        ->after(function (): void {
                            Notification::make()
                                ->success()
                                ->title('Status Berhasil Diubah')
                                ->send();
                        })
                        ->closeModalByClickingAway()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Data Keluarga')
                        ->schema(BantuanRastra::getKeluargaForm())->columns(2),
                    Section::make('Data Alamat')
                        ->schema(BantuanRastra::getAlamatForm())->columns(2),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Section::make('Status')
                        ->schema(BantuanRastra::getStatusForm()),

                    Forms\Components\Section::make('Verifikasi')
                        ->schema(BantuanRastra::getUploadForm())
                        ->visible(auth()->user()?->hasRole(['admin', 'super_admin'])),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Group::make([
                    \Filament\Infolists\Components\Section::make('Informasi Keluarga')
                        ->schema([
                            TextEntry::make('status_dtks')
                                ->label('Status DTKS')
                                ->weight(FontWeight::SemiBold)
                                ->icon('heroicon-o-identification')
                                ->color('primary'),
                            TextEntry::make('nokk')
                                ->label('No. Kartu Keluarga (KK)')
                                ->weight(FontWeight::SemiBold)
                                ->copyable()
                                ->icon('heroicon-o-identification')
                                ->color('primary'),
                            TextEntry::make('nik')
                                ->label('No. Induk Kependudukan (NIK)')
                                ->weight(FontWeight::SemiBold)
                                ->icon('heroicon-o-identification')
                                ->copyable()
                                ->color('primary'),
                            TextEntry::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->weight(FontWeight::SemiBold)
                                ->icon('heroicon-o-user')
                                ->color('primary'),

                        ])->columns(2),
                    \Filament\Infolists\Components\Section::make('Informasi Alamat')
                        ->schema([
                            TextEntry::make('alamat')
                                ->label('Alamat')
                                ->icon('heroicon-o-map-pin')
                                ->weight(FontWeight::SemiBold)
                                ->color('primary')
                                ->columnSpanFull(),
                            TextEntry::make('kec.name')
                                ->label('Kecamatan'),
                            TextEntry::make('kel.name')
                                ->label('Kelurahan'),
                            TextEntry::make('dusun')
                                ->label('Dusun'),
                            TextEntry::make('no_rt')
                                ->label('RT/RW')
                                ->formatStateUsing(fn($record) => $record->no_rt . '/' . $record->no_rw),
                        ])->columns(2),
                ])->columnSpan(2),

                \Filament\Infolists\Components\Group::make([
                    \Filament\Infolists\Components\Section::make('Informasi Bantuan Dan Status Penerima')
                        ->schema([
                            TextEntry::make('status_verifikasi')
                                ->label('Status Verifikasi')
                                ->badge(),
                            TextEntry::make('status_rastra')
                                ->label('Status Rastra')
                                ->badge(),
                            TextEntry::make('status_aktif')
                                ->label('Status Aktif')
                                ->badge(),
                        ])
                        ->columns(3),
                    \Filament\Infolists\Components\Section::make('Informasi Verifikasi Foto')
                        ->schema([
                            ImageEntry::make('foto_ktp_kk')
                                ->hiddenLabel()
                                ->columnSpanFull()
                                ->alignCenter()
                                ->extraImgAttributes([
                                    'alt' => 'foto ktp kk',
                                    'loading' => 'lazy',
                                ]),
                        ])->columns(1),
                ])->columns(1),

            ])->columns(3);
    }

    public static function getWidgets(): array
    {
        return [
            //            BantuanRastraOverview::class,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['kec', 'kel', 'kab']);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBantuanRastra::route('/'),
            'create' => Pages\CreateBantuanRastra::route('/create'),
            'view' => Pages\ViewBantuanRastra::route('/{record}'),
            'edit' => Pages\EditBantuanRastra::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole(['super_admin'])) {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        }

        return parent::getEloquentQuery()
            ->where('kelurahan', auth()->user()->instansi_id)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
