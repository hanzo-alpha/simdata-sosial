<?php

namespace App\Filament\Resources;

use App\Enums\StatusAktif;
use App\Enums\StatusRastra;
use App\Enums\StatusVerifikasiEnum;
use App\Exports\ExportBantuanRastra;
use App\Filament\Resources\BantuanRastraResource\Pages;
use App\Filament\Widgets\BantuanRastraOverview;
use App\Models\BantuanRastra;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
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
                //                CuratorColumn::make('beritaAcara')
                //                    ->size(60),
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
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_rastra')
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->label('Status Rastra')
                    ->badge(),
                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->label('Status Verifikasi')
                    ->badge(),
                Tables\Columns\TextColumn::make('status_aktif')
                    ->alignCenter()
                    ->label('Status Aktif')
                    ->sortable()
                    ->badge()
                //                Tables\Columns\ToggleColumn::make('status_aktif')
                //                    ->label('Status Aktif')
                //                    ->afterStateUpdated(function ($record, $state): void {
                //                        if (!auth()->user()?->hasRole(['super_admin', 'admin'])) {
                //                            abort(403);
                //                        }
                //                        $record->status_aktif = match ($state) {
                //                            true => StatusAktif::AKTIF,
                //                            false => StatusAktif::NONAKTIF
                //                        };
                //                        if ($record->save()) {
                //                            Notification::make()
                //                                ->success()
                //                                ->title('Update Status Aktif berhasil')
                //                                ->send();
                //                        } else {
                //                            Notification::make()
                //                                ->danger()
                //                                ->title('Update Status Aktif gagal;')
                //                                ->send();
                //                        }
                //                    })
                //                    ->alignCenter()
                //                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options(StatusVerifikasiEnum::class)
                    ->searchable(),
                SelectFilter::make('status_rastra')
                    ->label('Status Rastra')
                    ->options(StatusRastra::class)
                    ->searchable(),
                SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(list_tahun())
                    ->attribute('tahun')
                    ->searchable(),
            ])
            ->hiddenFilterIndicators()
            ->persistFiltersInSession()
            ->deselectAllRecordsWhenFiltered()
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\Action::make('Ubah Status Aktif')
                        ->icon('heroicon-o-clipboard-document-list')
                        ->action(function ($record): void {
                            $record->status_aktif = match ($record->status_aktif) {
                                StatusAktif::AKTIF => StatusAktif::NONAKTIF,
                                StatusAktif::NONAKTIF => StatusAktif::AKTIF
                            };
                            if ($record->save()) {
                                Notification::make()
                                    ->success()
                                    ->title('Berhasil merubah status usulan peserta')
                                    ->send();
                            } else {
                                Notification::make()
                                    ->danger()
                                    ->title('Berhasil merubah status usulan peserta')
                                    ->send();
                            }
                        })
                        ->close()
                ])
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
                    Tables\Actions\BulkAction::make('ubah status')
                        ->label('Ubah Status Aktif')
                        ->icon('heroicon-o-cursor-arrow-ripple')
                        ->action(function ($records): void {
                            $records->each(function ($records): void {
                                $records->status_aktif = match ($records->status_aktif) {
                                    StatusAktif::AKTIF => StatusAktif::NONAKTIF,
                                    StatusAktif::NONAKTIF => StatusAktif::AKTIF
                                };

                                $records->save();
                            });
                        })
                        ->after(function (): void {
                            Notification::make()
                                ->success()
                                ->title('Berhasil merubah status usulan peserta')
                                ->send();
                        })
                        ->closeModalByClickingAway()
                        ->deselectRecordsAfterCompletion()
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
                        ->visible(auth()->user()?->hasRole(['admin', 'super_admin']))
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
            BantuanRastraOverview::class,
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
