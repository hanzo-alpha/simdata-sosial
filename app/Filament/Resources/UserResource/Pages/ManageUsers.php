<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\StatusAdminEnum;
use App\Filament\Resources\UserResource;
use App\Models\JenisBantuan;
use App\Models\Kelurahan;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Hash;
use Str;

final class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function generateOperatorUser(): void
    {
        $instansi = Kelurahan::whereIn('kecamatan_code', config('custom.kode_kecamatan'))->get();

        $instansi->each(function ($item): void {
            $createUser = User::updateOrCreate([
                'name' => Str::ucfirst($item->name),
                'email' => Str::lower($item->name) . '@reno.soppeng.go.id',
                'instansi_id' => $item->code,
                'is_admin' => StatusAdminEnum::OPERATOR,
            ], [
                'name' => Str::ucfirst($item->name),
                'email' => Str::lower($item->name) . '@reno.soppeng.go.id',
                'password' => Hash::make(Str::lower($item->name) . '12345'),
                'instansi_id' => $item->code,
                'is_admin' => StatusAdminEnum::OPERATOR,
            ]);

            $createUser->assignRole('operator');
            $createUser->syncRoles('operator');
        });
    }

    protected function generateAdminUser(): void
    {
        $program = JenisBantuan::query()->get();

        $program->each(function ($item): void {
            $createUser = User::updateOrCreate([
                'name' => 'Admin ' . Str::ucfirst($item->alias),
                'email' => Str::lower('admin.' . $item->alias) . '@reno.soppeng.go.id',
                'instansi_id' => null,
                'is_admin' => StatusAdminEnum::ADMIN,
            ], [
                'name' => 'Admin ' . Str::ucfirst($item->alias),
                'email' => Str::lower('admin.' . $item->alias) . '@reno.soppeng.go.id',
                'password' => Hash::make('admin@12345'),
                'instansi_id' => null,
                'is_admin' => StatusAdminEnum::ADMIN,
            ]);

            $createUser->assignRole('admin_' . Str::lower($item->alias));
            $createUser->syncRoles('admin_' . Str::lower($item->alias));
        });
    }

    protected function deleteOperatorUser(): void
    {
        $instansi = Kelurahan::whereIn('kecamatan_code', config('custom.kode_kecamatan'))->get();
        $instansi->each(
            fn($item) => User::query()
                ->whereNotIn('id', [1, 2, 3])
                ->where('instansi_id', $item->code)
                ->delete(),
        );
    }

    protected function deleteAdminUser(): void
    {
        $program = JenisBantuan::query()->get();
        $program->each(
            fn($item) => User::query()
                ->whereNotIn('id', [1, 2, 3])
                ->whereNull('instansi_id')
                ->where('is_admin', StatusAdminEnum::ADMIN)
                ->delete(),
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generate admin')
                ->label('Generate Admin')
                ->color('warning')
                ->action(fn() => $this->generateAdminUser())
                ->after(function (): void {
                    Notification::make('Berhasil')
                        ->title('Buat Pengguna Admin')
                        ->body('Berhasil membuat user admin')
                        ->success()
                        ->send();
                })
                ->icon('heroicon-o-users'),
            Actions\Action::make('generate operator')
                ->label('Generate Operator')
                ->color('success')
                ->action(fn() => $this->generateOperatorUser())
                ->after(function (): void {
                    Notification::make('Berhasil')
                        ->title('Buat Pengguna Operator')
                        ->body('Berhasil membuat user operator')
                        ->success()
                        ->send();
                })
                ->icon('heroicon-o-users'),
            Actions\Action::make('delete admin')
                ->label('Hapus Admin')
                ->color('danger')
                ->action(fn() => $this->deleteAdminUser())
                ->after(function (): void {
                    Notification::make('Berhasil')
                        ->title('Hapus Pengguna Admin')
                        ->body('Berhasil menghapus user admin')
                        ->success()
                        ->send();
                })
                ->icon('heroicon-o-user-minus'),
            Actions\Action::make('delete operator')
                ->label('Hapus Operator')
                ->color('danger')
                ->action(fn() => $this->deleteOperatorUser())
                ->after(function (): void {
                    Notification::make('Berhasil')
                        ->title('Hapus Pengguna Operator')
                        ->body('Berhasil menghapus user operator')
                        ->success()
                        ->send();
                })
                ->icon('heroicon-o-user-minus'),
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus'),
        ];
    }
}
