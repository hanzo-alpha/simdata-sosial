<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanBpjsResource\Pages;
use App\Filament\Resources\BantuanBpjsResource\RelationManagers;
use App\Forms\Components\FamilyForm;
use App\Models\BantuanBpjs;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BantuanBpjsResource extends Resource
{
    protected static ?string $model = BantuanBpjs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    FamilyForm::make('familyable'),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('upload')
                        ->schema([
                            Forms\Components\TextInput::make('attachments'),
                            Forms\Components\TextInput::make('bukti_foto'),
                            Forms\Components\Toggle::make('status_bpjs'),
                        ])
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('family.nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('family.nik')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status_bpjs')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListBantuanBpjs::route('/'),
            'create' => Pages\CreateBantuanBpjs::route('/create'),
            'view' => Pages\ViewBantuanBpjs::route('/{record}'),
            'edit' => Pages\EditBantuanBpjs::route('/{record}/edit'),
        ];
    }
}
