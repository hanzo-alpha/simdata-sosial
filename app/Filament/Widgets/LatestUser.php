<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestUser extends BaseWidget
{
    use HasWidgetShield;

    protected static ?string $heading = 'Pengguna Terakhir';
    protected static ?int $sort = 10;
    protected static bool $isDiscovered = false;

    public function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->poll()
            ->emptyStateHeading('Tidak ada data ditemukan')
            ->query(
                User::query()
                    ->whereNot('is_admin', 1)
                    ->limit(10)
                    ->orderByDesc('created_at'),
            )
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('instansi.name'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat Pada')
                    ->date('d/m/Y H:i'),
            ]);
    }
}
