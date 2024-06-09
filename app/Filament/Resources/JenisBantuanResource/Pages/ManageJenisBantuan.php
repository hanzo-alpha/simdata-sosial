<?php

declare(strict_types=1);

namespace App\Filament\Resources\JenisBantuanResource\Pages;

use App\Filament\Resources\JenisBantuanResource;
use App\Traits\HasInputDateLimit;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

final class ManageJenisBantuan extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = JenisBantuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->disabled($this->enableInputLimitDate())
                ->icon('heroicon-o-plus')
                ->mutateFormDataUsing(function (array $data) {
                    $alias = Str::of($data['alias']);
                    $data['alias'] = $alias->upper();
                    $data['model_name'] = 'App\\Models\\' . convertNameBasedOnModelName($alias->ucfirst());
                    return $data;
                }),
        ];
    }
}
