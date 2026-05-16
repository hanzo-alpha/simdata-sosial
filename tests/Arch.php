<?php

declare(strict_types=1);

use App\Models\User;

arch()
    ->expect('App\Models')
    ->ignoring([User::class, 'App\Models\Scopes'])
    ->toHaveMethod('casts');

arch()
    ->expect('App\Filament\Resources')
    ->toExtend('Filament\Resources\Resource');

arch('filament pages')
    ->expect('App\Filament\Pages')
    ->toExtend('Filament\Pages\Page')
    ->ignoring('App\Filament\Pages\Dashboard'); // Dashboard might extend Filament\Pages\Dashboard

arch('models strictly in Models namespace')
    ->expect('App\Models')
    ->toBeClasses();

arch('no debugging functions')
    ->expect(['dd', 'dump', 'var_dump', 'print_r', 'ray'])
    ->not->toBeUsed();
