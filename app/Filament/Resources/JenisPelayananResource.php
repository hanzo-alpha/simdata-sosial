<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisPelayananResource\Pages;
use App\Filament\Resources\JenisPelayananResource\RelationManagers;
use App\Models\JenisPelayanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Support\Str;

class JenisPelayananResource extends Resource
{
    protected static ?string $model = JenisPelayanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';
    protected static ?string $slug = 'jenis-pelayanan';
    protected static ?string $label = 'Jenis Pelayanan';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $pluralLabel = 'Jenis Pelayanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\TextInput::make('nama_ppks')
                            ->label('Nama PPKS')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('alias')
                            ->nullable()
                            ->maxLength(255),
                    ])
                ]),

                Forms\Components\Group::make()->schema([
                    \Awcodes\FilamentTableRepeater\Components\TableRepeater::make('kriteria_pelayanan')
                        ->relationship('kriteria_pelayanan')
                        ->schema([
                            Forms\Components\TextInput::make('nama_kriteria')
                                ->required()
                                ->hiddenLabel()
                        ])
                        ->defaultItems(1)
//                    TableRepeater::make('kriteria_pelayanan')
//                        ->relationship('kriteria_pelayanan')
//                        ->defaultItems(1)
//                        ->columnSpan('full')
//                        ->schema([
//                            Forms\Components\TextInput::make('nama_kriteria')
//                                ->label('Kriteria')
//                        ])
//                        ->hiddenLabel()
                ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_ppks')
                    ->label('Nama PPKS')
                    ->description(fn($record) => Str::words($record->deskripsi, 9))
                    ->weight(FontWeight::SemiBold)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kriteria_pelayanan.nama_kriteria')
                    ->label('Kriteria')
                    ->badge()->wrap()
                    ->color('success')
                    ->size('xs'),
                Tables\Columns\TextColumn::make('alias')
                    ->badge()
                    ->color('warning')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ManageJenisPelayanans::route('/'),
        ];
    }
}
