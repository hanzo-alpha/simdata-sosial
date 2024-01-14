<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusRastra: int implements HasColor, HasLabel
{
    case BARU = 1;
    case PENGGANTI = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BARU => 'BARU',
            self::PENGGANTI => 'PENGGANTIAN',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BARU => 'success',
            self::PENGGANTI => 'warning',
        };
    }

    //    public function getIcon(): ?string
    //    {
    //        return match ($this) {
    //            self::BARU => 'heroicon-o-check-circle',
    //            self::PENGGANTI => 'heroicon-o-minus-circle',
    //        };
    //    }
}
