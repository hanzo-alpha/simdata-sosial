<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    Gate::before(fn() => true);
});

it('can render list pages of major resources', function (string $resource, string $listPage): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test($listPage)
        ->assertSuccessful();
})->with([
    ['BantuanRastra', \App\Filament\Resources\BantuanRastraResource\Pages\ListBantuanRastra::class],
    ['BantuanBpjs', \App\Filament\Resources\BantuanBpjsResource\Pages\ListBantuanBpjs::class],
    ['BantuanBpnt', \App\Filament\Resources\BantuanBpntResource\Pages\ListBantuanBpnts::class],
    ['BantuanPkh', \App\Filament\Resources\BantuanPkhResource\Pages\ListBantuanPkh::class],
    ['BantuanPpks', \App\Filament\Resources\BantuanPpksResource\Pages\ListBantuanPpks::class],
    ['User', \App\Filament\Resources\UserResource\Pages\ManageUsers::class],
]);
