<?php

use Carbon\Carbon;

if ( ! function_exists('date_format')) {
    function date_format($date, $format): string
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format($format);
    }
}

if ( ! function_exists('cek_batas_input')) {
    function cek_batas_input($date): bool
    {
        $date = $date instanceof Carbon ? $date : Carbon::parse($date)->format('Y-m-d');

        return strtotime($date) <= strtotime(now()->format('Y-m-d'));
    }
}

if ( ! function_exists('hitung_umur')) {
    function hitung_umur($date, $format = false): string
    {
        $date = $date instanceof Carbon ? $date->format('Y-m-d') : Carbon::parse($date)->format('Y-m-d');

        $age = Carbon::parse($date)->age;

        if ($format) {
            $age = Carbon::parse($date)->diff(Carbon::now())->format('%y tahun, %m bulan and %d hari');
        }

        return $age;
    }
}

if ( ! function_exists('list_tahun')) {
    function list_tahun(): array
    {
        $year_range = range(date('Y'), date('Y') - 3);

        return array_combine($year_range, $year_range);
    }
}

if ( ! function_exists('bulan_to_integer')) {
    function bulan_to_integer($bulan, $short = false): ?string
    {
        $bulan = Str::upper($bulan);

        if ($short) {
            return match ($bulan) {
                'JAN' => 1,
                'FEB' => 2,
                'MAR' => 3,
                'APR' => 4,
                'MEI' => 5,
                'JUN' => 6,
                'JUL' => 7,
                'AGS' => 8,
                'SEP' => 9,
                'OKT' => 10,
                'NOV' => 11,
                'DES' => 12,
                default => null,
            };
        }

        return match ($bulan) {
            'JANUARI' => 1,
            'FEBRUARI' => 2,
            'MARET' => 3,
            'APRIL' => 4,
            'MEI' => 5,
            'JUNI' => 6,
            'JULI' => 7,
            'AGUSTUS' => 8,
            'SEPTEMBER' => 9,
            'OKTOBER' => 10,
            'NOVEMBER' => 11,
            'DESEMBER' => 12,
            default => null,
        };
    }
}

if ( ! function_exists('bulan_to_string')) {
    function bulan_to_string(int|string $bulan, $short = false): string
    {
        $bulan = is_int($bulan) ? $bulan : (int) $bulan;

        if ($short) {
            return match ($bulan) {
                1 => 'JAN',
                2 => 'FEB',
                3 => 'MAR',
                4 => 'APR',
                5 => 'MEI',
                6 => 'JUN',
                7 => 'JUL',
                8 => 'AGS',
                9 => 'SEP',
                10 => 'OKT',
                11 => 'NOV',
                12 => 'DES',
            };
        }

        return match ($bulan) {
            1 => 'JANUARI',
            2 => 'FEBRUARI',
            3 => 'MARET',
            4 => 'APRIL',
            5 => 'MEI',
            6 => 'JUNI',
            7 => 'JULI',
            8 => 'AGUSTUS',
            9 => 'SEPTEMBER',
            10 => 'OKTOBER',
            11 => 'NOVEMBER',
            12 => 'DESEMBER',
        };
    }

    if ( ! function_exists('convertToRoman')) {
        function convertToRoman($integer): string
        {
            // Convert the integer into an integer (just to make sure)
            $integer = (int) $integer;
            $result = '';

            // Create a lookup array that contains all of the Roman numerals.
            $lookup = [
                'M' => 1000,
                'CM' => 900,
                'D' => 500,
                'CD' => 400,
                'C' => 100,
                'XC' => 90,
                'L' => 50,
                'XL' => 40,
                'X' => 10,
                'IX' => 9,
                'V' => 5,
                'IV' => 4,
                'I' => 1,
            ];

            foreach ($lookup as $roman => $value) {
                // Determine the number of matches
                $matches = (int) ($integer / $value);

                // Add the same number of characters to the string
                $result .= str_repeat($roman, $matches);

                // Set the integer to be the remainder of the integer and the value
                $integer %= $value;
            }

            // The Roman numeral should be built, return it
            return $result;
        }
    }
}
