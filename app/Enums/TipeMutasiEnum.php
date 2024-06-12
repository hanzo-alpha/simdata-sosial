<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TipeMutasiEnum: int implements HasColor, HasIcon, HasLabel
{
    case PESERTA_BPJS = 1;
    case PROGRAM_BPJS = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PESERTA_BPJS => 'PESERTA BPJS',
            self::PROGRAM_BPJS => 'PROGRAM BPJS',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PESERTA_BPJS => 'success',
            self::PROGRAM_BPJS => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PESERTA_BPJS => 'heroicon-o-check-circle',
            self::PROGRAM_BPJS => 'heroicon-o-minus-circle',
        };
    }
}
