<?php

//declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\StatusAdminEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Models\Kelurahan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Select::make('roles_id')
                    ->relationship('roles', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('instansi_id')
                    ->nullable()
                    ->unique(ignoreRecord: true)
                    ->options(
                        Kelurahan::query()
                            ->whereIn(
                                'kecamatan_code',
                                config('custom.kode_kecamatan'),
                            )
                            ->pluck('name', 'code'),
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
                Forms\Components\ToggleButtons::make('is_admin')
                    ->enum(StatusAdminEnum::class)
                    ->options(StatusAdminEnum::class)
                    ->inline(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->placeholder('No Name.')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->placeholder('No Email.')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->placeholder('No Roles.')
                    ->badge(),
                Tables\Columns\TextColumn::make('instansi_id')
                    ->placeholder('No Instansi.')
                    ->formatStateUsing(fn($state) => Kelurahan::find($state)?->name)
                    ->label('Instansi')
                    ->badge(),
                Tables\Columns\TextColumn::make('is_admin')
                    ->badge(),

            ])
            ->filters([

            ])
            ->toggleColumnsTriggerAction(
                fn(Action $action) => $action
                    ->iconButton()
//                    ->tooltip('Tampilkan / Sembunyikan Kolom Tabel')
                    ->label('Tampilkan / Sembunyikan Kolom Tabel'),
            )
            ->actions([
                Tables\Actions\EditAction::make()
                    ->closeModalByClickingAway(false),
                Tables\Actions\DeleteAction::make()
                    ->closeModalByClickingAway(false)
                    ->visible(1 === auth()->user()->id),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->icon('Hapus Terpilih')
                        ->icon('heroicon-o-user-minus')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(function ($items): void {
                                $items->delete();
                                $items->syncRoles();
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('forceDelete')
                        ->icon('Paksa Hapus Terpilih')
                        ->icon('heroicon-o-user-minus')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(function ($items): void {
                                $items->forceDelete();
                                $items->syncRoles();
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn(Model $record): bool => (StatusAdminEnum::SUPER_ADMIN !== $record->is_admin),
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (1 === auth()->user()->id) {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        }

        return parent::getEloquentQuery()
            ->whereNot('id', 1)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    //    public static function getNavigationBadge(): ?string
    //    {
    //        return static::$model::query()->count();
    //    }
}
