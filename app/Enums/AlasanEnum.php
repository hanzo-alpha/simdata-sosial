<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AlasanEnum: string implements HasColor, HasIcon, HasLabel
{
    case PINDAH = 'PINDAH';
    case MENINGGAL = 'MENINGGAL';
    case GANDA = 'GANDA';
    case MAMPU = 'MAMPU';

    public static function getSingleLabel($value): ?string
    {
        return match ($value) {
            self::PINDAH => 'PINDAH',
            self::MENINGGAL => 'MENINGGAL',
            self::GANDA => 'DATA GANDA',
            self::MAMPU => 'SUDAH MAMPU',
        };
    }

    public static function getSingleIcon($value): ?string
    {
        return match ($value) {
            self::PINDAH => 'heroicon-o-arrow-path-rounded-square',
            self::MENINGGAL => 'heroicon-o-user-minus',
            self::GANDA => 'heroicon-o-server-stack',
            self::MAMPU => 'heroicon-o-check-circle',
        };
    }

    public static function getSingleColor($value): ?string
    {
        return match ($value) {
            self::PINDAH => 'info',
            self::MENINGGAL => 'warning',
            self::GANDA => 'danger',
            self::MAMPU => 'success',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PINDAH => 'PINDAH',
            self::MENINGGAL => 'MENINGGAL',
            self::GANDA => 'DATA GANDA',
            self::MAMPU => 'SUDAH MAMPU',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PINDAH => 'info',
            self::MENINGGAL => 'warning',
            self::GANDA => 'danger',
            self::MAMPU => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PINDAH => 'heroicon-o-arrow-path-rounded-square',
            self::MENINGGAL => 'heroicon-o-user-minus',
            self::GANDA => 'heroicon-o-server-stack',
            self::MAMPU => 'heroicon-o-check-circle',
        };
    }

}
