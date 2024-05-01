<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                Forms\Components\TextInput::make('nama_barang')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kuantitas')
                    ->numeric()
                    ->default(10),
                Forms\Components\TextInput::make('jumlah_bulan')
                    ->numeric()
                    ->default(3),
                Forms\Components\TextInput::make('satuan')
                    ->maxLength(255)
                    ->default('Kg'),
                Forms\Components\TextInput::make('harga_satuan')
                    ->numeric()
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        fn(Forms\Get $get, Forms\Set $set, $state) => $set('total_harga', $get('kuantitas') * $state)
                    )
                    ->default(0),
                Forms\Components\TextInput::make('total_harga')
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
            ->columns([
                Tables\Columns\TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kuantitas')
                    ->numeric(locale: 'id')
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_bulan')
                    ->label('Jumlah Bulan')
                    ->numeric(locale: 'id')
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('satuan')
                    ->alignCenter()
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga_satuan')
                    ->label('Harga Satuan')
                    ->alignLeft()
                    ->numeric(locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->alignLeft()
                    ->numeric(locale: 'id')
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
