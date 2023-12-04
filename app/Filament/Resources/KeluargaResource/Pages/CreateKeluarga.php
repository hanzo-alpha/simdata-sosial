<?php

namespace App\Filament\Resources\KeluargaResource\Pages;

use App\Enums\StatusKondisiRumahEnum;
use App\Enums\StatusRumahEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Filament\Resources\KeluargaResource;
use App\Models\BantuanBpjs;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
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

        if ($keluarga->jenis_bantuan_id === 3) {
            BantuanBpjs::create([
                'keluarga_id' => $keluarga->id,
                'dkts_id' => $keluarga->dtks_id,
                'bukti_foto' => $keluarga->unggah_foto,
                'dokumen' => $keluarga->unggah_dokumen,
                'status_bpjs' => 1,
            ]);
        }

        if ($keluarga->jenis_bantuan_id === 4) {
            BantuanPpks::create([
                'keluarga_id' => $keluarga->id,
                'jenis_pelayanan_id' => $keluarga->jenis_pelayanan_id,
                'jenis_ppks' => $keluarga->jenis_pelayanan_id,
                'jenis_bantuan_id' => $keluarga->jenis_bantuan_id,
                'penghasilan_rata_rata' => 0,
                'status_rumah_tinggal' => StatusRumahEnum::MILIK_SENDIRI,
                'status_kondisi_rumah' => StatusKondisiRumahEnum::SEDANG,
                'status_bantuan' => 1,
            ]);
        }

        if ($keluarga->jenis_bantuan_id === 5) {
            BantuanRastra::create([
                'keluarga_id' => $keluarga->id,
                'dkts_id' => $keluarga->dtks_id,
                'nik_penerima' => $keluarga->nik,
                'bukti_foto' => $keluarga->unggah_foto,
                'dokumen' => $keluarga->unggah_dokumen,
                'location' => $keluarga->location,
                'status_rastra' => 1,
            ]);
        }

        Notification::make()
            ->title('Keluarga Baru')
            ->icon('heroicon-o-user')
            ->body("**{$keluarga->nama_lengkap} berhasil dibuat **")
            ->actions([
                Action::make('Lihat')
                    ->url(KeluargaResource::getUrl('edit', ['record' => $keluarga])),
            ])
            ->sendToDatabase(auth()->user());
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['dtks_id'] = \Str::uuid()->toString();
        $data['status_verifikasi'] = !auth()->user()?->role('super_admin') ? StatusVerifikasiEnum::UNVERIFIED : $data['status_verifikasi'];
        return $data;
    }

    public function hasSkippableSteps(): bool
    {
        return true;
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Penerima Manfaat')
                ->schema([
                    Section::make()->schema(KeluargaResource::getFormSchema())->columns(),
                ]),

            Step::make('Alamat Penerima')
                ->schema([
                    Section::make()->schema(KeluargaResource::getFormSchema('alamat')),
                ]),

            Step::make('Data Pendukung')
                ->schema([
                    Section::make()->schema(KeluargaResource::getFormSchema('lainnya'))->columns(),
                ]),

            Step::make('Verifikasi')
                ->schema([
                    Section::make()->schema(KeluargaResource::getFormSchema('upload')),
                ])
        ];
    }
}
