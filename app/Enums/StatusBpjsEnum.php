<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusBpjsEnum: string implements HasLabel, HasColor, HasIcon
{
    case BARU = 'BARU';
    case PENGAKTIFAN = 'PENGAKTIFAN';
    case PENGALIHAN = 'PENGALIHAN';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::BARU => 'BARU',
            self::PENGAKTIFAN => 'PENGAKTIFAN',
            self::PENGALIHAN => 'PENGALIHAN',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BARU => 'primary',
            self::PENGAKTIFAN => 'success',
            self::PENGALIHAN => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::BARU => 'heroicon-o-plus-small',
            self::PENGAKTIFAN => 'heroicon-o-check',
            self::PENGALIHAN => 'heroicon-o-arrow-path-rounded-square',
        };
    }
}
