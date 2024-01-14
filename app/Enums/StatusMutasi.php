<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusMutasi: int implements HasColor, HasIcon, HasLabel
{
    case MUTASI = 1;
    case BATAL = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MUTASI => 'DI MUTASI',
            self::BATAL => 'BATAL MUTASI',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::MUTASI => 'success',
            self::BATAL => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::MUTASI => 'heroicon-o-check-circle',
            self::BATAL => 'heroicon-o-minus-circle',
        };
    }
}
