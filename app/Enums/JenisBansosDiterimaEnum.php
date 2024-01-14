<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum JenisBansosDiterimaEnum: string implements HasLabel
{
    case APBD = 'APBD';
    case APBN = 'APBN';
    case BPNTPKH = 'BPNT/PKH';
    case RASTRA = 'RASTRA';
    case BLT = 'BLT';
    case RHTL = 'RHTL';
    case BSP = 'BSP';
    case BSPS = 'BSPS';
    case BST = 'BST';
    case KURSI_RODA = 'KURSI_RODA';
    case ASPD_ATENSI = 'ASPD ATENSI';
    case PPKM = 'PPKM';
    case BANSOS_KUSTA = 'BANSOS PENYANDANG KUSTA';
    case BELUM_PERNAH = 'BELUM PERNAH';
    case NON_BANSOS = 'NON BANSOS';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::APBN => 'APBN',
            self::APBD => 'APBD',
            self::BLT => 'BLT',
            self::BPNTPKH => 'BPNT/PKH',
            self::RHTL => 'RHTL',
            self::BSP => 'BSP',
            self::BSPS => 'BSPS',
            self::BST => 'BST',
            self::KURSI_RODA => 'KURSI RODA',
            self::ASPD_ATENSI => 'ASPD ATENSI',
            self::PPKM => 'PPKM',
            self::BANSOS_KUSTA => 'BANSOS KUSTA',
            self::BELUM_PERNAH => 'BELUM PERNAH',
            self::NON_BANSOS => 'NON BANSOS',
            self::RASTRA => 'RASTRA',
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
