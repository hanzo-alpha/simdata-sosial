<?php

declare(strict_types=1);

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use App\Models\Barang;
use App\Models\Kelurahan;
use App\Supports\Helpers;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Collection;

class ManageBarangs extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = BarangResource::class;

    protected function generateItem(array $data): void
    {
        $query = Kelurahan::query()->whereIn('kecamatan_code', config('custom.kode_kecamatan'));
        $query->chunkById(20, function (Collection $instansi) use ($data): void {

            $instansi->each(function ($item) use ($data) {
                $arr = [
                    'jenis_bantuan_id' => $data['jenis_bantuan'],
                    'kode_barang' => Helpers::generateKodeBarang(),
                    'kode_kelurahan' => $item->code,
                    'nama_barang' => $data['nama_bantuan'],
                    'kuantitas' => $data['kuantitas'],
                    'jumlah_kpm' => 0,
                    'jumlah_bulan' => $data['jumlah_bulan'],
                    'satuan' => $data['satuan'],
                    'harga_satuan' => $data['harga_satuan'],
                    'total_harga' => $data['harga_satuan'] * $data['kuantitas'],
                ];

                return Barang::updateOrCreate($arr, [
                    'jenis_bantuan_id' => $data['jenis_bantuan'],
                    'kode_kelurahan' => $item->code,
                ]);
            });
        }, column: 'code');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generate item bantuan')
                ->label('Generate Item Bantuan Semua Kelurahan')
                ->color('secondary')
                ->form([
                    Section::make()->schema([
                        Select::make('jenis_bantuan')
                            ->relationship('jenisBantuan', 'alias')
                            ->native(false)
                            ->searchable(true)
                            ->preload(),
                        TextInput::make('nama_bantuan')
                            ->label('Nama Bantuan')
                            ->required(),
                        TextInput::make('kuantitas')
                            ->label('Kuantitas')
                            ->numeric()
                            ->default(1000),
                        TextInput::make('jumlah_bulan')
                            ->label('Jumlah Bulan')
                            ->numeric()
                            ->default(3),
                        TextInput::make('satuan')
                            ->label('Satuan')
                            ->default('Kg'),
                        TextInput::make('harga_satuan')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->default(13500),
                    ])->columns(1)->inlineLabel(),
                ])
                ->action(fn(array $data) => $this->generateItem($data))
                ->after(function (): void {
                    Notification::make('Berhasil')
                        ->title('Buat Item Bantuan')
                        ->body('Berhasil membuat item bantuan')
                        ->success()
                        ->send();
                })
                ->visible(fn() => auth()->user()->hasRole(superadmin_admin_roles()))
                ->icon('heroicon-o-plus'),
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->mutateFormDataUsing(function (array $data) {
                    $data['kode_barang'] ??= Helpers::generateKodeBarang();
                    return $data;
                })
                ->closeModalByClickingAway(false),
        ];
    }
}
