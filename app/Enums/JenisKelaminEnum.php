<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum JenisKelaminEnum: string implements HasLabel, HasColor, HasIcon
{
    case LAKI = 'Laki-Laki';
    case PEREMPUAN = 'Perempuan';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::LAKI => 'Laki-Laki',
            self::PEREMPUAN => 'Perempuan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::LAKI => 'success',
            self::PEREMPUAN => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::LAKI => 'heroicon-o-user-plus',
            self::PEREMPUAN => 'heroicon-o-user-minus',
        };
    }
}
