<?php

use Carbon\Carbon;
use function PHPUnit\Framework\isInstanceOf;

if (!function_exists('date_format')) {
    function date_format($date, $format): string
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($format);
    }
}

if (!function_exists('hitung_umur')) {
    function hitung_umur($date, $format = false): string
    {
        $date = $date instanceof Carbon ? $date->format('Y-m-d') : Carbon::parse($date)->format('Y-m-d');

        $age = \Carbon\Carbon::parse($date)->age;

        if ($format) {
            $age = \Carbon\Carbon::parse($date)->diff(\Carbon\Carbon::now())->format('%y tahun, %m bulan and %d hari');
        }

        return $age;
    }
}
