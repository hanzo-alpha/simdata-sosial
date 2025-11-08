<?php

declare(strict_types=1);

namespace App\Filament\Resources\DetailBantuanPpksResource\Pages;

use App\Filament\Resources\DetailBantuanPpksResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDetailBantuanPpks extends ManageRecords
{
    protected static string $resource = DetailBantuanPpksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
