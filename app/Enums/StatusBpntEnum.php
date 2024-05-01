<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusBpntEnum: int implements HasColor, HasIcon, HasLabel
{
    case SUKSES = 1;
    case GAGAL = 0;
    case ON_PROSES = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SUKSES => 'SUKSES',
            self::GAGAL => 'GAGAL',
            self::ON_PROSES => 'SEDANG PROSES',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SUKSES => 'success',
            self::GAGAL => 'warning',
            self::ON_PROSES => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::SUKSES => 'heroicon-o-check-circle',
            self::GAGAL => 'heroicon-o-minus-circle',
            self::ON_PROSES => 'heroicon-o-arrow-up-circle',
        };
    }
}
