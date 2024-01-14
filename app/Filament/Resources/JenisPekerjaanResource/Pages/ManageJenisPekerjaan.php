<?php

declare(strict_types=1);

namespace App\Filament\Resources\JenisPekerjaanResource\Pages;

use App\Filament\Resources\JenisPekerjaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

final class ManageJenisPekerjaan extends ManageRecords
{
    protected static string $resource = JenisPekerjaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
