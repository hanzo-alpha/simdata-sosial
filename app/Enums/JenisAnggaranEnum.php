<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum JenisAnggaranEnum: string implements HasLabel, HasColor, HasIcon
{
    case APBD = 'APBD';
    case APBN = 'APBN';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::APBD => 'APBD',
            self::APBN => 'APBN',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::APBD => 'success',
            self::APBN => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::APBD => 'heroicon-o-check-circle',
            self::APBN => 'heroicon-o-minus-circle',
        };
    }
}
