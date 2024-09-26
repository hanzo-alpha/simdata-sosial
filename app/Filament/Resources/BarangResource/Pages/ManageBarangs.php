<?php

declare(strict_types=1);

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use App\Models\Barang;
use App\Models\Kelurahan;
use App\Supports\Helpers;
use App\Traits\HasInputDateLimit;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Collection;

class ManageBarangs extends ManageRecords
{
    use HasInputDateLimit;

    protected static string $resource = BarangResource::class;

    protected function generateItem(): void
    {
        $query = Kelurahan::query()->whereIn('kecamatan_code', config('custom.kode_kecamatan'));
        $query->chunkById(20, function (Collection $instansi): void {
            $instansi->each(fn($item): Barang => Barang::updateOrCreate([
                'kode_barang' => Helpers::generateKodeBarang(),
                'kode_kelurahan' => $item->code,
                'nama_barang' => 'Beras Premium',
                'kuantitas' => 600,
                'jumlah_kpm' => 0,
                'jumlah_bulan' => 3,
                'satuan' => 'Kg',
                'harga_satuan' => 12000,
                'total_harga' => 12000 * 600,
            ], [
                'kode_barang' => Helpers::generateKodeBarang(),
                'kode_kelurahan' => $item->code,
                'nama_barang' => 'Beras Premium',
                'kuantitas' => 600,
                'jumlah_kpm' => 0,
                'jumlah_bulan' => 3,
                'satuan' => 'Kg',
                'harga_satuan' => 12000,
                'total_harga' => 12000 * 600,
            ]));
        }, column: 'code');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generate item bantuan')
                ->label('Generate Item Bantuan Per Kelurahan')
                ->color('warning')
                ->action(fn() => $this->generateItem())
                ->after(function (): void {
                    Notification::make('Berhasil')
                        ->title('Buat Item Bantuan')
                        ->body('Berhasil membuat item bantuan')
                        ->success()
                        ->send();
                })
                ->visible(fn() => auth()->user()->hasRole(superadmin_admin_roles()))
                ->icon('heroicon-o-document-duplicate'),
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
