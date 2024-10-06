<?php

declare(strict_types=1);

namespace App\Supports;

use App\Enums\StatusAdminEnum;
use App\Models\barang;
use App\Models\BeritaAcara;
use App\Models\JenisBantuan;
use App\Models\PenyaluranBantuanPpks;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Helpers
{
    public static function generateNoSuratBeritaAcara($model = 'rastra', $sep = '/'): string
    {
        $instansi = setting('app.alias_dinas', 'DINSOS');
        $judulNo = setting('rastra.judul_no', 'BAST');
        $text = ('rastra' === $model) ? setting('rastra.judul_no', 'BAST-RASTRA') : setting('ppks.judul_no', 'BAST.B');
        $pad = setting('app.pad') ?? '0';
        $sep = setting('app.separator') ?? $sep;
        $bulan = convertToRoman(now()->month);
        $tahun = now()->year;
        $modelClass = ('rastra' === $model) ? BeritaAcara::class : PenyaluranBantuanPpks::class;
        $max = $modelClass::max('id') + 1;
        $kodePpks = setting('ppks.no_ba') ?? Str::padLeft($max, 3, $pad);
        $kodePpks = $kodePpks . $sep . $text;
        $kodeAset = Str::padLeft($max, 4, $pad) . $sep . $text;

        $kode = ('rastra' === $model) ? $kodeAset : $kodePpks;

        return $kode . $sep . $instansi . $sep . $bulan . $sep . $tahun;
    }

    public static function hitungNilaiResidu($nilai, $tahun = 5): float|int
    {
        $persen = $tahun * config('custom.depresiasi');
        $nilaiResidual = 100 - $persen;

        return ($nilaiResidual * $nilai) / 100;
    }

    public static function checkUserRoles($roles): StatusAdminEnum
    {
        return match ($roles) {
            StatusAdminEnum::SUPER_ADMIN => StatusAdminEnum::SUPER_ADMIN,
            StatusAdminEnum::ADMIN => StatusAdminEnum::ADMIN,
            StatusAdminEnum::OPERATOR => StatusAdminEnum::OPERATOR,
        };
    }

    public static function getAdminRoles(): array|Collection
    {
        return JenisBantuan::query()
            ->get()
            ->map(fn($item) => 'admin_' . Str::lower($item->alias))->toArray();
    }

    public static function getAdminBantuan(): array|Collection
    {
        $result = [];
        $jenisBantuan = JenisBantuan::query()->get();

        foreach ($jenisBantuan as $item) {
            $label = 'admin_' . Str::lower($item->alias);
            $result[$label] = $item->id;
        }

        return $result;
    }

    public static function generateNoInvoice($pemisah = null): string
    {
        $query = Barang::query();
        $length = setting('format.autonumber_length') ?? config('custom.format_auto.length');
        $pad = setting('format.pad') ?? config('custom.format_auto.pad');
        $separator = $pemisah ?? setting('format.pemisah', config('custom.format_auto.separator'));
        $max = $query->max('id') + 1;
        $kodeToko = Str::padLeft($max, $length, $pad);
        $prefix = setting('format.prefix') ?? config('custom.format_auto.prefix');
        $suffix = now()->year;
        $bulan = now()->month;

        return $prefix . $separator . $suffix . $bulan . $max . $kodeToko;
    }

    public static function generateKodeBarang(): string
    {
        $length = setting('panjang') ?? config('custom.format_auto.length');
        $pad = setting('pad') ?? config('custom.format_auto.pad');
        $separator = setting('separator') ?? config('custom.format_auto.separator');
        $max = Barang::max('id') + 1;
        $kodeAset = Str::padLeft($max, $length, $pad);

        return 'SKU' . $separator . $kodeAset;
    }

    public static function toPersen($jumlah, $total): int|string
    {
        if ( ! isset($jumlah, $total)) {
            return 0;
        }

        if ( ! is_float($jumlah) || ! is_float($total)) {
            $jumlah = (float) $jumlah;
            $total = (float) $total;
        }

        $round = round(((float) $jumlah / (float) $total) * 100, 2);
        if ($round > 100) {
            $round = 100;
        }

        return $round . '%';

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
        $modelNamespace = 'App\\Models\\';

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
        $nilai ??= 0;
        $pajak ??= 0;

        return $nilai * ($pajak / 100) ?? 0.00;
    }
}
