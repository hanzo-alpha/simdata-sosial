<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanBpntResource\Pages;
use App\Filament\Resources\BantuanBpntResource\RelationManagers;
use App\Models\BantuanBpnt;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class BantuanBpntResource extends Resource
{
    protected static ?string $model = BantuanBpnt::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $slug = 'bantuan-bpnt';
    protected static ?string $label = 'Bantuan BPNT';
    protected static ?string $pluralLabel = 'Bantuan BPNT';
    protected static ?string $navigationLabel = 'Bantuan BPNT';
    protected static ?string $navigationGroup = 'Bantuan';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Pribadi')->schema([
                    TextInput::make('dtks_id'),
                    TextInput::make('nokk'),
                    TextInput::make('nik_ktp'),
                    TextInput::make('nama_penerima'),
                ])
                    ->visibleOn(['edit', 'view'])
                    ->columns(2),

                Section::make('Data Bantuan')->schema([
                    TextInput::make('tahap'),
                    TextInput::make('bansos'),
                    TextInput::make('bank'),
                    TextInput::make('nominal'),
                    TextInput::make('dir'),
                    TextInput::make('gelombang'),
                ])
                    ->visibleOn(['edit', 'view'])
                    ->columns(2),

                Section::make('Data Alamat')->schema([
                    TextInput::make('alamat')->columnSpanFull(),
                    Grid::make()->schema([
                        Select::make('provinsi')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(Provinsi::pluck('name', 'code'))
                            ->afterStateUpdated(fn(callable $set) => $set('kabupaten', null)),

                        Select::make('kabupaten')
                            ->nullable()
                            ->options(function (callable $get) {
                                $kab = Kabupaten::query()->where('provinsi_code', $get('provinsi'));
                                if (!$kab) {
                                    return Kabupaten::where('code', config('custom.default.kodekab'))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->reactive()
                            ->searchable()
//                            ->hidden(fn (callable $get) => ! $get('kecamatan'))
                            ->afterStateUpdated(fn(callable $set) => $set('kecamatan', null)),
                    ])->columns(2),

                    Grid::make()->schema([
                        Select::make('kecamatan')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(function (callable $get) {
                                $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                                if (!$kab) {
                                    return Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                        Select::make('kelurahan')
                            ->nullable()
                            ->options(function (callable $get) {
                                $kel = Kelurahan::query()->where('kecamatan_code', $get('kecamatan'));
                                if (!$kel) {
                                    return Kelurahan::where('kecamatan_code', '731211')
                                        ->pluck('name', 'code');
                                }

                                return $kel->pluck('name', 'code');
                            })
                            ->reactive()
                            ->searchable()
//                            ->hidden(fn (callable $get) => ! $get('kecamatan'))
                            ->afterStateUpdated(function (callable $set, $state) {
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
                    ])->columns(2),

                    Grid::make()->schema([
                        TextInput::make('dusun'),
                        TextInput::make('no_rt'),
                        TextInput::make('no_rw'),
                    ])->columns(3),
                ])
                    ->visibleOn(['edit', 'view'])
                    ->columns(2)

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->recordClasses(fn(Model $record) => match ($record->status_bpnt) {
                'draft' => 'opacity-30',
                'reviewing' => 'border-s-2 border-orange-600 dark:border-orange-300',
                'PKH' => 'border-s-2 border-green-600 dark:border-green-300',
                default => null,
            })
            ->groups([
                Tables\Grouping\Group::make('kec.name')
                    ->label('Kecamatan')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
                Tables\Grouping\Group::make('kel.name')
                    ->label('Kelurahan')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false)
            ])
            ->defaultGroup('kec.name')
            ->groupRecordsTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('Kelompokkan Data'),
            )
            ->groupingSettingsInDropdownOnDesktop()
//            ->groupingSettingsHidden()
//            ->paginated([10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(25)
            ->columns([
                Tables\Columns\TextColumn::make('nama_penerima')
                    ->label('Nama Penerima')
                    ->sortable()
                    ->description(fn($record) => $record->dtks_id)
                    ->searchable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->label('No. KK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_ktp')
                    ->label('N I K')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_wilayah')
                    ->label('Kode Wilayah')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahap')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bansos')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_bantuan.nama_bantuan')
                    ->label('Bantuan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nominal')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->sortable()
                    ->toggleable()
                    ->description(fn($record) => 'Kec. ' . $record->kec->name . ' | Kel. ' . $record->kel->name)
//                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('prov.name')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kab.name')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rt')
                    ->label('No. RT')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rw')
                    ->label('No. RW')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('dusun')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('dir')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable()
//                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gelombang')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable()
//                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_bpnt')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                DateRangeFilter::make('created_at')
                    ->label('Rentang Tanggal'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBantuanBpnt::route('/'),
            'create' => Pages\CreateBantuanBpnt::route('/create'),
            'view' => Pages\ViewBantuanBpnt::route('/{record}'),
            'edit' => Pages\EditBantuanBpnt::route('/{record}/edit'),
        ];
    }
}
