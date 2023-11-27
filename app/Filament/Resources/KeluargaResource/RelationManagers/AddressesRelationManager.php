<?php

namespace App\Filament\Resources\KeluargaResource\RelationManagers;

use App\Forms\Components\AddressForm;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    protected static ?string $label = 'Alamat';

    protected static ?string $modelLabel = 'Alamat';
    protected static ?string $pluralLabel = 'Alamat';

    protected static ?string $recordTitleAttribute = 'full_address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                AddressForm::make('address')
                    ->columnSpan('full'),
//                Forms\Components\Textarea::make('alamat')
//                    ->required()
//                    ->maxLength(65535)
//                    ->columnSpanFull(),
//                Forms\Components\TextInput::make('no_rt')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('no_rw')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('provinsi')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('kabupaten')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('kecamatan')
//                    ->required()
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('kelurahan')
//                    ->required()
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('dusun')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('kodepos')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('location')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('latitude')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('longitude')
//                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('alamat')
            ->columns([
                Tables\Columns\TextColumn::make('full_address')
                    ->label('Alamat')
                    ->searchable(),
//                Tables\Columns\TextColumn::make('no_rt')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('no_rw')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('provinsi')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('kabupaten')
//                    ->searchable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->searchable(),
//                Tables\Columns\TextColumn::make('dusun')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('kodepos')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('location')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('latitude')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('longitude')
//                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
