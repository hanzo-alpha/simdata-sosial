<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages\ManageActivities;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;
use UnitEnum;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-finger-print';
    protected static ?string $slug = 'audit-log';
    protected static ?string $label = 'Audit Log';
    protected static ?string $pluralLabel = 'Audit Log';
    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Detail Aktivitas')
                    ->schema([
                        Placeholder::make('log_name')
                            ->label('Log Name')
                            ->content(fn(Activity $record): string => $record->log_name),
                        Placeholder::make('event')
                            ->label('Event')
                            ->content(fn(Activity $record): string => $record->event ?? '-'),
                        Placeholder::make('description')
                            ->label('Deskripsi')
                            ->content(fn(Activity $record): string => $record->description),
                        Placeholder::make('created_at')
                            ->label('Waktu')
                            ->content(fn(Activity $record): string => $record->created_at->format('d M Y H:i:s')),
                    ])->columns(2),
                Section::make('Subjek & Pelaku')
                    ->schema([
                        Placeholder::make('subject_type')
                            ->label('Tipe Subjek')
                            ->content(fn(Activity $record): string => $record->subject_type ?? '-'),
                        Placeholder::make('subject_id')
                            ->label('ID Subjek')
                            ->content(fn(Activity $record): string => (string) ($record->subject_id ?? '-')),
                        Placeholder::make('causer_type')
                            ->label('Tipe Pelaku')
                            ->content(fn(Activity $record): string => $record->causer_type ?? '-'),
                        Placeholder::make('causer_id')
                            ->label('ID Pelaku')
                            ->content(fn(Activity $record): string => (string) ($record->causer_id ?? '-')),
                    ])->columns(2),
                Section::make('Data Perubahan')
                    ->schema([
                        KeyValue::make('properties')
                            ->label('Properti')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('log_name')
                    ->label('Log')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'default' => 'gray',
                        'auth' => 'info',
                        'danger' => 'danger',
                        default => 'primary',
                    })
                    ->sortable(),
                TextColumn::make('event')
                    ->label('Aksi')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('subject_type')
                    ->label('Modul')
                    ->formatStateUsing(fn(string $state): string => str($state)->afterLast('\\')->snake()->replace('_', ' ')->title()->toString())
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('causer.name')
                    ->label('Oleh')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d/m/y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('log_name')
                    ->label('Nama Log')
                    ->options(Activity::distinct()->pluck('log_name', 'log_name')->toArray()),
                SelectFilter::make('event')
                    ->label('Aksi')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                        'restored' => 'Restored',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageActivities::route('/'),
        ];
    }
}
