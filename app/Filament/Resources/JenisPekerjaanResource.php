<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisPekerjaanResource\Pages;
use App\Filament\Resources\JenisPekerjaanResource\RelationManagers;
use App\Models\JenisPekerjaan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JenisPekerjaanResource extends Resource
{
    protected static ?string $model = JenisPekerjaan::class;

    protected static ?string $slug = 'jenis-pekerjaan';
    protected static ?string $label = 'Jenis Pekerjaan';
    protected static ?string $pluralLabel = 'Jenis Pekerjaan';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pekerjaan')
                    ->required()
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_pekerjaan')
            ])
            ->filters([
                //
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
            'index' => Pages\ManageJenisPekerjaans::route('/'),
        ];
    }
}
