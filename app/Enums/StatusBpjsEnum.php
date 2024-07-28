<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusBpjsEnum: string implements HasColor, HasIcon, HasLabel
{
    case BARU = 'BARU';
    case PENGAKTIFAN = 'PENGAKTIFAN';
    case PENGALIHAN = 'PENGALIHAN';
    //    case NONAKTIF = 'TIDAK AKTIF';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BARU => 'BARU',
            self::PENGAKTIFAN => 'PENGAKTIFAN',
            self::PENGALIHAN => 'PENGALIHAN',
            //            self::NONAKTIF => 'NON AKTIF',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BARU => 'primary',
            self::PENGAKTIFAN => 'success',
            self::PENGALIHAN => 'info',
            //            self::NONAKTIF => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::BARU => 'heroicon-o-plus-small',
            self::PENGAKTIFAN => 'heroicon-o-check',
            self::PENGALIHAN => 'heroicon-o-arrow-path-rounded-square',
            //            self::NONAKTIF => 'heroicon-o-user-minus',
        };
    }
}
