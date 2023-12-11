<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusUsulanEnum: string implements HasLabel, HasColor, HasIcon
{
    case BERHASIL = 'BERHASIL';
    case GAGAL = 'GAGAL';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::BERHASIL => 'BERHASIL',
            self::GAGAL => 'GAGAL',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BERHASIL => 'success',
            self::GAGAL => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::BERHASIL => 'heroicon-o-check-circle',
            self::GAGAL => 'heroicon-o-minus-circle',
        };
    }
}
