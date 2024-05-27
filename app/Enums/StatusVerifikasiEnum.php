<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusVerifikasiEnum: string implements HasColor, HasLabel, HasIcon
{
    case UNVERIFIED = 'BELUM DIVERIFIKASI';
    case VERIFIED = 'TERVERIFIKASI';
    case REVIEW = 'SEDANG DITINJAU';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::UNVERIFIED => 'BELUM DIVERIFIKASI',
            self::VERIFIED => 'TERVERIFIKASI',
            self::REVIEW => 'SEDANG DITINJAU',
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
