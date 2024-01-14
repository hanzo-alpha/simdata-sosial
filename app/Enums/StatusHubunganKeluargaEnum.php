<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum StatusHubunganKeluargaEnum: string implements HasLabel
{
    case KEPALA_KELUARGA = 'Kepala Keluarga';
    case ISTRI = 'Istri';
    case ANAK = 'Anak';
    case FAMILI_LAIN = 'Famili Lain';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::KEPALA_KELUARGA => 'Kepala Keluarga',
            self::ISTRI => 'Istri',
            self::ANAK => 'Anak',
            self::FAMILI_LAIN => 'Famili Lain',
        };
    }
}
