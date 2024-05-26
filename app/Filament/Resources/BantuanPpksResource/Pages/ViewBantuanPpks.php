<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPpksResource\Pages;

use App\Filament\Resources\BantuanPpksResource;
use App\Models\BantuanPpks;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewBantuanPpks extends ViewRecord
{
    protected static string $resource = BantuanPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cetak ba')
                ->label('Cetak Berita Acara')
                ->color('success')
                ->icon('heroicon-o-printer')
                ->url(fn($record) => route('ba.ppks', ['id' => $record, 'm' => BantuanPpks::class]), true),
            Actions\EditAction::make()
                ->icon('heroicon-o-pencil-square'),
        ];
    }
}
