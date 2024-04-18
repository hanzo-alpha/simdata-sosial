<?php

namespace App\Filament\Resources\BeritaAcaraResource\Pages;

use App\Filament\Resources\BeritaAcaraResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageBeritaAcaras extends ManageRecords
{
    protected static string $resource = BeritaAcaraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
//                ->modalWidth(MaxWidth::SevenExtraLarge)
                ->successRedirectUrl(fn(Model $record) => route('pdf.ba', [
                    'id' => $record, 'm' => $this->getModel()
                ])),
        ];
    }
}
