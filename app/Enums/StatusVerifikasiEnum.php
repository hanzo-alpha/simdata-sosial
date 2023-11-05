<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusVerifikasiEnum: int implements HasLabel, HasColor, HasIcon
{

    case UNVERIFIED = 1;
    case VERIFIED = 2;
    case NEED_REVIEW = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::UNVERIFIED => 'BELUM DIVERIFIKASI',
            self::VERIFIED => 'SUDAH DIVERIFIKASI',
            self::NEED_REVIEW => 'PERLU DI REVIEW',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::UNVERIFIED => 'danger',
            self::VERIFIED => 'success',
            self::NEED_REVIEW => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::UNVERIFIED => 'heroicon-o-minus-circle',
            self::VERIFIED => 'heroicon-o-check-circle',
            self::NEED_REVIEW => 'heroicon-o-exclamation-circle',
        };
    }
}
