<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum WarnaEnum: string implements HasColor, HasLabel
{
    case DANGER = 'danger';
    case GRAY = 'gray';
    case INFO = 'info';
    case PRIMARY = 'primary';
    case SUCCESS = 'success';
    case WARNING = 'warning';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DANGER => 'Merah',
            self::GRAY => 'Abu-Abu',
            self::INFO => 'Biru Muda',
            self::PRIMARY => 'Biru',
            self::SUCCESS => 'Hijau',
            self::WARNING => 'Orange',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DANGER => 'danger',
            self::GRAY => 'gray',
            self::INFO => 'info',
            self::PRIMARY => 'primary',
            self::SUCCESS => 'success',
            self::WARNING => 'warning',
        };
        //
        //        return match ($this) {
        //            self::DANGER => \Filament\Support\Colors\Color::Rose,
        //            self::GRAY => \Filament\Support\Colors\Color::Gray,
        //            self::INFO => \Filament\Support\Colors\Color::Blue,
        //            self::PRIMARY => \Filament\Support\Colors\Color::Indigo,
        //            self::SUCCESS => \Filament\Support\Colors\Color::Emerald,
        //            self::WARNING => \Filament\Support\Colors\Color::Orange,
        //        };
    }
}
