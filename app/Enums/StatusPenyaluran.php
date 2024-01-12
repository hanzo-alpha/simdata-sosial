<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusPenyaluran: string implements HasLabel, HasColor
{

    case TERSALUR = 'TERSALURKAN';
    case BELUM_TERSALURKAN = 'BELUM TERSALURKAN';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BELUM_TERSALURKAN => 'BELUM TERSALURKAN',
            self::TERSALUR => 'TERSALURKAN',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BELUM_TERSALURKAN => 'danger',
            self::TERSALUR => 'success',
        };
    }

//    public function getIcon(): ?string
//    {
//        return match ($this) {
//            self::BELUM_TERSALURKAN => 'heroicon-o-minus-circle',
//            self::TERSALUR => 'heroicon-o-check-circle',
//        };
//    }
}
