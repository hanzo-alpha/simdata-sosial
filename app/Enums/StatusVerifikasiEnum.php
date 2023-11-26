<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusVerifikasiEnum: string implements HasLabel, HasColor, HasIcon
{

    case UNVERIFIED = 'UNVERIFIED';
    case VERIFIED = 'VERIFIED';
    case REVIEW = 'REVIEW';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::UNVERIFIED => 'Belum Diverifikasi',
            self::VERIFIED => 'Terverifikasi',
            self::REVIEW => 'Sedang Ditinjau',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::UNVERIFIED => 'danger',
            self::VERIFIED => 'success',
            self::REVIEW => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::UNVERIFIED => 'heroicon-o-minus-circle',
            self::VERIFIED => 'heroicon-o-check-circle',
            self::REVIEW => 'heroicon-o-exclamation-circle',
        };
    }
}
