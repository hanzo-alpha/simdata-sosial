<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Models\Barang;
use App\Models\Kelurahan;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $slug = 'item-bantuan';
    protected static ?string $label = 'Item Bantuan Rastra';
    protected static ?string $pluralLabel = 'Item Bantuan Rastra';
    protected static ?string $navigationParentItem = 'Program Rastra';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kode_kelurahan')
                    ->required()
                    ->options(Kelurahan::query()
                        ->when(
                            auth()->user()->instansi_id,
                            fn(Builder $query) => $query->where(
                                'code',
                                auth()->user()->instansi_id,
                            ),
                        )
                        ->whereIn('kecamatan_code', config('custom.kode_kecamatan'))
                        ?->pluck('name', 'code'))
                    ->native(false)
                    ->searchable(),
                Forms\Components\TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->default('Beras Premium')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kuantitas')
                    ->numeric()
                    ->default(600),
                Forms\Components\TextInput::make('jumlah_bulan')
                    ->label('Jumlah Bulan')
                    ->numeric()
                    ->default(3),
                Forms\Components\TextInput::make('satuan')
                    ->maxLength(255)
                    ->default('Kg'),
                Forms\Components\TextInput::make('harga_satuan')
                    ->label('Harga Satuan')
                    ->numeric()
                    ->live(onBlur: true)
                    ->default(0)
                    ->afterStateUpdated(
                        fn(Forms\Get $get, Forms\Set $set, $state) => $set('total_harga', $get('kuantitas') * $state),
                    ),
                Forms\Components\TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->default(0),
                Forms\Components\Textarea::make('keterangan')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada barang')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Item Bantuan Rastra')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->formatStateUsing(fn($record) => $record->nama_barang . ' - ' . $record->jumlah_bulan . ' bulan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kuantitas')
                    ->formatStateUsing(fn($record) => $record->kuantitas . ' ' . $record->satuan)
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga_satuan')
                    ->label('Harga Satuan')
                    ->alignRight()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->alignRight()
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([

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
            'index' => Pages\ManageBarangs::route('/'),
        ];
    }
}
