<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use phpDocumentor\Reflection\Types\Boolean;

enum StatusAktif: int implements HasLabel, HasColor, HasIcon
{
    case AKTIF = 1;
    case NONAKTIF = 0;


    public function getLabel(): ?string
    {
        return match ($this) {
            self::AKTIF => 'Aktif',
            self::NONAKTIF => 'Non Aktif',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::AKTIF => 'success',
            self::NONAKTIF => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::AKTIF => 'heroicon-o-check-circle',
            self::NONAKTIF => 'heroicon-o-minus-circle',
        };
    }
}
