<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum JenisBansosDiterimaEnum: string implements HasLabel
{
    case PBI = 'PBI';
    case PKH = 'PKH';
    case BPNT = 'BPNT';
    case RASTRA = 'RASTRA';
    case BLT = 'BLT';
    case RHTL = 'RHTL';
    case BSP = 'BSP';
    case BSPS = 'BSPS';
    case BST = 'BST';
    case ASPD_ATENSI = 'ASPD ATENSI';
    case PPKM = 'PPKM';
    case BANSOS = 'BANSOS';
    case NON_BANSOS = 'NON BANSOS';
    case BELUM_PERNAH = 'BELUM PERNAH';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PBI => 'PBI',
            self::PKH => 'PKH',
            self::BPNT => 'BPNT',
            self::RASTRA => 'RASTRA',
            self::BLT => 'BLT',
            self::RHTL => 'RHTL',
            self::BSP => 'BSP',
            self::BSPS => 'BSPS',
            self::BST => 'BST',
            self::ASPD_ATENSI => 'ASPD ATENSI',
            self::PPKM => 'PPKM',
            self::BANSOS => 'BANSOS',
            self::NON_BANSOS => 'NON BANSOS',
            self::BELUM_PERNAH => 'BELUM PERNAH',
        };
    }

    //    public function getColor(): string|array|null
    //    {
    //        return match ($this) {
    //            self::APBD => 'success',
    //            self::APBN => 'primary',
    //            self::BLT => 'warning',
    //            self::BPNTPKH => 'danger',
    //            self::RHTL => 'info',
    //            self::BSP => 'success',
    //            self::BSPS => 'primary',
    //            self::BST => 'warning',
    //            self::KURSI_RODA => 'danger',
    //            self::ASPD_ATENSI => 'info',
    //            self::PPKM => 'success',
    //            self::BANSOS_KUSTA => 'primary',
    //            self::BELUM_PERNAH => 'warning',
    //            self::NON_BANSOS => 'info',
    //            self::RASTRA => 'danger',
    //        };
    //    }
}
