<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum JenisBantuanSosialEnum: string implements HasLabel, HasColor
{
    case PKH = 'PKH';
    case BPNT = 'BPNT';
    case PBI_JK = 'PBI-JK';
    case RASTRA = 'RASTRA';
    case BTPD = 'BTPD';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PKH => 'PKH',
            self::BPNT => 'BPNT',
            self::PBI_JK => 'PBI-JK',
            self::RASTRA => 'RASTRA',
            self::BTPD => 'BTPD',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PKH => 'success',
            self::BPNT => 'primary',
            self::PBI_JK => 'warning',
            self::RASTRA => 'danger',
            self::BTPD => 'secondary',
        };
    }
}
