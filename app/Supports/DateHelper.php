<?php

declare(strict_types=1);

namespace App\Supports;

use Carbon\Carbon;
use Date;
use DateTime;

final class DateHelper
{
    public const FORMATDATE = '0000-00-00';

    public static function jumlahHari($date): int
    {
        $date ??= now();

        return Carbon::parse($date)
            ->locale(config('app.locale'))
            ->timezone(config('app.timezone'))
            ->daysInMonth;
    }

    public static function awalBulan($date): Carbon
    {
        $date ??= now();

        if ($date instanceof Carbon) {
            return $date->startOfMonth();
        }

        return Carbon::parse($date)->startOfMonth();
    }

    public static function akhirBulan($date): Carbon
    {
        $date ??= now();

        if ($date instanceof Carbon) {
            return $date->endOfMonth();
        }

        return Carbon::parse($date)->endOfMonth();
    }

    public static function checkJatuhTempo($date): bool
    {
        $selisihHari = Carbon::parse($date)->diffInDays(config('custom.tanggal_periode_pajak'));

        return $selisihHari <= 0;
    }

    public static function selisihHari($date): string
    {
        $date = null !== $date ? $date : null;
        if ($date) {
            $hari = Carbon::parse($date)->diffInDays(config('custom.tanggal_periode_pajak'));
        } else {
            $hari = null;
        }

        if ($hari <= 0) {
            return 'Sudah jatuh tempo';
        }

        return 'Sisa ' . $hari;
    }

    public static function selisihHari2($date, $format = false): string|float
    {
        $jt = strtotime($date);
        $now = strtotime(now()->toString());
        $diff = $jt - $now;
        $bedaHari = floor($diff / (60 * 60 * 24));
        if ($diff > 0) {
            if ($bedaHari < 3) {
                return $format ? 'Dalam ' . $bedaHari . ' hari' : $bedaHari;
            }

            return $format ? 'Masih dalam ' . $bedaHari . ' hari' : $bedaHari;
        }

        return $format ? 'Sudah lewat ' . $bedaHari . ' hari' : $bedaHari;
    }

    public static function convertDateFromString($date, $toDate = false): DateTime
    {
        $date ??= '';
        Date::setLocale('id');
        if ( ! $toDate) {
            return Date::parse($date)->timezone(config('app.timezone'))->locale('id')->toDateTime();
        }

        return Date::parse($date)->timezone(config('app.timezone'))->locale('id')->toDate();

    }

    public static function convertTglFromString($date, $format = 'Y-m-d'): string
    {
        $date = is_string($date) ? $date : '';
        list($dd, $mm, $yyyy) = explode('/', $date);
        //        $date = explode('/', $date);
        //        $date = DateHelper::checkdate($date);
        //        $tgl = $date[0];

        return Carbon::createFromDate($yyyy, $mm, $dd)->timezone(config('app.timezone'))->locale('id')->format($format);

    }

    public static function checkdate($date): bool
    {
        $error = false;

        //        list($dd, $mm, $yyyy) = explode('/', $date);
        //        if ( ! checkdate((int) $mm, (int) $dd, (int) $yyyy)) {
        //            $error = true;
        //        }

        if (preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/', $date, $matches)) {
            if ( ! checkdate((int) $matches[2], (int) $matches[1], (int) $matches[3])) {
                $error = true;
            }
        } else {
            $error = true;
        }

        return $error;
    }

    public static function namaHari($tanggal = ''): string
    {
        if ('' === $tanggal) {
            $tanggal = date(config('custom.date.date_db'));
            $ind = date('w', strtotime($tanggal));
        } elseif (mb_strlen($tanggal) < 2) {
            $ind = $tanggal - 1;
        } else {
            $ind = date('w', strtotime($tanggal));
        }
        $arrHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return $arrHari[$ind];
    }

    public static function getNamaBulanIndo($bln): string
    {
        $bln = null !== $bln ? $bln : config('masa_pajak_bulan');

        return match ($bln) {
            '' => 'Tidak ada Bulan',
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
            default => '',
        };
    }

    public static function listBulan($short = false): array
    {
        if ($short) {
            $bln = [
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'Mei',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Agu',
                9 => 'Sep',
                10 => 'Okt',
                11 => 'Nov',
                12 => 'Des',
            ];
        } else {
            $bln = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            ];
        }

        return $bln;
    }

    public static function namaBulan($tanggal = '', $short = false): string
    {
        if ('' === $tanggal || 'now' === $tanggal) {
            $tanggal = date(config('custom.date.date_db'));
            $ind = date('m', strtotime($tanggal));
        } elseif (mb_strlen($tanggal) < 3) {
            $ind = $tanggal;
        } else {
            $ind = date('m', strtotime($tanggal));
        }
        $ind--;
        if ($short) {
            $arrBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        } else {
            $arrBulan = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                'November', 'Desember',
            ];
        }

        return $arrBulan[$ind];
    }

    public static function indexNamaBulan($namaBulan = '', $short = false): bool|int|string
    {
        $listBulan = self::listBulan($short);

        return array_search($namaBulan, $listBulan, (bool) null);
    }

    public static function tanggal($tanggal = 'now', $shortMonth = false, $emptyVal = '')
    {
        $null = ['', self::FORMATDATE, '0000-00-00 00:00:00', '1970-01-01', null];
        if (in_array($tanggal, $null, true)) {
            return $emptyVal;
        }
        if ('now' === $tanggal) {
            $tanggal = date('Y-m-d H:i:s');
        }
        $tgl = date('j', strtotime($tanggal));
        $thn = date('Y', strtotime($tanggal));
        $bln = self::namaBulan($tanggal, $shortMonth);

        return $tgl . ' ' . $bln . ' ' . $thn;
    }

    public static function tanggalJam($tanggal = '', $sep = ' - '): string
    {
        if ('' === $tanggal) {
            $tanggal = date(config('custom.date.date_db'));
        }

        return self::tanggal($tanggal) . $sep . date('H:i', strtotime($tanggal));
    }

    public static function dayDate($tanggal = '')
    {
        Date::setLocale(config('app.locale'));
        if ('' === $tanggal) {
            $tanggal = Date::now()->format('l, j F Y');
        }

        return $tanggal;
    }

    public static function localeDate($date, $format): string
    {
        Date::setLocale(config('app.locale'));

        return Date::createFromFormat(
            config('custom.date.only_date'),
            $date->format(config('custom.date.only_date')),
        )->format($format);
    }

    public static function hariTanggal($tanggal = ''): string
    {
        Carbon::setLocale('id');
        if ('' === $tanggal) {
            $tanggal = Carbon::now()->timezone(config('app.timezone'))->format(config('custom.date.date_db'));
        }
        $tgl = date('d', strtotime($tanggal));
        $thn = date('Y', strtotime($tanggal));
        $hari = self::namaHari($tanggal);
        $tgl = (int) $tgl;
        $bln = self::namaBulan($tanggal);

        return $hari . ', ' . $tgl . ' ' . $bln . ' ' . $thn;
    }

    public static function hariTanggalJam($tanggal = '', $sep = ' pukul '): string
    {
        if ('' === $tanggal) {
            $tanggal = date(config('custom.date.date_db'));
        }

        return self::hariTanggal($tanggal) . $sep . date('H:i', strtotime($tanggal));
    }

    public static function ddmmy($tanggal = 'now', $sep = '/', $fullyear = true): string
    {
        if (null === $tanggal || self::FORMATDATE === $tanggal) {
            return '';
        }
        if ('now' === $tanggal) {
            $tanggal = date('Y-m-d');
        }
        $tanggal = strtotime($tanggal);
        $yFormat = $fullyear ? 'Y' : 'y';

        return date('d' . $sep . 'm' . $sep . $yFormat, $tanggal);
    }

    public static function dmyhi($tanggal = 'now', $sep = '/', $fullyear = true)
    {
        if (null === $tanggal || self::FORMATDATE === $tanggal) {
            return '';
        }
        if ('now' === $tanggal) {
            $tanggal = date(config('custom.date.date_db'));
        }
        $tanggal = strtotime($tanggal);
        $yFormat = $fullyear ? 'Y' : 'y';

        return date('d' . $sep . 'm' . $sep . $yFormat . ' H:i', $tanggal);
    }

    public static function addNol($str, $jumnol = 2)
    {
        if (mb_strlen($str) > $jumnol) {
            return $str;
        }

        $res = '';
        $n = $jumnol - mb_strlen($str);
        $res .= str_repeat('0', $n);

        return $res . $str;
    }

    public static function ymdhis($tanggal = '', $sep = '/', $incTime = true): string
    {
        if ('' === $tanggal) {
            return date(config('custom.date.date_db'));
        }

        [$date, $time] = array_pad(explode(' ', $tanggal), 2, date('H:i'));
        $pecah = explode($sep, $date);
        $d = self::addNol($pecah[0], 2);
        $m = self::addNol($pecah[1], 2);
        $y = $pecah[2];
        $ret = $y . '-' . $m . '-' . $d;
        if ($incTime) {
            $ret .= ' ' . $time . ':00';
        }

        return $ret;
    }

    public static function yearRange($start = '', $end = ''): array
    {
        $year1 = self::getYear($start);
        $year2 = self::getYear($end);
        $arr = range($year1, $year2);

        return array_combine($arr, $arr);
    }

    public static function listTanggal(): array
    {
        $day = [];
        for ($i = 1; $i <= 31; $i++) {
            $day[$i] = $i;
        }

        return $day;
    }

    private static function getYear(mixed $start): mixed
    {
        if (mb_strlen($start) < 4) {
            if (str_starts_with($start, '+')) {
                $year = date('Y') . mb_substr($start, 1, mb_strlen($start));
            } elseif (str_starts_with($start, '-')) {
                $year = date('Y') - mb_substr($start, 1, mb_strlen($start));
            } elseif ('0' === $start) {
                $year = date('Y');
            }
        } else {
            $year = $start;
        }

        return $year;
    }
}
