<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanBpntResource\Pages;
use App\Filament\Resources\BantuanBpntResource\Widgets\BantuanBpntOverview;
use App\Models\BantuanBpnt;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Supports\Helpers;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class BantuanBpntResource extends Resource
{
    protected static ?string $model = BantuanBpnt::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $slug = 'program-bpnt';
    protected static ?string $label = 'Program BPNT';
    protected static ?string $pluralLabel = 'Program BPNT';
    protected static ?string $navigationLabel = 'Program BPNT';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'nama_penerima';

    public static function getWidgets(): array
    {
        return [
            BantuanBpntOverview::class,
        ];
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Penerima Manfaat BPNT')->schema([
                    TextInput::make('no_nik')
                        ->label('No. Induk Kependudukan (NIK)')
                        ->required()
                        ->live(debounce: 500)
                        ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                            $livewire->validateOnly($component->getStatePath());
                        })
                        ->minLength(16)
                        ->maxLength(16),
                    TextInput::make('nama_penerima')
                        ->label('Nama Penerima')
                        ->required(),
                    Grid::make()->schema([
                        Select::make('provinsi')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(Provinsi::pluck('name', 'code'))
                            ->default(setting('app.kodeprov', config('custom.default.kodeprov')))
                            ->afterStateUpdated(fn(callable $set) => $set('kabupaten', null)),

                        Select::make('kabupaten')
                            ->nullable()
                            ->options(function (callable $get) {
                                $kab = Kabupaten::query()->where('provinsi_code', $get('provinsi'));
                                if ( ! $kab) {
                                    return Kabupaten::where('code', setting(
                                        'app.kodekab',
                                        config('custom.default.kodekab'),
                                    ))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->reactive()
                            ->default(config('custom.default.kodekab'))
                            ->searchable()
//                            ->hidden(fn (callable $get) => ! $get('kecamatan'))
                            ->afterStateUpdated(fn(callable $set) => $set('kecamatan', null)),
                    ])
//                        ->visibleOn(['edit', 'view'])
                        ->columns(2),
                    Grid::make()->schema([
                        Select::make('kecamatan')
                            ->nullable()
                            ->searchable()
                            ->live()
                            ->native(false)
                            ->options(function (callable $get) {
                                $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                                if ( ! $kab) {
                                    return Kecamatan::where('kabupaten_code', setting(
                                        'app.kodekab',
                                        config('custom.default.kodekab'),
                                    ))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                        Select::make('kelurahan')
                            ->nullable()
                            ->options(function (callable $get) {
                                $kel = Kelurahan::query()
                                    ->when(auth()->user()->instansi_id, fn(Builder $query) => $query->where(
                                        'code',
                                        auth()->user()->instansi_id,
                                    ))
                                    ->where('kecamatan_code', $get('kecamatan'));

                                return $kel->clone()->pluck('name', 'code');
                            })
                            ->live()
                            ->native(false)
                            ->searchable()
//                            ->hidden(fn (callable $get) => ! $get('kecamatan'))
                            ->afterStateUpdated(function (callable $set, $state): void {
                                $village = Kelurahan::where('code', $state)->first();
                                if ($village) {
                                    $set('latitude', $village['latitude']);
                                    $set('longitude', $village['longitude']);
                                    $set('location', [
                                        'lat' => (float) $village['latitude'],
                                        'lng' => (float) $village['longitude'],
                                    ]);
                                }

                            }),
                    ])
                        ->columns(2),
                ])
                    ->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            \Filament\Infolists\Components\Section::make('INFORMASI PENERIMA MANFAAT')
                ->icon('heroicon-o-user')
                ->schema([
                    TextEntry::make('no_nik')
                        ->label('NIK PENERIMA')
                        ->icon('heroicon-o-identification')
                        ->weight(FontWeight::SemiBold)
                        ->color('primary'),
                    TextEntry::make('nama_penerima')
                        ->label('NAMA PENERIMA')
                        ->icon('heroicon-o-user-circle')
                        ->weight(FontWeight::SemiBold)
                        ->color('primary'),
                    TextEntry::make('prov.name')
                        ->label('PROVINSI')
                        ->icon('heroicon-o-map-pin')
                        ->weight(FontWeight::SemiBold)
                        ->color('primary'),
                    TextEntry::make('kab.name')
                        ->label('KABUPATEN')
                        ->icon('heroicon-o-map')
                        ->weight(FontWeight::SemiBold)
                        ->color('primary'),
                    TextEntry::make('kec.name')
                        ->label('KECAMATAN')
                        ->icon('heroicon-o-map')
                        ->weight(FontWeight::SemiBold)
                        ->color('primary'),
                    TextEntry::make('kel.name')
                        ->label('KELURAHAN')
                        ->icon('heroicon-o-map')
                        ->weight(FontWeight::SemiBold)
                        ->color('primary'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->poll()
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada bantuan BPNT')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->disabled(fn(): bool => cek_batas_input(setting('app.batas_tgl_input')))
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('no_nik')
                    ->label('N I K')
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($state) => Str::mask($state, '*', 2, 12))
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_penerima')
                    ->label('Nama Penerima')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('prov.name')
                    ->label('Provinsi')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('kab.name')
                    ->label('Kabupaten')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
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
            ])
            ->filters([
                Tables\Filters\Filter::make('keckel')
                    ->indicator('Wilayah')
                    ->form([
                        Select::make('kecamatan')
                            ->options(function () {
                                return Kecamatan::query()
                                    ->where('kabupaten_code', setting('app.kodekab'))
                                    ->pluck('name', 'code');
                            })
                            ->live()
                            ->searchable()
                            ->native(false),
                        Select::make('kelurahan')
                            ->options(function (Get $get) {
                                return Kelurahan::query()
                                    ->whereIn('kecamatan_code', config('custom.kode_kecamatan'))
                                    ->where('kecamatan_code', $get('kecamatan'))
                                    ->pluck('name', 'code');
                            })
                            ->searchable()
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['kecamatan'],
                                fn(Builder $query, $data): Builder => $query->where('kecamatan', $data),
                            )
                            ->when(
                                $data['kelurahan'],
                                fn(Builder $query, $data): Builder => $query->where('kelurahan', $data),
                            );
                    }),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->deferFilters()
            ->deselectAllRecordsWhenFiltered()
            ->hiddenFilterIndicators()
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBantuanBpnts::route('/'),
            'create' => Pages\CreateBantuanBpnt::route('/create'),
            'view' => Pages\ViewBantuanBpnt::route('/{record}'),
            'edit' => Pages\EditBantuanBpnt::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $admin = Helpers::getAdminRoles();
        $sadmin = ['super_admin'];
        $sa = array_merge($sadmin, $admin);

        if (auth()->user()->hasRole($sa)) {
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
