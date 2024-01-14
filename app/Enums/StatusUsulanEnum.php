<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusUsulanEnum: string implements HasColor, HasIcon, HasLabel
{
    case BERHASIL = 'BERHASIL';
    case GAGAL = 'GAGAL';
    case ONPROGRESS = 'SEDANG PROSES';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BERHASIL => 'BERHASIL',
            self::GAGAL => 'GAGAL',
            self::ONPROGRESS => 'SEDANG PROSES',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BERHASIL => 'success',
            self::GAGAL => 'danger',
            self::ONPROGRESS => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::BERHASIL => 'heroicon-o-check-circle',
            self::GAGAL => 'heroicon-o-minus-circle',
            self::ONPROGRESS => 'heroicon-o-arrow-path',
        };
    }
}
