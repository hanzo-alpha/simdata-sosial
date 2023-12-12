<?php
declare(strict_types=1);

namespace App\Supports;

use App\Models\ActiveAsset;
use App\Models\Brand;
use App\Models\Location;
use App\Models\Store;
use Carbon\Carbon;
use Date;
use Illuminate\Support\Str;
use Spatie\Valuestore\Valuestore;
use Symfony\Component\Uid\Ulid;

final class Helpers
{
    public static function generateKodeAset(): string
    {
        $length = self::setting()->get('format_kode')['panjang_autonumber'] ?? config('custom.generator_length');
        $pad = self::setting()->get('format_kode')['pad'] ?? config('custom.pad');
        $separator = self::setting()->get('format_kode')['pemisah'] ?? config('custom.separator');
        $max = ActiveAsset::max('id') + 1;
        $kodeAset = Str::padLeft($max, $length, $pad);
        $prefix = self::setting()->get('format_kode')['suffix'] ?? 'INV';
        $suffix = now()->year;

        return $kodeAset . $separator . $prefix . $separator . $suffix;
    }

    public static function hitungNilaiResidu($nilai, $tahun = 5): float|int
    {
        $persen = $tahun * config('custom.depresiasi');
        $nilaiResidual = 100 - $persen;
        return ($nilaiResidual * $nilai) / 100;
    }

    public static function generateNoInvoice($pemisah = null): string
    {
        $query = Store::query();
        $length = self::setting()->get('format_kode')['panjang_autonumber'] ?? config('custom.generator_length');
        $pad = self::setting()->get('format_kode')['pad'] ?? config('custom.pad');
        $separator = $pemisah ?? self::setting()->get('format_kode')['pemisah'];
        $max = $query->max('id') + 1;
        $kodeToko = Str::padLeft($max, $length, $pad);
        $prefix = self::setting()->get('format_kode')['suffix'] ?? 'INV';
        $suffix = now()->year;
        $bulan = now()->month;

        return $prefix . $separator . $suffix . $bulan . $max . $kodeToko;
    }

    public static function generateKodeSistem(): string
    {
        $length = self::setting()->get('format_kode')['panjang_autonumber'] ?? config('custom.generator_length');
        $pad = self::setting()->get('format_kode')['pad'] ?? config('custom.pad');
        $separator = self::setting()->get('format_kode')['pemisah'] ?? config('custom.separator');
        $max = ActiveAsset::max('id') + 1;
        $kodeAset = Str::padLeft($max, $length, $pad);
        $prefix = self::setting()->get('format_kode')['suffix'] ?? 'INV';
        $suffix = now()->year;

        $storeId = Store::max('id') + 1;
        $merkId = Brand::max('id') + 1;
        $assetId = ActiveAsset::max('id') + 1;
        $lokasi = Location::max('id') + 1;

        return 'SKU-' . $storeId . $merkId . $assetId . $lokasi . $kodeAset;
    }

    public static function toPersen($jumlah, $total): int|string
    {
        if (!isset($jumlah, $total)) {
            return 0;
        }

        if (!is_float($jumlah) || !is_float($total)) {
            $jumlah = (double) $jumlah;
            $total = (double) $total;
        }

        $round = round(((double) $jumlah / (double) $total) * 100, 2);
        if ($round > 100) {
            $round = 100;
        }

        return $round . '%';

    }

    public static function setting(): Valuestore
    {
        return Valuestore::make(storage_path('app/settings.json'));
    }

    public static function switchIcon($id): string
    {
        return match ($id) {
            1 => '<i class="bx bx-restaurant d-block"></i>',
            2 => '<i class="bx bx-hotel d-block"></i>',
            3 => '<i class="bx bx-layer d-block"></i>',
            4 => '<i class="bx bx-wrench d-block"></i>',
            5 => '<i class="bx bx-bulb d-block"></i>',
            default => '',
        };
    }

    public static function getModelInstance($model)
    {
        $modelNamespace = "App\\Models\\";

        return app($modelNamespace . $model);
    }

    public static function switchBadge($id): string
    {
        return match ($id) {
            1 => 'danger',
            2 => 'success',
            3 => 'info',
            4 => 'warning',
            5 => 'primary',
            default => '',
        };
    }


    public static function formatIndonesia($nilai, $koma = false): string
    {
        if ($koma) {
            return 'Rp. ' . number_format($nilai, 2, ',', '.');
        }

        return 'Rp. ' . number_format($nilai, 0, ',', '.');
    }

    public static function formatAngka($angka, $emptyVal = '0')
    {
        $angka = self::ribuan($angka);

        return empty($angka) ? $emptyVal : $angka;
    }

    public static function ribuan($num = 0, $decimal = 'auto 2'): array|string
    {
        if (empty($num)) {
            return '0';
        }
        $auto = false;
        if (str_starts_with($decimal, 'auto')) {
            [, $decimal] = explode(' ', $decimal);
            $auto = true;
        }

        $numFormat = number_format($num, $decimal, ',', '.');
        if ($auto) {
            $numFormat = str_replace(',00', '', $num);
        }

        return $numFormat;
    }

    public static function hitungPajak($nilai, $pajak): float|int
    {
        $nilai = $nilai ?? 0;
        $pajak = $pajak ?? 0;

        return $nilai * ($pajak / 100) ?? 0.00;
    }


}
