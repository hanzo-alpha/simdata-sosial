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
            self::BARU => 'success',
            self::PENGAKTIFAN => 'info',
            self::PENGALIHAN => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::BARU => 'heroicon-o-user-plus',
            self::PENGAKTIFAN => 'heroicon-o-user',
            self::PENGALIHAN => 'heroicon-o-user-minus',
        };
    }
}
