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
use App\Rules\NikValidationRule;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use UnitEnum;

class BantuanBpntResource extends Resource
{
    protected static ?string $model = BantuanBpnt::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $slug = 'program-bpnt';
    protected static ?string $label = 'Program BPNT';
    protected static ?string $pluralLabel = 'Program BPNT';
    protected static ?string $navigationLabel = 'Program BPNT';
    protected static string|UnitEnum|null $navigationGroup = 'Program Bantuan';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'nama_penerima';

    public static function getGloballySearchableAttributes(): array
    {
        return ['nik', 'no_kk', 'nama_penerima'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'NIK' => $record->nik,
            'Kecamatan' => $record->kec?->name,
            'Kelurahan' => $record->kel?->name,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['kec', 'kel']);
    }

    public static function getWidgets(): array
    {
        return [
            BantuanBpntOverview::class,
        ];
    }


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Data Penerima Manfaat BPNT')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('nik')
                            ->label('No. Induk Kependudukan (NIK)')
                            ->required()
                            ->live(debounce: 500)
                            ->afterStateUpdated(function (Page $livewire, TextInput $component): void {
                                $livewire->validateOnly($component->getStatePath());
                            })
                            ->rule(new NikValidationRule(checkAllPrograms: true, ignoreModel: \App\Models\BantuanBpnt::class)),
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
                                ->options(fn(callable $get) => get_kecamatan_options($get('kabupaten')))
                                ->default(fn() => auth()->user()->instansi?->kecamatan_code)
                                ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                            Select::make('kelurahan')
                                ->nullable()
                                ->options(fn(callable $get) => get_kelurahan_options($get('kecamatan')))
                                ->default(fn() => auth()->user()->instansi_id)
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

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('INFORMASI PENERIMA MANFAAT')
                ->icon('heroicon-o-user')
                ->schema([
                    TextEntry::make('nik')
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
                Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->disabled(fn(): bool => cek_batas_input(setting('app.batas_tgl_input_bpnt')))
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nik')
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
                            ->options(get_kecamatan_options())
                            ->live()
                            ->searchable()
                            ->native(false)
                            ->columnSpanFull(),
                        Select::make('kelurahan')
                            ->options(fn(callable $get) => get_kelurahan_options($get('kecamatan')))
                            ->searchable()
                            ->native(false)
                            ->columnSpanFull(),
                    ])
                    ->query(fn(Builder $query, array $data): Builder => $query
                        ->when(
                            $data['kecamatan'],
                            fn(Builder $query, $data): Builder => $query->where('kecamatan', $data),
                        )
                        ->when(
                            $data['kelurahan'],
                            fn(Builder $query, $data): Builder => $query->where('kelurahan', $data),
                        )),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->deferFilters()
            ->deselectAllRecordsWhenFiltered()
            ->hiddenFilterIndicators()
            ->recordActions([
                Actions\ActionGroup::make([
                    Actions\ViewAction::make(),
                    Actions\EditAction::make(),
                    Actions\DeleteAction::make(),
                    Actions\ForceDeleteAction::make(),
                    Actions\RestoreAction::make(),
                ]),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->after(fn(Collection $records) => activity()
                            ->log('Hapus masal ' . $records->count() . ' data bantuan BPNT')),
                    Actions\ForceDeleteBulkAction::make()
                        ->after(fn(Collection $records) => activity()
                            ->log('Hapus permanen masal ' . $records->count() . ' data bantuan BPNT')),
                    Actions\RestoreBulkAction::make()
                        ->after(fn(Collection $records) => activity()
                            ->log('Pemulihan masal ' . $records->count() . ' data bantuan BPNT')),
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
        return parent::getEloquentQuery()
            ->with(['prov', 'kab', 'kec', 'kel'])
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
