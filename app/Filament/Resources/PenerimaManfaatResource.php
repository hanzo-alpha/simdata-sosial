<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenerimaManfaatResource\Pages;
use App\Filament\Resources\PenerimaManfaatResource\RelationManagers;
use App\Models\Bantuan;
use App\Models\Family;
use App\Models\Image;
use App\Models\PenerimaManfaat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PenerimaManfaatResource extends Resource
{
    protected static ?string $model = PenerimaManfaat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MorphToSelect::make('familyable')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(Family::class)
                            ->titleAttribute('nama_lengkap'),
                        Forms\Components\MorphToSelect\Type::make(Bantuan::class)
                            ->titleAttribute('nama_bantuan'),
                        Forms\Components\MorphToSelect\Type::make(Image::class)
                            ->titleAttribute('nama_image')
                    ]),
//                Forms\Components\TextInput::make('familyable_type')
//                    ->required()
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('familyable_id')
//                    ->required()
//                    ->numeric(),
//                Forms\Components\TextInput::make('bantuanable_type')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('bantuanable_id')
//                    ->numeric(),
//                Forms\Components\TextInput::make('imageable_type')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('imageable_id')
//                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('familyable_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('familyable_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan.nama_bantuan')
                    ->searchable(),
//                Tables\Columns\TextColumn::make('bantuanable_id')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('imageable_type')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('imageable_id')
//                    ->numeric()
//                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPenerimaManfaats::route('/'),
            'create' => Pages\CreatePenerimaManfaat::route('/create'),
            'view' => Pages\ViewPenerimaManfaat::route('/{record}'),
            'edit' => Pages\EditPenerimaManfaat::route('/{record}/edit'),
        ];
    }
}
