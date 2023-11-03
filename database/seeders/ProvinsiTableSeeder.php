<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProvinsiTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('provinsi')->delete();

        \DB::table('provinsi')->insert([
            0 => [
                'code' => '11',
                'name' => 'ACEH',
            ],
            1 => [
                'code' => '12',
                'name' => 'SUMATERA UTARA',
            ],
            2 => [
                'code' => '13',
                'name' => 'SUMATERA BARAT',
            ],
            3 => [
                'code' => '14',
                'name' => 'RIAU',
            ],
            4 => [
                'code' => '15',
                'name' => 'JAMBI',
            ],
            5 => [
                'code' => '16',
                'name' => 'SUMATERA SELATAN',
            ],
            6 => [
                'code' => '17',
                'name' => 'BENGKULU',
            ],
            7 => [
                'code' => '18',
                'name' => 'LAMPUNG',
            ],
            8 => [
                'code' => '19',
                'name' => 'KEPULAUAN BANGKA BELITUNG',
            ],
            9 => [
                'code' => '21',
                'name' => 'KEPULAUAN RIAU',
            ],
            10 => [
                'code' => '31',
                'name' => 'DKI JAKARTA',
            ],
            11 => [
                'code' => '32',
                'name' => 'JAWA BARAT',
            ],
            12 => [
                'code' => '33',
                'name' => 'JAWA TENGAH',
            ],
            13 => [
                'code' => '34',
                'name' => 'DAERAH ISTIMEWA YOGYAKARTA',
            ],
            14 => [
                'code' => '35',
                'name' => 'JAWA TIMUR',
            ],
            15 => [
                'code' => '36',
                'name' => 'BANTEN',
            ],
            16 => [
                'code' => '51',
                'name' => 'BALI',
            ],
            17 => [
                'code' => '52',
                'name' => 'NUSA TENGGARA BARAT',
            ],
            18 => [
                'code' => '53',
                'name' => 'NUSA TENGGARA TIMUR',
            ],
            19 => [
                'code' => '61',
                'name' => 'KALIMANTAN BARAT',
            ],
            20 => [
                'code' => '62',
                'name' => 'KALIMANTAN TENGAH',
            ],
            21 => [
                'code' => '63',
                'name' => 'KALIMANTAN SELATAN',
            ],
            22 => [
                'code' => '64',
                'name' => 'KALIMANTAN TIMUR',
            ],
            23 => [
                'code' => '65',
                'name' => 'KALIMANTAN UTARA',
            ],
            24 => [
                'code' => '71',
                'name' => 'SULAWESI UTARA',
            ],
            25 => [
                'code' => '72',
                'name' => 'SULAWESI TENGAH',
            ],
            26 => [
                'code' => '73',
                'name' => 'SULAWESI SELATAN',
            ],
            27 => [
                'code' => '74',
                'name' => 'SULAWESI TENGGARA',
            ],
            28 => [
                'code' => '75',
                'name' => 'GORONTALO',
            ],
            29 => [
                'code' => '76',
                'name' => 'SULAWESI BARAT',
            ],
            30 => [
                'code' => '81',
                'name' => 'MALUKU',
            ],
            31 => [
                'code' => '82',
                'name' => 'MALUKU UTARA',
            ],
            32 => [
                'code' => '91',
                'name' => 'PAPUA',
            ],
            33 => [
                'code' => '92',
                'name' => 'PAPUA BARAT',
            ],
            34 => [
                'code' => '93',
                'name' => 'PAPUA SELATAN',
            ],
            35 => [
                'code' => '94',
                'name' => 'PAPUA TENGAH',
            ],
            36 => [
                'code' => '95',
                'name' => 'PAPUA PEGUNUNGAN',
            ],
        ]);

    }
}
