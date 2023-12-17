<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataPesertaJamkesdaResource\Pages;
use App\Filament\Resources\DataPesertaJamkesdaResource\RelationManagers;
use App\Models\DataPesertaJamkesda;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DataPesertaJamkesdaResource extends Resource
{
    protected static ?string $model = DataPesertaJamkesda::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'peserta-jamkesda';
    protected static ?string $label = 'Peserta Jamkesda';
    protected static ?string $pluralLabel = 'Peserta Jamkesda';
    protected static ?string $navigationLabel = 'Peserta Jamkesda';
    protected static ?string $navigationGroup = 'Bantuan';
    protected static ?int $navigationSort = 8;

//    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                        'text/csv'
                    ])
                    ->hiddenOn(['edit', 'view']),

                Forms\Components\TextInput::make('nomor_kartu')
                    ->required()
                    ->maxLength(255)
                    ->visibleOn(['edit', 'view']),
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->maxLength(255)
                    ->visibleOn(['edit', 'view']),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->maxLength(255)
                    ->visibleOn(['edit', 'view']),
                Forms\Components\TextInput::make('alamat')
                    ->maxLength(255)
                    ->visibleOn(['edit', 'view']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_kartu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
            ])
            ->filters([

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
            'index' => Pages\ManageDataPesertaJamkesda::route('/'),
        ];
    }
}
