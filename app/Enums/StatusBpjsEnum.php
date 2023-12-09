<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusBpjsEnum: string implements HasLabel, HasColor, HasIcon
{
    case PENGAKTIFAN = 'PENGAKTIFAN';
    case MUTASI = 'MUTASI';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENGAKTIFAN => 'PENGAKTIFAN',
            self::MUTASI => 'MUTASI',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENGAKTIFAN => 'success',
            self::MUTASI => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PENGAKTIFAN => 'heroicon-o-user-plus',
            self::MUTASI => 'heroicon-o-user-minus',
        };
    }
}
