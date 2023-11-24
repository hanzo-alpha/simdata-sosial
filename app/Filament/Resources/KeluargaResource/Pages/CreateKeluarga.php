<?php

namespace App\Filament\Resources\KeluargaResource\Pages;

use App\Filament\Resources\KeluargaResource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;

class CreateKeluarga extends CreateRecord
{
    use HasWizard;
    protected static string $resource = KeluargaResource::class;

    protected function afterCreate(): void
    {
        $keluarga = $this->record;

        Notification::make()
            ->title('Keluarga Baru')
            ->icon('heroicon-o-shopping-bag')
            ->body("**{$keluarga->nama_lengkap} berhasil dibuat **")
            ->actions([
                Action::make('Lihat')
                    ->url(KeluargaResource::getUrl('edit', ['record' => $keluarga])),
            ])
            ->sendToDatabase(auth()->user());
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['alamat_id'] = 1;
        $data['dtks_id'] = \Str::uuid()->toString();
        return $data;
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Data Keluarga')
                ->schema([
                    Section::make()->schema(KeluargaResource::getFormSchema())->columns(),
                ]),

            Step::make('Alamat Keluarga')
                ->schema([
                    Section::make()->schema(KeluargaResource::getFormSchema('alamat')),
                ]),

            Step::make('Data Lainnya')
                ->schema([
                    Section::make()->schema(KeluargaResource::getFormSchema('lainnya'))
                        ->columns(),
                ]),

            Step::make('Unggah Data')
                ->schema([
                    Section::make()->schema(KeluargaResource::getFormSchema('upload')),
                ])
        ];
    }
}
