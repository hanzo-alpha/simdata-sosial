<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusAdminEnum: int implements HasColor, HasIcon, HasLabel
{
    case ADMIN = 1;
    case OPERATOR = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => 'ADMIN',
            self::OPERATOR => 'OPERATOR',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ADMIN => 'success',
            self::OPERATOR => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ADMIN => 'heroicon-o-check-circle',
            self::OPERATOR => 'heroicon-o-minus-circle',
        };
    }
}
