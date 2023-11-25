<?php

namespace App\Filament\Resources\KeluargaResource\Pages;

use App\Filament\Resources\KeluargaResource;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use EightyNine\Approvals\Traits\HasApprovalHeaderActions;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditKeluarga extends EditRecord
{
    use InteractsWithMaps, HasApprovalHeaderActions;

    protected static string $resource = KeluargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getOnCompletionAction(): Action
    {
        return Action::make('Done')
            ->color('success');
    }
}
