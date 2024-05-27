<?php

declare(strict_types=1);

namespace App\Filament\Resources\PenyaluranBantuanRastraResource\Pages;

use App\Filament\Resources\PenyaluranBantuanRastraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

final class EditPenyaluranBantuanRastra extends EditRecord
{
    protected static string $resource = PenyaluranBantuanRastraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('Print Dokumentasi')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn(Model $record) => route('cetak-dokumentasi.rastra', ['id' => $record, 'm' => $this->getModel()]))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash'),
        ];
    }
}
