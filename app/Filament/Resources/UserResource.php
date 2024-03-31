<?php

//declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Kelurahan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $slug = 'pengguna';

    protected static ?string $label = 'Pengguna';

    protected static ?string $pluralLabel = 'Pengguna';

    protected static ?string $navigationGroup = 'Pengaturan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('roles_id')
                    ->relationship('roles', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('instansi')
                    ->required()
                    ->unique()
                    ->options(
                        Kelurahan::whereIn(
                            'kecamatan_code',
                            ['731201', '731202', '731203', '731204', '731205', '731206', '731207', '731208']
                        )
                            ->pluck('name', 'code')
                    )
                    ->searchable()
                    ->label('Instansi')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set): void {
                        $namaKel = Kelurahan::find($state)?->name;
                        if (blank($namaKel)) {
                            $set('slug', null);
                            $set('nama_instansi', null);
                        }

                        $set('slug', Str::slug($namaKel));
                        $set('nama_instansi', $namaKel);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge(),
                Tables\Columns\TextColumn::make('instansi_id')
                    ->formatStateUsing(fn($state) => Kelurahan::find($state)?->name)
                    ->label('Instansi')
                    ->badge()
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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }

    //    public static function getNavigationBadge(): ?string
    //    {
    //        return static::$model::query()->count();
    //    }
}
