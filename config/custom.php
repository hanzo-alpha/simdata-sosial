<?php

declare(strict_types=1);

return [
    'default' => [
        'kodeprov' => '73',
        'kodekab' => '7312',
        'kodepos' => '90861',
    ],
    'kode_kecamatan' => ['731201', '731202', '731203', '731204', '731205', '731206', '731207', '731208'],
    'jenis_bantuan_default' => [
        'id' => [3, 4, 5],
    ],
    'app' => [
        'name' => 'Rumah Data Terpadu Dinas Sosial Kabupaten Soppeng',
        'logo' => null,
        'logo_dark' => null,
        'favicon' => null,
        'font' => 'Poppins',
        'dark_mode' => true,
        'logo_height' => '2rem',
        'stat_prefix' => ' Kpm',
    ],
    'format_auto' => [
        'length' => 5,
        'pad' => '0',
        'separator' => null,
        'suffix' => null,
        'prefix' => 'SKU',
    ],
    'date' => [
        'display_short' => 'D, d M Y',
        'display_short_fulltime' => 'D, d M Y H:i:s',
        'display_long' => 'l, d F Y',
        'display_long_fulltime' => 'l, d F Y H:i:s',
        'datetime_db' => 'Y-m-d H:i:s',
        'date_db' => 'Y-m-d',
        'only_date' => 'd/M/Y',
        'only_time' => 'H:i:s',
    ],
    'version' => [
        'app' => 'v1.0.0',
        'name' => 'RENO DINSOS',
    ],
];
