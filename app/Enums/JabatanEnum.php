<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum JabatanEnum: string implements HasColor, HasLabel
{
    case KEPALA_DESA = 'KEPALA DESA';
    case SEKRETARIS_DESA = 'SEKRETARIS DESA';
    case LURAH = 'LURAH';
    case PEJABAT_SEMENTARA_KEPDES = 'PJ. KEPALA DESA';
    case PLT_LURAH = 'PLT LURAH';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::KEPALA_DESA => 'KEPALA DESA',
            self::SEKRETARIS_DESA => 'SEKRETARIS DESA',
            self::LURAH => 'LURAH',
            self::PEJABAT_SEMENTARA_KEPDES => 'PJ. KEPALA DESA',
            self::PLT_LURAH => 'PLT LURAH',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::KEPALA_DESA => 'info',
            self::SEKRETARIS_DESA => 'warning',
            self::LURAH => 'danger',
            self::PEJABAT_SEMENTARA_KEPDES => 'success',
            self::PLT_LURAH => 'primary',
        };
    }

    //    public function getIcon(): ?string
    //    {
    //        return match ($this) {
    //            self::KEPALA_DESA => 'heroicon-o-arrow-path-rounded-square',
    //            self::SEKRETARIS_DESA => 'heroicon-o-user-minus',
    //            self::LURAH => 'heroicon-o-server-stack',
    //            self::PEJABAT_SEMENTARA_KEPDES => 'heroicon-o-check-circle',
    //        };
    //    }
}
