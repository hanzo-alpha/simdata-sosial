<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanPkhBpntResource\Pages;
use App\Filament\Resources\BantuanPkhBpntResource\RelationManagers;
use App\Models\BantuanPkhBpnt;
use App\Models\Kecamatan;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BantuanPkhBpntResource extends Resource
{
    protected static ?string $model = BantuanPkhBpnt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'bantuan-pkh-bpnt';
    protected static ?string $label = 'Bantuan PKH BPNT';
    protected static ?string $pluralLabel = 'Bantuan PKH BPNT';
    protected static ?string $navigationLabel = 'Bantuan PKH BPNT';
    protected static ?string $navigationGroup = 'Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        Select::make('kecamatan')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(function (callable $get) {
//                            $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                                $kab = Kecamatan::query()->where('kabupaten_code',
                                    config('custom.default.kodekab'));
                                if (!$kab) {
                                    return Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

//                            Select::make('kelurahan')
//                                ->nullable()
//                                ->options(function (callable $get) {
//                                    $kel = Kelurahan::query()->where('kecamatan_code', $get('kecamatan'));
//                                    if (!$kel) {
//                                        return Kelurahan::where('kecamatan_code', '731211')
//                                            ->pluck('name', 'code');
//                                    }
//
//                                    return $kel->pluck('name', 'code');
//                                })
//                                ->reactive()
//                                ->searchable()
////                            ->hidden(fn (callable $get) => ! $get('kecamatan'))
//                                ->afterStateUpdated(function (callable $set, $state) {
//                                    $village = Kelurahan::where('code', $state)->first();
//                                    if ($village) {
//                                        $set('latitude', $village['latitude']);
//                                        $set('longitude', $village['longitude']);
//                                        $set('location', [
//                                            'lat' => (float) $village['latitude'],
//                                            'lng' => (float) $village['longitude'],
//                                        ]);
//                                    }
//
//                                }),
                        FileUpload::make('upload')
                            ->preserveFilenames()
                            ->previewable(false)
                            ->directory('import')
                            ->maxSize(5120)
                            ->inlineLabel()
                            ->reorderable()
                            ->appendFiles()
                            ->storeFiles(false)
                            ->acceptedFileTypes([
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'
                            ])
                    ])->inlineLabel()->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dtks_id')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nokk')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_ktp')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_penerima')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_wilayah')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahap')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bansos')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_bantuan.nama_bantuan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
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
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rt')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rw')
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
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gelombang')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_pkhbpnt')
                    ->badge()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBantuanPkhBpnt::route('/'),
        ];
    }
}
