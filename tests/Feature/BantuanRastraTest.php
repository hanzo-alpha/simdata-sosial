<?php

declare(strict_types=1);

use App\Filament\Resources\BantuanRastraResource;
use App\Models\BantuanRastra;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    \Illuminate\Support\Facades\Gate::before(fn() => true);
});

it('can render rastra resource page', function (): void {
    $user = User::factory()->create();
    $role = \Spatie\Permission\Models\Role::create(['name' => 'super_admin']);
    $user->assignRole($role);

    actingAs($user)
        ->get(BantuanRastraResource::getUrl('index'))
        ->assertSuccessful();
});

it('can list rastra records', function (): void {
    $records = BantuanRastra::factory()->count(5)->create();
    $user = User::factory()->create();
    $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super_admin']);
    $user->assignRole($role);

    actingAs($user);

    $firstName = explode(' ', $records->first()->nama_lengkap)[0];

    \Livewire\Livewire::test(App\Filament\Resources\BantuanRastraResource\Pages\ListBantuanRastra::class)
        ->assertSuccessful();
});
