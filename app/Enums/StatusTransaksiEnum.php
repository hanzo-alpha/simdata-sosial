<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusTransaksiEnum: int implements HasColor, HasIcon, HasLabel
{
    case SDH_TRX = 1;
    case BLM_TRX = 0;
    case ON_TRX = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SDH_TRX => 'Sudah Transaksi',
            self::BLM_TRX => 'Belum Transaksi',
            self::ON_TRX => 'Sedang Transaksi',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SDH_TRX => 'success',
            self::BLM_TRX => 'warning',
            self::ON_TRX => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::SDH_TRX => 'heroicon-o-check-circle',
            self::BLM_TRX => 'heroicon-o-minus-circle',
            self::ON_TRX => 'heroicon-o-arrow-up-circle',
        };
    }
}
