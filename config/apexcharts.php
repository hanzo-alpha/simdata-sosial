<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Font Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify font family and font color.
    |
    */

    'options' => [
        'chart' => [
            'type' => 'line',
            'height' => 500,
            'width' => null,
            'toolbar' => [
                'show' => false,
            ],
            'stacked' => false,
            'zoom' => [
                'enabled' => true,
            ],
            'fontFamily' => 'Poppins',
            'foreColor' => '#373d3f',
        ],

        'plotOptions' => [
            'bar' => [
                'horizontal' => false,
            ],
            'pie' => [
                'expandOnClick' => true,
            ],
        ],

        'colors' => [
            '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
            '#0077B5', '#ff6384', '#c9cbcf', '#0057ff', '#00a9f4', '#2ccdc9', '#5e72e4',
        ],

        'series' => [],

        'dataLabels' => [
            'enabled' => true,
        ],

        'labels' => [],

        'title' => [
            'text' => [],
        ],

        'subtitle' => [
            'text' => '',
            'align' => 'left',
        ],

        'xaxis' => [
            'categories' => ['Program'],
        ],

        'grid' => [
            'show' => false,
        ],

        'markers' => [
            'size' => 4,
            'colors' => [
                '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
                '#0077B5', '#ff6384', '#c9cbcf', '#0057ff', '#00a9f4', '#2ccdc9', '#5e72e4',
            ],
            'strokeColors' => '#fff',
            'strokeWidth' => 2,
            'hover' => [
                'size' => 7,
            ],
        ],

        'stroke' => [
            'show' => true,
            'width' => 4,
            'colors' => [
                '#008FFB', '#00E396', '#feb019', '#ff455f', '#775dd0', '#80effe',
                '#0077B5', '#ff6384', '#c9cbcf', '#0057ff', '#00a9f4', '#2ccdc9', '#5e72e4',
            ],
        ],
    ],

];
