<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusDtksEnum: string implements HasColor, HasIcon, HasLabel
{
    case DTKS = 'DTKS';
    case NON_DTKS = 'NON DTKS';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DTKS => 'TERDAFTAR DTKS',
            self::NON_DTKS => 'NON DTKS',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DTKS => 'success',
            self::NON_DTKS => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::DTKS => 'heroicon-o-check-circle',
            self::NON_DTKS => 'heroicon-o-minus-circle',
        };
    }
}
