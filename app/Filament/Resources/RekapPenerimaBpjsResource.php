<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\RekapPenerimaBpjsResource\Pages;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\RekapPenerimaBpjs;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RekapPenerimaBpjsResource extends Resource
{
    protected static ?string $model = RekapPenerimaBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'rekap-penerima-pbi';
    protected static ?string $label = 'Rekap Penerima BPJS';
    protected static ?string $pluralLabel = 'Rekap Penerima PBI APBD';
    protected static ?string $modelLabel = 'Rekap Penerima PBI APBD';
    protected static ?string $pluralModelLabel = 'Rekap Penerima PBI APBD';
    protected static ?string $navigationLabel = 'Rekap PBI';
    protected static ?string $navigationParentItem = 'Program BPJS';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        Select::make('provinsi')
                            ->required()
                            ->searchable()
                            ->live()
                            ->native(false)
                            ->options(Provinsi::pluck('name', 'code'))
                            ->default(setting('app.kodeprov', config('custom.default.kodeprov')))
                            ->afterStateUpdated(function (callable $set): void {
                                $set('kabupaten', null);
                                $set('kecamatan', null);
                                $set('kelurahan', null);
                            }),
                        Select::make('kabupaten')
                            ->required()
                            ->searchable()
                            ->live()
                            ->native(false)
                            ->options(function (Get $get) {
                                $kab = Kabupaten::query()->where('provinsi_code', $get('provinsi'));
                                if ( ! $kab) {
                                    return Kabupaten::where(
                                        'provinsi_code',
                                        setting('app.kodekab', config('custom.default.kodekab')),
                                    )
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->default(setting('app.kodekab', config('custom.default.kodekab')))
                            ->afterStateUpdated(function (callable $set): void {
                                $set('kecamatan', null);
                                $set('kelurahan', null);
                            }),
                        Select::make('kecamatan')
                            ->required()
                            ->searchable()
                            ->live()
                            ->native(false)
                            ->options(function (Get $get) {
                                $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                                if ( ! $kab) {
                                    return Kecamatan::where(
                                        'kabupaten_code',
                                        setting('app.kodekab', config('custom.default.kodekab')),
                                    )
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                        Select::make('kelurahan')
                            ->required()
                            ->native(false)
                            ->options(function (callable $get) {
                                return Kelurahan::query()->where(
                                    'kecamatan_code',
                                    $get('kecamatan'),
                                )?->pluck(
                                    'name',
                                    'code',
                                );
                            })
                            ->live()
                            ->searchable(),
                        Select::make('bulan')
                            ->options(list_bulan(short: true))
                            ->preload()
                            ->native(false)
                            ->lazy()
                            ->default(now()->month),
                        TextInput::make('jumlah')
                            ->numeric()
                            ->default(0),
                    ])->inlineLabel()->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('kecamatan')
            ->groups([
                Tables\Grouping\Group::make('kecamatan')
                    ->label('Kecamatan ')
                    ->titlePrefixedWithLabel()
                    ->getTitleFromRecordUsing(fn(RekapPenerimaBpjs $record) => ucfirst($record->kec->name)),
                Tables\Grouping\Group::make('bulan')
                    ->label('Bulan ')
                    ->titlePrefixedWithLabel()
                    ->getTitleFromRecordUsing(fn(RekapPenerimaBpjs $record) => bulan_to_string($record->bulan)),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('prov.name')
                    ->label('Provinsi')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kab.name')
                    ->label('Kabupaten')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('bulan')
                    ->label('Periode Bulan')
                    ->formatStateUsing(fn($record) => bulan_to_string($record->bulan))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah Penerima APBD')
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah Penerima APBD')
                    ->numeric()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->label('Total'),
                    ]),
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
                SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->options(list_bulan())
                    ->searchable(),
            ])
            ->actions([
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
            'index' => Pages\ManageRekapPenerimaBpjs::route('/'),
        ];
    }
}
