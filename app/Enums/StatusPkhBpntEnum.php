<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusPkhBpntEnum: string implements HasColor, HasIcon, HasLabel
{
    case PKH = 'PKH';
    case BPNT = 'BPNT';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PKH => 'PKH',
            self::BPNT => 'BPNT',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PKH => 'success',
            self::BPNT => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PKH => 'heroicon-o-user-plus',
            self::BPNT => 'heroicon-o-user-minus',
        };
    }
}
