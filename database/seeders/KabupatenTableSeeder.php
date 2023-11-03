<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KabupatenTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('kabupaten')->delete();

        \DB::table('kabupaten')->insert([
            0 => [
                'code' => '1101',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH SELATAN',
            ],
            1 => [
                'code' => '1102',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH TENGGARA',
            ],
            2 => [
                'code' => '1103',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH TIMUR',
            ],
            3 => [
                'code' => '1104',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH TENGAH',
            ],
            4 => [
                'code' => '1105',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH BARAT',
            ],
            5 => [
                'code' => '1106',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH BESAR',
            ],
            6 => [
                'code' => '1107',
                'provinsi_code' => '11',
                'name' => 'KAB. PIDIE',
            ],
            7 => [
                'code' => '1108',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH UTARA',
            ],
            8 => [
                'code' => '1109',
                'provinsi_code' => '11',
                'name' => 'KAB. SIMEULUE',
            ],
            9 => [
                'code' => '1110',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH SINGKIL',
            ],
            10 => [
                'code' => '1111',
                'provinsi_code' => '11',
                'name' => 'KAB. BIREUEN',
            ],
            11 => [
                'code' => '1112',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH BARAT DAYA',
            ],
            12 => [
                'code' => '1113',
                'provinsi_code' => '11',
                'name' => 'KAB. GAYO LUES',
            ],
            13 => [
                'code' => '1114',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH JAYA',
            ],
            14 => [
                'code' => '1115',
                'provinsi_code' => '11',
                'name' => 'KAB. NAGAN RAYA',
            ],
            15 => [
                'code' => '1116',
                'provinsi_code' => '11',
                'name' => 'KAB. ACEH TAMIANG',
            ],
            16 => [
                'code' => '1117',
                'provinsi_code' => '11',
                'name' => 'KAB. BENER MERIAH',
            ],
            17 => [
                'code' => '1118',
                'provinsi_code' => '11',
                'name' => 'KAB. PIDIE JAYA',
            ],
            18 => [
                'code' => '1171',
                'provinsi_code' => '11',
                'name' => 'KOTA BANDA ACEH',
            ],
            19 => [
                'code' => '1172',
                'provinsi_code' => '11',
                'name' => 'KOTA SABANG',
            ],
            20 => [
                'code' => '1173',
                'provinsi_code' => '11',
                'name' => 'KOTA LHOKSEUMAWE',
            ],
            21 => [
                'code' => '1174',
                'provinsi_code' => '11',
                'name' => 'KOTA LANGSA',
            ],
            22 => [
                'code' => '1175',
                'provinsi_code' => '11',
                'name' => 'KOTA SUBULUSSALAM',
            ],
            23 => [
                'code' => '1201',
                'provinsi_code' => '12',
                'name' => 'KAB. TAPANULI TENGAH',
            ],
            24 => [
                'code' => '1202',
                'provinsi_code' => '12',
                'name' => 'KAB. TAPANULI UTARA',
            ],
            25 => [
                'code' => '1203',
                'provinsi_code' => '12',
                'name' => 'KAB. TAPANULI SELATAN',
            ],
            26 => [
                'code' => '1204',
                'provinsi_code' => '12',
                'name' => 'KAB. NIAS',
            ],
            27 => [
                'code' => '1205',
                'provinsi_code' => '12',
                'name' => 'KAB. LANGKAT',
            ],
            28 => [
                'code' => '1206',
                'provinsi_code' => '12',
                'name' => 'KAB. KARO',
            ],
            29 => [
                'code' => '1207',
                'provinsi_code' => '12',
                'name' => 'KAB. DELI SERDANG',
            ],
            30 => [
                'code' => '1208',
                'provinsi_code' => '12',
                'name' => 'KAB. SIMALUNGUN',
            ],
            31 => [
                'code' => '1209',
                'provinsi_code' => '12',
                'name' => 'KAB. ASAHAN',
            ],
            32 => [
                'code' => '1210',
                'provinsi_code' => '12',
                'name' => 'KAB. LABUHANBATU',
            ],
            33 => [
                'code' => '1211',
                'provinsi_code' => '12',
                'name' => 'KAB. DAIRI',
            ],
            34 => [
                'code' => '1212',
                'provinsi_code' => '12',
                'name' => 'KAB. TOBA',
            ],
            35 => [
                'code' => '1213',
                'provinsi_code' => '12',
                'name' => 'KAB. MANDAILING NATAL',
            ],
            36 => [
                'code' => '1214',
                'provinsi_code' => '12',
                'name' => 'KAB. NIAS SELATAN',
            ],
            37 => [
                'code' => '1215',
                'provinsi_code' => '12',
                'name' => 'KAB. PAKPAK BHARAT',
            ],
            38 => [
                'code' => '1216',
                'provinsi_code' => '12',
                'name' => 'KAB. HUMBANG HASUNDUTAN',
            ],
            39 => [
                'code' => '1217',
                'provinsi_code' => '12',
                'name' => 'KAB. SAMOSIR',
            ],
            40 => [
                'code' => '1218',
                'provinsi_code' => '12',
                'name' => 'KAB. SERDANG BEDAGAI',
            ],
            41 => [
                'code' => '1219',
                'provinsi_code' => '12',
                'name' => 'KAB. BATU BARA',
            ],
            42 => [
                'code' => '1220',
                'provinsi_code' => '12',
                'name' => 'KAB. PADANG LAWAS UTARA',
            ],
            43 => [
                'code' => '1221',
                'provinsi_code' => '12',
                'name' => 'KAB. PADANG LAWAS',
            ],
            44 => [
                'code' => '1222',
                'provinsi_code' => '12',
                'name' => 'KAB. LABUHANBATU SELATAN',
            ],
            45 => [
                'code' => '1223',
                'provinsi_code' => '12',
                'name' => 'KAB. LABUHANBATU UTARA',
            ],
            46 => [
                'code' => '1224',
                'provinsi_code' => '12',
                'name' => 'KAB. NIAS UTARA',
            ],
            47 => [
                'code' => '1225',
                'provinsi_code' => '12',
                'name' => 'KAB. NIAS BARAT',
            ],
            48 => [
                'code' => '1271',
                'provinsi_code' => '12',
                'name' => 'KOTA MEDAN',
            ],
            49 => [
                'code' => '1272',
                'provinsi_code' => '12',
                'name' => 'KOTA PEMATANGSIANTAR',
            ],
            50 => [
                'code' => '1273',
                'provinsi_code' => '12',
                'name' => 'KOTA SIBOLGA',
            ],
            51 => [
                'code' => '1274',
                'provinsi_code' => '12',
                'name' => 'KOTA TANJUNG BALAI',
            ],
            52 => [
                'code' => '1275',
                'provinsi_code' => '12',
                'name' => 'KOTA BINJAI',
            ],
            53 => [
                'code' => '1276',
                'provinsi_code' => '12',
                'name' => 'KOTA TEBING TINGGI',
            ],
            54 => [
                'code' => '1277',
                'provinsi_code' => '12',
                'name' => 'KOTA PADANGSIDIMPUAN',
            ],
            55 => [
                'code' => '1278',
                'provinsi_code' => '12',
                'name' => 'KOTA GUNUNGSITOLI',
            ],
            56 => [
                'code' => '1301',
                'provinsi_code' => '13',
                'name' => 'KAB. PESISIR SELATAN',
            ],
            57 => [
                'code' => '1302',
                'provinsi_code' => '13',
                'name' => 'KAB. SOLOK',
            ],
            58 => [
                'code' => '1303',
                'provinsi_code' => '13',
                'name' => 'KAB. SIJUNJUNG',
            ],
            59 => [
                'code' => '1304',
                'provinsi_code' => '13',
                'name' => 'KAB. TANAH DATAR',
            ],
            60 => [
                'code' => '1305',
                'provinsi_code' => '13',
                'name' => 'KAB. PADANG PARIAMAN',
            ],
            61 => [
                'code' => '1306',
                'provinsi_code' => '13',
                'name' => 'KAB. AGAM',
            ],
            62 => [
                'code' => '1307',
                'provinsi_code' => '13',
                'name' => 'KAB. LIMA PULUH KOTA',
            ],
            63 => [
                'code' => '1308',
                'provinsi_code' => '13',
                'name' => 'KAB. PASAMAN',
            ],
            64 => [
                'code' => '1309',
                'provinsi_code' => '13',
                'name' => 'KAB. KEPULAUAN MENTAWAI',
            ],
            65 => [
                'code' => '1310',
                'provinsi_code' => '13',
                'name' => 'KAB. DHARMASRAYA',
            ],
            66 => [
                'code' => '1311',
                'provinsi_code' => '13',
                'name' => 'KAB. SOLOK SELATAN',
            ],
            67 => [
                'code' => '1312',
                'provinsi_code' => '13',
                'name' => 'KAB. PASAMAN BARAT',
            ],
            68 => [
                'code' => '1371',
                'provinsi_code' => '13',
                'name' => 'KOTA PADANG',
            ],
            69 => [
                'code' => '1372',
                'provinsi_code' => '13',
                'name' => 'KOTA SOLOK',
            ],
            70 => [
                'code' => '1373',
                'provinsi_code' => '13',
                'name' => 'KOTA SAWAHLUNTO',
            ],
            71 => [
                'code' => '1374',
                'provinsi_code' => '13',
                'name' => 'KOTA PADANG PANJANG',
            ],
            72 => [
                'code' => '1375',
                'provinsi_code' => '13',
                'name' => 'KOTA BUKITTINGGI',
            ],
            73 => [
                'code' => '1376',
                'provinsi_code' => '13',
                'name' => 'KOTA PAYAKUMBUH',
            ],
            74 => [
                'code' => '1377',
                'provinsi_code' => '13',
                'name' => 'KOTA PARIAMAN',
            ],
            75 => [
                'code' => '1401',
                'provinsi_code' => '14',
                'name' => 'KAB. KAMPAR',
            ],
            76 => [
                'code' => '1402',
                'provinsi_code' => '14',
                'name' => 'KAB. INDRAGIRI HULU',
            ],
            77 => [
                'code' => '1403',
                'provinsi_code' => '14',
                'name' => 'KAB. BENGKALIS',
            ],
            78 => [
                'code' => '1404',
                'provinsi_code' => '14',
                'name' => 'KAB. INDRAGIRI HILIR',
            ],
            79 => [
                'code' => '1405',
                'provinsi_code' => '14',
                'name' => 'KAB. PELALAWAN',
            ],
            80 => [
                'code' => '1406',
                'provinsi_code' => '14',
                'name' => 'KAB. ROKAN HULU',
            ],
            81 => [
                'code' => '1407',
                'provinsi_code' => '14',
                'name' => 'KAB. ROKAN HILIR',
            ],
            82 => [
                'code' => '1408',
                'provinsi_code' => '14',
                'name' => 'KAB. SIAK',
            ],
            83 => [
                'code' => '1409',
                'provinsi_code' => '14',
                'name' => 'KAB. KUANTAN SINGINGI',
            ],
            84 => [
                'code' => '1410',
                'provinsi_code' => '14',
                'name' => 'KAB. KEPULAUAN MERANTI',
            ],
            85 => [
                'code' => '1471',
                'provinsi_code' => '14',
                'name' => 'KOTA PEKANBARU',
            ],
            86 => [
                'code' => '1472',
                'provinsi_code' => '14',
                'name' => 'KOTA DUMAI',
            ],
            87 => [
                'code' => '1501',
                'provinsi_code' => '15',
                'name' => 'KAB. KERINCI',
            ],
            88 => [
                'code' => '1502',
                'provinsi_code' => '15',
                'name' => 'KAB. MERANGIN',
            ],
            89 => [
                'code' => '1503',
                'provinsi_code' => '15',
                'name' => 'KAB. SAROLANGUN',
            ],
            90 => [
                'code' => '1504',
                'provinsi_code' => '15',
                'name' => 'KAB. BATANGHARI',
            ],
            91 => [
                'code' => '1505',
                'provinsi_code' => '15',
                'name' => 'KAB. MUARO JAMBI',
            ],
            92 => [
                'code' => '1506',
                'provinsi_code' => '15',
                'name' => 'KAB. TANJUNG JABUNG BARAT',
            ],
            93 => [
                'code' => '1507',
                'provinsi_code' => '15',
                'name' => 'KAB. TANJUNG JABUNG TIMUR',
            ],
            94 => [
                'code' => '1508',
                'provinsi_code' => '15',
                'name' => 'KAB. BUNGO',
            ],
            95 => [
                'code' => '1509',
                'provinsi_code' => '15',
                'name' => 'KAB. TEBO',
            ],
            96 => [
                'code' => '1571',
                'provinsi_code' => '15',
                'name' => 'KOTA JAMBI',
            ],
            97 => [
                'code' => '1572',
                'provinsi_code' => '15',
                'name' => 'KOTA SUNGAI PENUH',
            ],
            98 => [
                'code' => '1601',
                'provinsi_code' => '16',
                'name' => 'KAB. OGAN KOMERING ULU',
            ],
            99 => [
                'code' => '1602',
                'provinsi_code' => '16',
                'name' => 'KAB. OGAN KOMERING ILIR',
            ],
            100 => [
                'code' => '1603',
                'provinsi_code' => '16',
                'name' => 'KAB. MUARA ENIM',
            ],
            101 => [
                'code' => '1604',
                'provinsi_code' => '16',
                'name' => 'KAB. LAHAT',
            ],
            102 => [
                'code' => '1605',
                'provinsi_code' => '16',
                'name' => 'KAB. MUSI RAWAS',
            ],
            103 => [
                'code' => '1606',
                'provinsi_code' => '16',
                'name' => 'KAB. MUSI BANYUASIN',
            ],
            104 => [
                'code' => '1607',
                'provinsi_code' => '16',
                'name' => 'KAB. BANYUASIN',
            ],
            105 => [
                'code' => '1608',
                'provinsi_code' => '16',
                'name' => 'KAB. OGAN KOMERING ULU TIMUR',
            ],
            106 => [
                'code' => '1609',
                'provinsi_code' => '16',
                'name' => 'KAB. OGAN KOMERING ULU SELATAN',
            ],
            107 => [
                'code' => '1610',
                'provinsi_code' => '16',
                'name' => 'KAB. OGAN ILIR',
            ],
            108 => [
                'code' => '1611',
                'provinsi_code' => '16',
                'name' => 'KAB. EMPAT LAWANG',
            ],
            109 => [
                'code' => '1612',
                'provinsi_code' => '16',
                'name' => 'KAB. PENUKAL ABAB LEMATANG ILIR',
            ],
            110 => [
                'code' => '1613',
                'provinsi_code' => '16',
                'name' => 'KAB. MUSI RAWAS UTARA',
            ],
            111 => [
                'code' => '1671',
                'provinsi_code' => '16',
                'name' => 'KOTA PALEMBANG',
            ],
            112 => [
                'code' => '1672',
                'provinsi_code' => '16',
                'name' => 'KOTA PAGAR ALAM',
            ],
            113 => [
                'code' => '1673',
                'provinsi_code' => '16',
                'name' => 'KOTA LUBUK LINGGAU',
            ],
            114 => [
                'code' => '1674',
                'provinsi_code' => '16',
                'name' => 'KOTA PRABUMULIH',
            ],
            115 => [
                'code' => '1701',
                'provinsi_code' => '17',
                'name' => 'KAB. BENGKULU SELATAN',
            ],
            116 => [
                'code' => '1702',
                'provinsi_code' => '17',
                'name' => 'KAB. REJANG LEBONG',
            ],
            117 => [
                'code' => '1703',
                'provinsi_code' => '17',
                'name' => 'KAB. BENGKULU UTARA',
            ],
            118 => [
                'code' => '1704',
                'provinsi_code' => '17',
                'name' => 'KAB. KAUR',
            ],
            119 => [
                'code' => '1705',
                'provinsi_code' => '17',
                'name' => 'KAB. SELUMA',
            ],
            120 => [
                'code' => '1706',
                'provinsi_code' => '17',
                'name' => 'KAB. MUKO MUKO',
            ],
            121 => [
                'code' => '1707',
                'provinsi_code' => '17',
                'name' => 'KAB. LEBONG',
            ],
            122 => [
                'code' => '1708',
                'provinsi_code' => '17',
                'name' => 'KAB. KEPAHIANG',
            ],
            123 => [
                'code' => '1709',
                'provinsi_code' => '17',
                'name' => 'KAB. BENGKULU TENGAH',
            ],
            124 => [
                'code' => '1771',
                'provinsi_code' => '17',
                'name' => 'KOTA BENGKULU',
            ],
            125 => [
                'code' => '1801',
                'provinsi_code' => '18',
                'name' => 'KAB. LAMPUNG SELATAN',
            ],
            126 => [
                'code' => '1802',
                'provinsi_code' => '18',
                'name' => 'KAB. LAMPUNG TENGAH',
            ],
            127 => [
                'code' => '1803',
                'provinsi_code' => '18',
                'name' => 'KAB. LAMPUNG UTARA',
            ],
            128 => [
                'code' => '1804',
                'provinsi_code' => '18',
                'name' => 'KAB. LAMPUNG BARAT',
            ],
            129 => [
                'code' => '1805',
                'provinsi_code' => '18',
                'name' => 'KAB. TULANG BAWANG',
            ],
            130 => [
                'code' => '1806',
                'provinsi_code' => '18',
                'name' => 'KAB. TANGGAMUS',
            ],
            131 => [
                'code' => '1807',
                'provinsi_code' => '18',
                'name' => 'KAB. LAMPUNG TIMUR',
            ],
            132 => [
                'code' => '1808',
                'provinsi_code' => '18',
                'name' => 'KAB. WAY KANAN',
            ],
            133 => [
                'code' => '1809',
                'provinsi_code' => '18',
                'name' => 'KAB. PESAWARAN',
            ],
            134 => [
                'code' => '1810',
                'provinsi_code' => '18',
                'name' => 'KAB. PRINGSEWU',
            ],
            135 => [
                'code' => '1811',
                'provinsi_code' => '18',
                'name' => 'KAB. MESUJI',
            ],
            136 => [
                'code' => '1812',
                'provinsi_code' => '18',
                'name' => 'KAB. TULANG BAWANG BARAT',
            ],
            137 => [
                'code' => '1813',
                'provinsi_code' => '18',
                'name' => 'KAB. PESISIR BARAT',
            ],
            138 => [
                'code' => '1871',
                'provinsi_code' => '18',
                'name' => 'KOTA BANDAR LAMPUNG',
            ],
            139 => [
                'code' => '1872',
                'provinsi_code' => '18',
                'name' => 'KOTA METRO',
            ],
            140 => [
                'code' => '1901',
                'provinsi_code' => '19',
                'name' => 'KAB. BANGKA',
            ],
            141 => [
                'code' => '1902',
                'provinsi_code' => '19',
                'name' => 'KAB. BELITUNG',
            ],
            142 => [
                'code' => '1903',
                'provinsi_code' => '19',
                'name' => 'KAB. BANGKA SELATAN',
            ],
            143 => [
                'code' => '1904',
                'provinsi_code' => '19',
                'name' => 'KAB. BANGKA TENGAH',
            ],
            144 => [
                'code' => '1905',
                'provinsi_code' => '19',
                'name' => 'KAB. BANGKA BARAT',
            ],
            145 => [
                'code' => '1906',
                'provinsi_code' => '19',
                'name' => 'KAB. BELITUNG TIMUR',
            ],
            146 => [
                'code' => '1971',
                'provinsi_code' => '19',
                'name' => 'KOTA PANGKAL PINANG',
            ],
            147 => [
                'code' => '2101',
                'provinsi_code' => '21',
                'name' => 'KAB. BINTAN',
            ],
            148 => [
                'code' => '2102',
                'provinsi_code' => '21',
                'name' => 'KAB. KARIMUN',
            ],
            149 => [
                'code' => '2103',
                'provinsi_code' => '21',
                'name' => 'KAB. NATUNA',
            ],
            150 => [
                'code' => '2104',
                'provinsi_code' => '21',
                'name' => 'KAB. LINGGA',
            ],
            151 => [
                'code' => '2105',
                'provinsi_code' => '21',
                'name' => 'KAB. KEPULAUAN ANAMBAS',
            ],
            152 => [
                'code' => '2171',
                'provinsi_code' => '21',
                'name' => 'KOTA BATAM',
            ],
            153 => [
                'code' => '2172',
                'provinsi_code' => '21',
                'name' => 'KOTA TANJUNG PINANG',
            ],
            154 => [
                'code' => '3101',
                'provinsi_code' => '31',
                'name' => 'KAB. ADM. KEP. SERIBU',
            ],
            155 => [
                'code' => '3171',
                'provinsi_code' => '31',
                'name' => 'KOTA ADM. JAKARTA PUSAT',
            ],
            156 => [
                'code' => '3172',
                'provinsi_code' => '31',
                'name' => 'KOTA ADM. JAKARTA UTARA',
            ],
            157 => [
                'code' => '3173',
                'provinsi_code' => '31',
                'name' => 'KOTA ADM. JAKARTA BARAT',
            ],
            158 => [
                'code' => '3174',
                'provinsi_code' => '31',
                'name' => 'KOTA ADM. JAKARTA SELATAN',
            ],
            159 => [
                'code' => '3175',
                'provinsi_code' => '31',
                'name' => 'KOTA ADM. JAKARTA TIMUR',
            ],
            160 => [
                'code' => '3201',
                'provinsi_code' => '32',
                'name' => 'KAB. BOGOR',
            ],
            161 => [
                'code' => '3202',
                'provinsi_code' => '32',
                'name' => 'KAB. SUKABUMI',
            ],
            162 => [
                'code' => '3203',
                'provinsi_code' => '32',
                'name' => 'KAB. CIANJUR',
            ],
            163 => [
                'code' => '3204',
                'provinsi_code' => '32',
                'name' => 'KAB. BANDUNG',
            ],
            164 => [
                'code' => '3205',
                'provinsi_code' => '32',
                'name' => 'KAB. GARUT',
            ],
            165 => [
                'code' => '3206',
                'provinsi_code' => '32',
                'name' => 'KAB. TASIKMALAYA',
            ],
            166 => [
                'code' => '3207',
                'provinsi_code' => '32',
                'name' => 'KAB. CIAMIS',
            ],
            167 => [
                'code' => '3208',
                'provinsi_code' => '32',
                'name' => 'KAB. KUNINGAN',
            ],
            168 => [
                'code' => '3209',
                'provinsi_code' => '32',
                'name' => 'KAB. CIREBON',
            ],
            169 => [
                'code' => '3210',
                'provinsi_code' => '32',
                'name' => 'KAB. MAJALENGKA',
            ],
            170 => [
                'code' => '3211',
                'provinsi_code' => '32',
                'name' => 'KAB. SUMEDANG',
            ],
            171 => [
                'code' => '3212',
                'provinsi_code' => '32',
                'name' => 'KAB. INDRAMAYU',
            ],
            172 => [
                'code' => '3213',
                'provinsi_code' => '32',
                'name' => 'KAB. SUBANG',
            ],
            173 => [
                'code' => '3214',
                'provinsi_code' => '32',
                'name' => 'KAB. PURWAKARTA',
            ],
            174 => [
                'code' => '3215',
                'provinsi_code' => '32',
                'name' => 'KAB. KARAWANG',
            ],
            175 => [
                'code' => '3216',
                'provinsi_code' => '32',
                'name' => 'KAB. BEKASI',
            ],
            176 => [
                'code' => '3217',
                'provinsi_code' => '32',
                'name' => 'KAB. BANDUNG BARAT',
            ],
            177 => [
                'code' => '3218',
                'provinsi_code' => '32',
                'name' => 'KAB. PANGANDARAN',
            ],
            178 => [
                'code' => '3271',
                'provinsi_code' => '32',
                'name' => 'KOTA BOGOR',
            ],
            179 => [
                'code' => '3272',
                'provinsi_code' => '32',
                'name' => 'KOTA SUKABUMI',
            ],
            180 => [
                'code' => '3273',
                'provinsi_code' => '32',
                'name' => 'KOTA BANDUNG',
            ],
            181 => [
                'code' => '3274',
                'provinsi_code' => '32',
                'name' => 'KOTA CIREBON',
            ],
            182 => [
                'code' => '3275',
                'provinsi_code' => '32',
                'name' => 'KOTA BEKASI',
            ],
            183 => [
                'code' => '3276',
                'provinsi_code' => '32',
                'name' => 'KOTA DEPOK',
            ],
            184 => [
                'code' => '3277',
                'provinsi_code' => '32',
                'name' => 'KOTA CIMAHI',
            ],
            185 => [
                'code' => '3278',
                'provinsi_code' => '32',
                'name' => 'KOTA TASIKMALAYA',
            ],
            186 => [
                'code' => '3279',
                'provinsi_code' => '32',
                'name' => 'KOTA BANJAR',
            ],
            187 => [
                'code' => '3301',
                'provinsi_code' => '33',
                'name' => 'KAB. CILACAP',
            ],
            188 => [
                'code' => '3302',
                'provinsi_code' => '33',
                'name' => 'KAB. BANYUMAS',
            ],
            189 => [
                'code' => '3303',
                'provinsi_code' => '33',
                'name' => 'KAB. PURBALINGGA',
            ],
            190 => [
                'code' => '3304',
                'provinsi_code' => '33',
                'name' => 'KAB. BANJARNEGARA',
            ],
            191 => [
                'code' => '3305',
                'provinsi_code' => '33',
                'name' => 'KAB. KEBUMEN',
            ],
            192 => [
                'code' => '3306',
                'provinsi_code' => '33',
                'name' => 'KAB. PURWOREJO',
            ],
            193 => [
                'code' => '3307',
                'provinsi_code' => '33',
                'name' => 'KAB. WONOSOBO',
            ],
            194 => [
                'code' => '3308',
                'provinsi_code' => '33',
                'name' => 'KAB. MAGELANG',
            ],
            195 => [
                'code' => '3309',
                'provinsi_code' => '33',
                'name' => 'KAB. BOYOLALI',
            ],
            196 => [
                'code' => '3310',
                'provinsi_code' => '33',
                'name' => 'KAB. KLATEN',
            ],
            197 => [
                'code' => '3311',
                'provinsi_code' => '33',
                'name' => 'KAB. SUKOHARJO',
            ],
            198 => [
                'code' => '3312',
                'provinsi_code' => '33',
                'name' => 'KAB. WONOGIRI',
            ],
            199 => [
                'code' => '3313',
                'provinsi_code' => '33',
                'name' => 'KAB. KARANGANYAR',
            ],
            200 => [
                'code' => '3314',
                'provinsi_code' => '33',
                'name' => 'KAB. SRAGEN',
            ],
            201 => [
                'code' => '3315',
                'provinsi_code' => '33',
                'name' => 'KAB. GROBOGAN',
            ],
            202 => [
                'code' => '3316',
                'provinsi_code' => '33',
                'name' => 'KAB. BLORA',
            ],
            203 => [
                'code' => '3317',
                'provinsi_code' => '33',
                'name' => 'KAB. REMBANG',
            ],
            204 => [
                'code' => '3318',
                'provinsi_code' => '33',
                'name' => 'KAB. PATI',
            ],
            205 => [
                'code' => '3319',
                'provinsi_code' => '33',
                'name' => 'KAB. KUDUS',
            ],
            206 => [
                'code' => '3320',
                'provinsi_code' => '33',
                'name' => 'KAB. JEPARA',
            ],
            207 => [
                'code' => '3321',
                'provinsi_code' => '33',
                'name' => 'KAB. DEMAK',
            ],
            208 => [
                'code' => '3322',
                'provinsi_code' => '33',
                'name' => 'KAB. SEMARANG',
            ],
            209 => [
                'code' => '3323',
                'provinsi_code' => '33',
                'name' => 'KAB. TEMANGGUNG',
            ],
            210 => [
                'code' => '3324',
                'provinsi_code' => '33',
                'name' => 'KAB. KENDAL',
            ],
            211 => [
                'code' => '3325',
                'provinsi_code' => '33',
                'name' => 'KAB. BATANG',
            ],
            212 => [
                'code' => '3326',
                'provinsi_code' => '33',
                'name' => 'KAB. PEKALONGAN',
            ],
            213 => [
                'code' => '3327',
                'provinsi_code' => '33',
                'name' => 'KAB. PEMALANG',
            ],
            214 => [
                'code' => '3328',
                'provinsi_code' => '33',
                'name' => 'KAB. TEGAL',
            ],
            215 => [
                'code' => '3329',
                'provinsi_code' => '33',
                'name' => 'KAB. BREBES',
            ],
            216 => [
                'code' => '3371',
                'provinsi_code' => '33',
                'name' => 'KOTA MAGELANG',
            ],
            217 => [
                'code' => '3372',
                'provinsi_code' => '33',
                'name' => 'KOTA SURAKARTA',
            ],
            218 => [
                'code' => '3373',
                'provinsi_code' => '33',
                'name' => 'KOTA SALATIGA',
            ],
            219 => [
                'code' => '3374',
                'provinsi_code' => '33',
                'name' => 'KOTA SEMARANG',
            ],
            220 => [
                'code' => '3375',
                'provinsi_code' => '33',
                'name' => 'KOTA PEKALONGAN',
            ],
            221 => [
                'code' => '3376',
                'provinsi_code' => '33',
                'name' => 'KOTA TEGAL',
            ],
            222 => [
                'code' => '3401',
                'provinsi_code' => '34',
                'name' => 'KAB. KULON PROGO',
            ],
            223 => [
                'code' => '3402',
                'provinsi_code' => '34',
                'name' => 'KAB. BANTUL',
            ],
            224 => [
                'code' => '3403',
                'provinsi_code' => '34',
                'name' => 'KAB. GUNUNGKIDUL',
            ],
            225 => [
                'code' => '3404',
                'provinsi_code' => '34',
                'name' => 'KAB. SLEMAN',
            ],
            226 => [
                'code' => '3471',
                'provinsi_code' => '34',
                'name' => 'KOTA YOGYAKARTA',
            ],
            227 => [
                'code' => '3501',
                'provinsi_code' => '35',
                'name' => 'KAB. PACITAN',
            ],
            228 => [
                'code' => '3502',
                'provinsi_code' => '35',
                'name' => 'KAB. PONOROGO',
            ],
            229 => [
                'code' => '3503',
                'provinsi_code' => '35',
                'name' => 'KAB. TRENGGALEK',
            ],
            230 => [
                'code' => '3504',
                'provinsi_code' => '35',
                'name' => 'KAB. TULUNGAGUNG',
            ],
            231 => [
                'code' => '3505',
                'provinsi_code' => '35',
                'name' => 'KAB. BLITAR',
            ],
            232 => [
                'code' => '3506',
                'provinsi_code' => '35',
                'name' => 'KAB. KEDIRI',
            ],
            233 => [
                'code' => '3507',
                'provinsi_code' => '35',
                'name' => 'KAB. MALANG',
            ],
            234 => [
                'code' => '3508',
                'provinsi_code' => '35',
                'name' => 'KAB. LUMAJANG',
            ],
            235 => [
                'code' => '3509',
                'provinsi_code' => '35',
                'name' => 'KAB. JEMBER',
            ],
            236 => [
                'code' => '3510',
                'provinsi_code' => '35',
                'name' => 'KAB. BANYUWANGI',
            ],
            237 => [
                'code' => '3511',
                'provinsi_code' => '35',
                'name' => 'KAB. BONDOWOSO',
            ],
            238 => [
                'code' => '3512',
                'provinsi_code' => '35',
                'name' => 'KAB. SITUBONDO',
            ],
            239 => [
                'code' => '3513',
                'provinsi_code' => '35',
                'name' => 'KAB. PROBOLINGGO',
            ],
            240 => [
                'code' => '3514',
                'provinsi_code' => '35',
                'name' => 'KAB. PASURUAN',
            ],
            241 => [
                'code' => '3515',
                'provinsi_code' => '35',
                'name' => 'KAB. SIDOARJO',
            ],
            242 => [
                'code' => '3516',
                'provinsi_code' => '35',
                'name' => 'KAB. MOJOKERTO',
            ],
            243 => [
                'code' => '3517',
                'provinsi_code' => '35',
                'name' => 'KAB. JOMBANG',
            ],
            244 => [
                'code' => '3518',
                'provinsi_code' => '35',
                'name' => 'KAB. NGANJUK',
            ],
            245 => [
                'code' => '3519',
                'provinsi_code' => '35',
                'name' => 'KAB. MADIUN',
            ],
            246 => [
                'code' => '3520',
                'provinsi_code' => '35',
                'name' => 'KAB. MAGETAN',
            ],
            247 => [
                'code' => '3521',
                'provinsi_code' => '35',
                'name' => 'KAB. NGAWI',
            ],
            248 => [
                'code' => '3522',
                'provinsi_code' => '35',
                'name' => 'KAB. BOJONEGORO',
            ],
            249 => [
                'code' => '3523',
                'provinsi_code' => '35',
                'name' => 'KAB. TUBAN',
            ],
            250 => [
                'code' => '3524',
                'provinsi_code' => '35',
                'name' => 'KAB. LAMONGAN',
            ],
            251 => [
                'code' => '3525',
                'provinsi_code' => '35',
                'name' => 'KAB. GRESIK',
            ],
            252 => [
                'code' => '3526',
                'provinsi_code' => '35',
                'name' => 'KAB. BANGKALAN',
            ],
            253 => [
                'code' => '3527',
                'provinsi_code' => '35',
                'name' => 'KAB. SAMPANG',
            ],
            254 => [
                'code' => '3528',
                'provinsi_code' => '35',
                'name' => 'KAB. PAMEKASAN',
            ],
            255 => [
                'code' => '3529',
                'provinsi_code' => '35',
                'name' => 'KAB. SUMENEP',
            ],
            256 => [
                'code' => '3571',
                'provinsi_code' => '35',
                'name' => 'KOTA KEDIRI',
            ],
            257 => [
                'code' => '3572',
                'provinsi_code' => '35',
                'name' => 'KOTA BLITAR',
            ],
            258 => [
                'code' => '3573',
                'provinsi_code' => '35',
                'name' => 'KOTA MALANG',
            ],
            259 => [
                'code' => '3574',
                'provinsi_code' => '35',
                'name' => 'KOTA PROBOLINGGO',
            ],
            260 => [
                'code' => '3575',
                'provinsi_code' => '35',
                'name' => 'KOTA PASURUAN',
            ],
            261 => [
                'code' => '3576',
                'provinsi_code' => '35',
                'name' => 'KOTA MOJOKERTO',
            ],
            262 => [
                'code' => '3577',
                'provinsi_code' => '35',
                'name' => 'KOTA MADIUN',
            ],
            263 => [
                'code' => '3578',
                'provinsi_code' => '35',
                'name' => 'KOTA SURABAYA',
            ],
            264 => [
                'code' => '3579',
                'provinsi_code' => '35',
                'name' => 'KOTA BATU',
            ],
            265 => [
                'code' => '3601',
                'provinsi_code' => '36',
                'name' => 'KAB. PANDEGLANG',
            ],
            266 => [
                'code' => '3602',
                'provinsi_code' => '36',
                'name' => 'KAB. LEBAK',
            ],
            267 => [
                'code' => '3603',
                'provinsi_code' => '36',
                'name' => 'KAB. TANGERANG',
            ],
            268 => [
                'code' => '3604',
                'provinsi_code' => '36',
                'name' => 'KAB. SERANG',
            ],
            269 => [
                'code' => '3671',
                'provinsi_code' => '36',
                'name' => 'KOTA TANGERANG',
            ],
            270 => [
                'code' => '3672',
                'provinsi_code' => '36',
                'name' => 'KOTA CILEGON',
            ],
            271 => [
                'code' => '3673',
                'provinsi_code' => '36',
                'name' => 'KOTA SERANG',
            ],
            272 => [
                'code' => '3674',
                'provinsi_code' => '36',
                'name' => 'KOTA TANGERANG SELATAN',
            ],
            273 => [
                'code' => '5101',
                'provinsi_code' => '51',
                'name' => 'KAB. JEMBRANA',
            ],
            274 => [
                'code' => '5102',
                'provinsi_code' => '51',
                'name' => 'KAB. TABANAN',
            ],
            275 => [
                'code' => '5103',
                'provinsi_code' => '51',
                'name' => 'KAB. BADUNG',
            ],
            276 => [
                'code' => '5104',
                'provinsi_code' => '51',
                'name' => 'KAB. GIANYAR',
            ],
            277 => [
                'code' => '5105',
                'provinsi_code' => '51',
                'name' => 'KAB. KLUNGKUNG',
            ],
            278 => [
                'code' => '5106',
                'provinsi_code' => '51',
                'name' => 'KAB. BANGLI',
            ],
            279 => [
                'code' => '5107',
                'provinsi_code' => '51',
                'name' => 'KAB. KARANGASEM',
            ],
            280 => [
                'code' => '5108',
                'provinsi_code' => '51',
                'name' => 'KAB. BULELENG',
            ],
            281 => [
                'code' => '5171',
                'provinsi_code' => '51',
                'name' => 'KOTA DENPASAR',
            ],
            282 => [
                'code' => '5201',
                'provinsi_code' => '52',
                'name' => 'KAB. LOMBOK BARAT',
            ],
            283 => [
                'code' => '5202',
                'provinsi_code' => '52',
                'name' => 'KAB. LOMBOK TENGAH',
            ],
            284 => [
                'code' => '5203',
                'provinsi_code' => '52',
                'name' => 'KAB. LOMBOK TIMUR',
            ],
            285 => [
                'code' => '5204',
                'provinsi_code' => '52',
                'name' => 'KAB. SUMBAWA',
            ],
            286 => [
                'code' => '5205',
                'provinsi_code' => '52',
                'name' => 'KAB. DOMPU',
            ],
            287 => [
                'code' => '5206',
                'provinsi_code' => '52',
                'name' => 'KAB. BIMA',
            ],
            288 => [
                'code' => '5207',
                'provinsi_code' => '52',
                'name' => 'KAB. SUMBAWA BARAT',
            ],
            289 => [
                'code' => '5208',
                'provinsi_code' => '52',
                'name' => 'KAB. LOMBOK UTARA',
            ],
            290 => [
                'code' => '5271',
                'provinsi_code' => '52',
                'name' => 'KOTA MATARAM',
            ],
            291 => [
                'code' => '5272',
                'provinsi_code' => '52',
                'name' => 'KOTA BIMA',
            ],
            292 => [
                'code' => '5301',
                'provinsi_code' => '53',
                'name' => 'KAB. KUPANG',
            ],
            293 => [
                'code' => '5302',
                'provinsi_code' => '53',
                'name' => 'KAB TIMOR TENGAH SELATAN',
            ],
            294 => [
                'code' => '5303',
                'provinsi_code' => '53',
                'name' => 'KAB. TIMOR TENGAH UTARA',
            ],
            295 => [
                'code' => '5304',
                'provinsi_code' => '53',
                'name' => 'KAB. BELU',
            ],
            296 => [
                'code' => '5305',
                'provinsi_code' => '53',
                'name' => 'KAB. ALOR',
            ],
            297 => [
                'code' => '5306',
                'provinsi_code' => '53',
                'name' => 'KAB. FLORES TIMUR',
            ],
            298 => [
                'code' => '5307',
                'provinsi_code' => '53',
                'name' => 'KAB. SIKKA',
            ],
            299 => [
                'code' => '5308',
                'provinsi_code' => '53',
                'name' => 'KAB. ENDE',
            ],
            300 => [
                'code' => '5309',
                'provinsi_code' => '53',
                'name' => 'KAB. NGADA',
            ],
            301 => [
                'code' => '5310',
                'provinsi_code' => '53',
                'name' => 'KAB. MANGGARAI',
            ],
            302 => [
                'code' => '5311',
                'provinsi_code' => '53',
                'name' => 'KAB. SUMBA TIMUR',
            ],
            303 => [
                'code' => '5312',
                'provinsi_code' => '53',
                'name' => 'KAB. SUMBA BARAT',
            ],
            304 => [
                'code' => '5313',
                'provinsi_code' => '53',
                'name' => 'KAB. LEMBATA',
            ],
            305 => [
                'code' => '5314',
                'provinsi_code' => '53',
                'name' => 'KAB. ROTE NDAO',
            ],
            306 => [
                'code' => '5315',
                'provinsi_code' => '53',
                'name' => 'KAB. MANGGARAI BARAT',
            ],
            307 => [
                'code' => '5316',
                'provinsi_code' => '53',
                'name' => 'KAB. NAGEKEO',
            ],
            308 => [
                'code' => '5317',
                'provinsi_code' => '53',
                'name' => 'KAB. SUMBA TENGAH',
            ],
            309 => [
                'code' => '5318',
                'provinsi_code' => '53',
                'name' => 'KAB. SUMBA BARAT DAYA',
            ],
            310 => [
                'code' => '5319',
                'provinsi_code' => '53',
                'name' => 'KAB. MANGGARAI TIMUR',
            ],
            311 => [
                'code' => '5320',
                'provinsi_code' => '53',
                'name' => 'KAB. SABU RAIJUA',
            ],
            312 => [
                'code' => '5321',
                'provinsi_code' => '53',
                'name' => 'KAB. MALAKA',
            ],
            313 => [
                'code' => '5371',
                'provinsi_code' => '53',
                'name' => 'KOTA KUPANG',
            ],
            314 => [
                'code' => '6101',
                'provinsi_code' => '61',
                'name' => 'KAB. SAMBAS',
            ],
            315 => [
                'code' => '6102',
                'provinsi_code' => '61',
                'name' => 'KAB. MEMPAWAH',
            ],
            316 => [
                'code' => '6103',
                'provinsi_code' => '61',
                'name' => 'KAB. SANGGAU',
            ],
            317 => [
                'code' => '6104',
                'provinsi_code' => '61',
                'name' => 'KAB. KETAPANG',
            ],
            318 => [
                'code' => '6105',
                'provinsi_code' => '61',
                'name' => 'KAB. SINTANG',
            ],
            319 => [
                'code' => '6106',
                'provinsi_code' => '61',
                'name' => 'KAB. KAPUAS HULU',
            ],
            320 => [
                'code' => '6107',
                'provinsi_code' => '61',
                'name' => 'KAB. BENGKAYANG',
            ],
            321 => [
                'code' => '6108',
                'provinsi_code' => '61',
                'name' => 'KAB. LANDAK',
            ],
            322 => [
                'code' => '6109',
                'provinsi_code' => '61',
                'name' => 'KAB. SEKADAU',
            ],
            323 => [
                'code' => '6110',
                'provinsi_code' => '61',
                'name' => 'KAB. MELAWI',
            ],
            324 => [
                'code' => '6111',
                'provinsi_code' => '61',
                'name' => 'KAB. KAYONG UTARA',
            ],
            325 => [
                'code' => '6112',
                'provinsi_code' => '61',
                'name' => 'KAB. KUBU RAYA',
            ],
            326 => [
                'code' => '6171',
                'provinsi_code' => '61',
                'name' => 'KOTA PONTIANAK',
            ],
            327 => [
                'code' => '6172',
                'provinsi_code' => '61',
                'name' => 'KOTA SINGKAWANG',
            ],
            328 => [
                'code' => '6201',
                'provinsi_code' => '62',
                'name' => 'KAB. KOTAWARINGIN BARAT',
            ],
            329 => [
                'code' => '6202',
                'provinsi_code' => '62',
                'name' => 'KAB. KOTAWARINGIN TIMUR',
            ],
            330 => [
                'code' => '6203',
                'provinsi_code' => '62',
                'name' => 'KAB. KAPUAS',
            ],
            331 => [
                'code' => '6204',
                'provinsi_code' => '62',
                'name' => 'KAB. BARITO SELATAN',
            ],
            332 => [
                'code' => '6205',
                'provinsi_code' => '62',
                'name' => 'KAB. BARITO UTARA',
            ],
            333 => [
                'code' => '6206',
                'provinsi_code' => '62',
                'name' => 'KAB. KATINGAN',
            ],
            334 => [
                'code' => '6207',
                'provinsi_code' => '62',
                'name' => 'KAB. SERUYAN',
            ],
            335 => [
                'code' => '6208',
                'provinsi_code' => '62',
                'name' => 'KAB. SUKAMARA',
            ],
            336 => [
                'code' => '6209',
                'provinsi_code' => '62',
                'name' => 'KAB. LAMANDAU',
            ],
            337 => [
                'code' => '6210',
                'provinsi_code' => '62',
                'name' => 'KAB. GUNUNG MAS',
            ],
            338 => [
                'code' => '6211',
                'provinsi_code' => '62',
                'name' => 'KAB. PULANG PISAU',
            ],
            339 => [
                'code' => '6212',
                'provinsi_code' => '62',
                'name' => 'KAB. MURUNG RAYA',
            ],
            340 => [
                'code' => '6213',
                'provinsi_code' => '62',
                'name' => 'KAB. BARITO TIMUR',
            ],
            341 => [
                'code' => '6271',
                'provinsi_code' => '62',
                'name' => 'KOTA PALANGKARAYA',
            ],
            342 => [
                'code' => '6301',
                'provinsi_code' => '63',
                'name' => 'KAB. TANAH LAUT',
            ],
            343 => [
                'code' => '6302',
                'provinsi_code' => '63',
                'name' => 'KAB. KOTABARU',
            ],
            344 => [
                'code' => '6303',
                'provinsi_code' => '63',
                'name' => 'KAB. BANJAR',
            ],
            345 => [
                'code' => '6304',
                'provinsi_code' => '63',
                'name' => 'KAB. BARITO KUALA',
            ],
            346 => [
                'code' => '6305',
                'provinsi_code' => '63',
                'name' => 'KAB. TAPIN',
            ],
            347 => [
                'code' => '6306',
                'provinsi_code' => '63',
                'name' => 'KAB. HULU SUNGAI SELATAN',
            ],
            348 => [
                'code' => '6307',
                'provinsi_code' => '63',
                'name' => 'KAB. HULU SUNGAI TENGAH',
            ],
            349 => [
                'code' => '6308',
                'provinsi_code' => '63',
                'name' => 'KAB. HULU SUNGAI UTARA',
            ],
            350 => [
                'code' => '6309',
                'provinsi_code' => '63',
                'name' => 'KAB. TABALONG',
            ],
            351 => [
                'code' => '6310',
                'provinsi_code' => '63',
                'name' => 'KAB. TANAH BUMBU',
            ],
            352 => [
                'code' => '6311',
                'provinsi_code' => '63',
                'name' => 'KAB. BALANGAN',
            ],
            353 => [
                'code' => '6371',
                'provinsi_code' => '63',
                'name' => 'KOTA BANJARMASIN',
            ],
            354 => [
                'code' => '6372',
                'provinsi_code' => '63',
                'name' => 'KOTA BANJARBARU',
            ],
            355 => [
                'code' => '6401',
                'provinsi_code' => '64',
                'name' => 'KAB. PASER',
            ],
            356 => [
                'code' => '6402',
                'provinsi_code' => '64',
                'name' => 'KAB. KUTAI KARTANEGARA',
            ],
            357 => [
                'code' => '6403',
                'provinsi_code' => '64',
                'name' => 'KAB. BERAU',
            ],
            358 => [
                'code' => '6407',
                'provinsi_code' => '64',
                'name' => 'KAB. KUTAI BARAT',
            ],
            359 => [
                'code' => '6408',
                'provinsi_code' => '64',
                'name' => 'KAB. KUTAI TIMUR',
            ],
            360 => [
                'code' => '6409',
                'provinsi_code' => '64',
                'name' => 'KAB. PENAJAM PASER UTARA',
            ],
            361 => [
                'code' => '6411',
                'provinsi_code' => '64',
                'name' => 'KAB. MAHAKAM ULU',
            ],
            362 => [
                'code' => '6471',
                'provinsi_code' => '64',
                'name' => 'KOTA BALIKPAPAN',
            ],
            363 => [
                'code' => '6472',
                'provinsi_code' => '64',
                'name' => 'KOTA SAMARINDA',
            ],
            364 => [
                'code' => '6474',
                'provinsi_code' => '64',
                'name' => 'KOTA BONTANG',
            ],
            365 => [
                'code' => '6501',
                'provinsi_code' => '65',
                'name' => 'KAB. BULUNGAN',
            ],
            366 => [
                'code' => '6502',
                'provinsi_code' => '65',
                'name' => 'KAB. MALINAU',
            ],
            367 => [
                'code' => '6503',
                'provinsi_code' => '65',
                'name' => 'KAB. NUNUKAN',
            ],
            368 => [
                'code' => '6504',
                'provinsi_code' => '65',
                'name' => 'KAB. TANA TIDUNG',
            ],
            369 => [
                'code' => '6571',
                'provinsi_code' => '65',
                'name' => 'KOTA TARAKAN',
            ],
            370 => [
                'code' => '7101',
                'provinsi_code' => '71',
                'name' => 'KAB. BOLAANG MONGONDOW',
            ],
            371 => [
                'code' => '7102',
                'provinsi_code' => '71',
                'name' => 'KAB. MINAHASA',
            ],
            372 => [
                'code' => '7103',
                'provinsi_code' => '71',
                'name' => 'KAB. KEPULAUAN SANGIHE',
            ],
            373 => [
                'code' => '7104',
                'provinsi_code' => '71',
                'name' => 'KAB. KEPULAUAN TALAUD',
            ],
            374 => [
                'code' => '7105',
                'provinsi_code' => '71',
                'name' => 'KAB. MINAHASA SELATAN',
            ],
            375 => [
                'code' => '7106',
                'provinsi_code' => '71',
                'name' => 'KAB. MINAHASA UTARA',
            ],
            376 => [
                'code' => '7107',
                'provinsi_code' => '71',
                'name' => 'KAB. MINAHASA TENGGARA',
            ],
            377 => [
                'code' => '7108',
                'provinsi_code' => '71',
                'name' => 'KAB. BOLAANG MONGONDOW UTARA',
            ],
            378 => [
                'code' => '7109',
                'provinsi_code' => '71',
                'name' => 'KAB. KEP. SIAU TAGULANDANG BIARO',
            ],
            379 => [
                'code' => '7110',
                'provinsi_code' => '71',
                'name' => 'KAB. BOLAANG MONGONDOW TIMUR',
            ],
            380 => [
                'code' => '7111',
                'provinsi_code' => '71',
                'name' => 'KAB. BOLAANG MONGONDOW SELATAN',
            ],
            381 => [
                'code' => '7171',
                'provinsi_code' => '71',
                'name' => 'KOTA MANADO',
            ],
            382 => [
                'code' => '7172',
                'provinsi_code' => '71',
                'name' => 'KOTA BITUNG',
            ],
            383 => [
                'code' => '7173',
                'provinsi_code' => '71',
                'name' => 'KOTA TOMOHON',
            ],
            384 => [
                'code' => '7174',
                'provinsi_code' => '71',
                'name' => 'KOTA KOTAMOBAGU',
            ],
            385 => [
                'code' => '7201',
                'provinsi_code' => '72',
                'name' => 'KAB. BANGGAI',
            ],
            386 => [
                'code' => '7202',
                'provinsi_code' => '72',
                'name' => 'KAB. POSO',
            ],
            387 => [
                'code' => '7203',
                'provinsi_code' => '72',
                'name' => 'KAB. DONGGALA',
            ],
            388 => [
                'code' => '7204',
                'provinsi_code' => '72',
                'name' => 'KAB. TOLI TOLI',
            ],
            389 => [
                'code' => '7205',
                'provinsi_code' => '72',
                'name' => 'KAB. BUOL',
            ],
            390 => [
                'code' => '7206',
                'provinsi_code' => '72',
                'name' => 'KAB. MOROWALI',
            ],
            391 => [
                'code' => '7207',
                'provinsi_code' => '72',
                'name' => 'KAB. BANGGAI KEPULAUAN',
            ],
            392 => [
                'code' => '7208',
                'provinsi_code' => '72',
                'name' => 'KAB. PARIGI MOUTONG',
            ],
            393 => [
                'code' => '7209',
                'provinsi_code' => '72',
                'name' => 'KAB. TOJO UNA UNA',
            ],
            394 => [
                'code' => '7210',
                'provinsi_code' => '72',
                'name' => 'KAB. SIGI',
            ],
            395 => [
                'code' => '7211',
                'provinsi_code' => '72',
                'name' => 'KAB. BANGGAI LAUT',
            ],
            396 => [
                'code' => '7212',
                'provinsi_code' => '72',
                'name' => 'KAB. MOROWALI UTARA',
            ],
            397 => [
                'code' => '7271',
                'provinsi_code' => '72',
                'name' => 'KOTA PALU',
            ],
            398 => [
                'code' => '7301',
                'provinsi_code' => '73',
                'name' => 'KAB. KEPULAUAN SELAYAR',
            ],
            399 => [
                'code' => '7302',
                'provinsi_code' => '73',
                'name' => 'KAB. BULUKUMBA',
            ],
            400 => [
                'code' => '7303',
                'provinsi_code' => '73',
                'name' => 'KAB. BANTAENG',
            ],
            401 => [
                'code' => '7304',
                'provinsi_code' => '73',
                'name' => 'KAB. JENEPONTO',
            ],
            402 => [
                'code' => '7305',
                'provinsi_code' => '73',
                'name' => 'KAB. TAKALAR',
            ],
            403 => [
                'code' => '7306',
                'provinsi_code' => '73',
                'name' => 'KAB. GOWA',
            ],
            404 => [
                'code' => '7307',
                'provinsi_code' => '73',
                'name' => 'KAB. SINJAI',
            ],
            405 => [
                'code' => '7308',
                'provinsi_code' => '73',
                'name' => 'KAB. BONE',
            ],
            406 => [
                'code' => '7309',
                'provinsi_code' => '73',
                'name' => 'KAB. MAROS',
            ],
            407 => [
                'code' => '7310',
                'provinsi_code' => '73',
                'name' => 'KAB. PANGKAJENE KEPULAUAN',
            ],
            408 => [
                'code' => '7311',
                'provinsi_code' => '73',
                'name' => 'KAB. BARRU',
            ],
            409 => [
                'code' => '7312',
                'provinsi_code' => '73',
                'name' => 'KAB. SOPPENG',
            ],
            410 => [
                'code' => '7313',
                'provinsi_code' => '73',
                'name' => 'KAB. WAJO',
            ],
            411 => [
                'code' => '7314',
                'provinsi_code' => '73',
                'name' => 'KAB. SIDENRENG RAPPANG',
            ],
            412 => [
                'code' => '7315',
                'provinsi_code' => '73',
                'name' => 'KAB. PINRANG',
            ],
            413 => [
                'code' => '7316',
                'provinsi_code' => '73',
                'name' => 'KAB. ENREKANG',
            ],
            414 => [
                'code' => '7317',
                'provinsi_code' => '73',
                'name' => 'KAB. LUWU',
            ],
            415 => [
                'code' => '7318',
                'provinsi_code' => '73',
                'name' => 'KAB. TANA TORAJA',
            ],
            416 => [
                'code' => '7322',
                'provinsi_code' => '73',
                'name' => 'KAB. LUWU UTARA',
            ],
            417 => [
                'code' => '7324',
                'provinsi_code' => '73',
                'name' => 'KAB. LUWU TIMUR',
            ],
            418 => [
                'code' => '7326',
                'provinsi_code' => '73',
                'name' => 'KAB. TORAJA UTARA',
            ],
            419 => [
                'code' => '7371',
                'provinsi_code' => '73',
                'name' => 'KOTA MAKASSAR',
            ],
            420 => [
                'code' => '7372',
                'provinsi_code' => '73',
                'name' => 'KOTA PARE PARE',
            ],
            421 => [
                'code' => '7373',
                'provinsi_code' => '73',
                'name' => 'KOTA PALOPO',
            ],
            422 => [
                'code' => '7401',
                'provinsi_code' => '74',
                'name' => 'KAB. KOLAKA',
            ],
            423 => [
                'code' => '7402',
                'provinsi_code' => '74',
                'name' => 'KAB. KONAWE',
            ],
            424 => [
                'code' => '7403',
                'provinsi_code' => '74',
                'name' => 'KAB. MUNA',
            ],
            425 => [
                'code' => '7404',
                'provinsi_code' => '74',
                'name' => 'KAB. BUTON',
            ],
            426 => [
                'code' => '7405',
                'provinsi_code' => '74',
                'name' => 'KAB. KONAWE SELATAN',
            ],
            427 => [
                'code' => '7406',
                'provinsi_code' => '74',
                'name' => 'KAB. BOMBANA',
            ],
            428 => [
                'code' => '7407',
                'provinsi_code' => '74',
                'name' => 'KAB. WAKATOBI',
            ],
            429 => [
                'code' => '7408',
                'provinsi_code' => '74',
                'name' => 'KAB. KOLAKA UTARA',
            ],
            430 => [
                'code' => '7409',
                'provinsi_code' => '74',
                'name' => 'KAB. KONAWE UTARA',
            ],
            431 => [
                'code' => '7410',
                'provinsi_code' => '74',
                'name' => 'KAB. BUTON UTARA',
            ],
            432 => [
                'code' => '7411',
                'provinsi_code' => '74',
                'name' => 'KAB. KOLAKA TIMUR',
            ],
            433 => [
                'code' => '7412',
                'provinsi_code' => '74',
                'name' => 'KAB. KONAWE KEPULAUAN',
            ],
            434 => [
                'code' => '7413',
                'provinsi_code' => '74',
                'name' => 'KAB. MUNA BARAT',
            ],
            435 => [
                'code' => '7414',
                'provinsi_code' => '74',
                'name' => 'KAB. BUTON TENGAH',
            ],
            436 => [
                'code' => '7415',
                'provinsi_code' => '74',
                'name' => 'KAB. BUTON SELATAN',
            ],
            437 => [
                'code' => '7471',
                'provinsi_code' => '74',
                'name' => 'KOTA KENDARI',
            ],
            438 => [
                'code' => '7472',
                'provinsi_code' => '74',
                'name' => 'KOTA BAU BAU',
            ],
            439 => [
                'code' => '7501',
                'provinsi_code' => '75',
                'name' => 'KAB. GORONTALO',
            ],
            440 => [
                'code' => '7502',
                'provinsi_code' => '75',
                'name' => 'KAB. BOALEMO',
            ],
            441 => [
                'code' => '7503',
                'provinsi_code' => '75',
                'name' => 'KAB. BONE BOLANGO',
            ],
            442 => [
                'code' => '7504',
                'provinsi_code' => '75',
                'name' => 'KAB. PAHUWATO',
            ],
            443 => [
                'code' => '7505',
                'provinsi_code' => '75',
                'name' => 'KAB. GORONTALO UTARA',
            ],
            444 => [
                'code' => '7571',
                'provinsi_code' => '75',
                'name' => 'KOTA GORONTALO',
            ],
            445 => [
                'code' => '7601',
                'provinsi_code' => '76',
                'name' => 'KAB. PASANGKAYU',
            ],
            446 => [
                'code' => '7602',
                'provinsi_code' => '76',
                'name' => 'KAB. MAMUJU',
            ],
            447 => [
                'code' => '7603',
                'provinsi_code' => '76',
                'name' => 'KAB. MAMASA',
            ],
            448 => [
                'code' => '7604',
                'provinsi_code' => '76',
                'name' => 'KAB. POLEWALI MANDAR',
            ],
            449 => [
                'code' => '7605',
                'provinsi_code' => '76',
                'name' => 'KAB. MAJENE',
            ],
            450 => [
                'code' => '7606',
                'provinsi_code' => '76',
                'name' => 'KAB. MAMUJU TENGAH',
            ],
            451 => [
                'code' => '8101',
                'provinsi_code' => '81',
                'name' => 'KAB. MALUKU TENGAH',
            ],
            452 => [
                'code' => '8102',
                'provinsi_code' => '81',
                'name' => 'KAB. MALUKU TENGGARA',
            ],
            453 => [
                'code' => '8103',
                'provinsi_code' => '81',
                'name' => 'KAB. KEPULAUAN TANIMBAR',
            ],
            454 => [
                'code' => '8104',
                'provinsi_code' => '81',
                'name' => 'KAB. BURU',
            ],
            455 => [
                'code' => '8105',
                'provinsi_code' => '81',
                'name' => 'KAB. SERAM BAGIAN TIMUR',
            ],
            456 => [
                'code' => '8106',
                'provinsi_code' => '81',
                'name' => 'KAB. SERAM BAGIAN BARAT',
            ],
            457 => [
                'code' => '8107',
                'provinsi_code' => '81',
                'name' => 'KAB. KEPULAUAN ARU',
            ],
            458 => [
                'code' => '8108',
                'provinsi_code' => '81',
                'name' => 'KAB. MALUKU BARAT DAYA',
            ],
            459 => [
                'code' => '8109',
                'provinsi_code' => '81',
                'name' => 'KAB. BURU SELATAN',
            ],
            460 => [
                'code' => '8171',
                'provinsi_code' => '81',
                'name' => 'KOTA AMBON',
            ],
            461 => [
                'code' => '8172',
                'provinsi_code' => '81',
                'name' => 'KOTA TUAL',
            ],
            462 => [
                'code' => '8201',
                'provinsi_code' => '82',
                'name' => 'KAB. HALMAHERA BARAT',
            ],
            463 => [
                'code' => '8202',
                'provinsi_code' => '82',
                'name' => 'KAB. HALMAHERA TENGAH',
            ],
            464 => [
                'code' => '8203',
                'provinsi_code' => '82',
                'name' => 'KAB. HALMAHERA UTARA',
            ],
            465 => [
                'code' => '8204',
                'provinsi_code' => '82',
                'name' => 'KAB. HALMAHERA SELATAN',
            ],
            466 => [
                'code' => '8205',
                'provinsi_code' => '82',
                'name' => 'KAB. KEPULAUAN SULA',
            ],
            467 => [
                'code' => '8206',
                'provinsi_code' => '82',
                'name' => 'KAB. HALMAHERA TIMUR',
            ],
            468 => [
                'code' => '8207',
                'provinsi_code' => '82',
                'name' => 'KAB. PULAU MOROTAI',
            ],
            469 => [
                'code' => '8208',
                'provinsi_code' => '82',
                'name' => 'KAB. PULAU TALIABU',
            ],
            470 => [
                'code' => '8271',
                'provinsi_code' => '82',
                'name' => 'KOTA TERNATE',
            ],
            471 => [
                'code' => '8272',
                'provinsi_code' => '82',
                'name' => 'KOTA TIDORE KEPULAUAN',
            ],
            472 => [
                'code' => '9103',
                'provinsi_code' => '91',
                'name' => 'KAB. JAYAPURA',
            ],
            473 => [
                'code' => '9105',
                'provinsi_code' => '91',
                'name' => 'KAB. KEPULAUAN YAPEN',
            ],
            474 => [
                'code' => '9106',
                'provinsi_code' => '91',
                'name' => 'KAB. BIAK NUMFOR',
            ],
            475 => [
                'code' => '9110',
                'provinsi_code' => '91',
                'name' => 'KAB. SARMI',
            ],
            476 => [
                'code' => '9111',
                'provinsi_code' => '91',
                'name' => 'KAB. KEEROM',
            ],
            477 => [
                'code' => '9115',
                'provinsi_code' => '91',
                'name' => 'KAB. WAROPEN',
            ],
            478 => [
                'code' => '9119',
                'provinsi_code' => '91',
                'name' => 'KAB. SUPIORI',
            ],
            479 => [
                'code' => '9120',
                'provinsi_code' => '91',
                'name' => 'KAB. MAMBERAMO RAYA',
            ],
            480 => [
                'code' => '9171',
                'provinsi_code' => '91',
                'name' => 'KOTA JAYAPURA',
            ],
            481 => [
                'code' => '9201',
                'provinsi_code' => '92',
                'name' => 'KAB. SORONG',
            ],
            482 => [
                'code' => '9202',
                'provinsi_code' => '92',
                'name' => 'KAB. MANOKWARI',
            ],
            483 => [
                'code' => '9203',
                'provinsi_code' => '92',
                'name' => 'KAB. FAK FAK',
            ],
            484 => [
                'code' => '9204',
                'provinsi_code' => '92',
                'name' => 'KAB. SORONG SELATAN',
            ],
            485 => [
                'code' => '9205',
                'provinsi_code' => '92',
                'name' => 'KAB. RAJA AMPAT',
            ],
            486 => [
                'code' => '9206',
                'provinsi_code' => '92',
                'name' => 'KAB. TELUK BINTUNI',
            ],
            487 => [
                'code' => '9207',
                'provinsi_code' => '92',
                'name' => 'KAB. TELUK WONDAMA',
            ],
            488 => [
                'code' => '9208',
                'provinsi_code' => '92',
                'name' => 'KAB. KAIMANA',
            ],
            489 => [
                'code' => '9209',
                'provinsi_code' => '92',
                'name' => 'KAB. TAMBRAUW',
            ],
            490 => [
                'code' => '9210',
                'provinsi_code' => '92',
                'name' => 'KAB. MAYBRAT',
            ],
            491 => [
                'code' => '9211',
                'provinsi_code' => '92',
                'name' => 'KAB. MANOKWARI SELATAN',
            ],
            492 => [
                'code' => '9212',
                'provinsi_code' => '92',
                'name' => 'KAB. PEGUNUNGAN ARFAK',
            ],
            493 => [
                'code' => '9271',
                'provinsi_code' => '92',
                'name' => 'KOTA SORONG',
            ],
            494 => [
                'code' => '9301',
                'provinsi_code' => '93',
                'name' => 'KAB. MERAUKE',
            ],
            495 => [
                'code' => '9302',
                'provinsi_code' => '93',
                'name' => 'KAB. BOVEN DIGOEL',
            ],
            496 => [
                'code' => '9303',
                'provinsi_code' => '93',
                'name' => 'KAB. MAPPI',
            ],
            497 => [
                'code' => '9304',
                'provinsi_code' => '93',
                'name' => 'KAB. ASMAT',
            ],
            498 => [
                'code' => '9401',
                'provinsi_code' => '94',
                'name' => 'KAB. NABIRE',
            ],
            499 => [
                'code' => '9402',
                'provinsi_code' => '94',
                'name' => 'KAB. PUNCAK JAYA',
            ],
        ]);
        \DB::table('kabupaten')->insert([
            0 => [
                'code' => '9403',
                'provinsi_code' => '94',
                'name' => 'KAB. PANIAI',
            ],
            1 => [
                'code' => '9404',
                'provinsi_code' => '94',
                'name' => 'KAB. MIMIKA',
            ],
            2 => [
                'code' => '9405',
                'provinsi_code' => '94',
                'name' => 'KAB. PUNCAK',
            ],
            3 => [
                'code' => '9406',
                'provinsi_code' => '94',
                'name' => 'KAB. DOGIYAI',
            ],
            4 => [
                'code' => '9407',
                'provinsi_code' => '94',
                'name' => 'KAB. INTAN JAYA',
            ],
            5 => [
                'code' => '9408',
                'provinsi_code' => '94',
                'name' => 'KAB. DEIYAI',
            ],
            6 => [
                'code' => '9501',
                'provinsi_code' => '95',
                'name' => 'KAB. JAYAWIJAYA',
            ],
            7 => [
                'code' => '9502',
                'provinsi_code' => '95',
                'name' => 'KAB. PEGUNUNGAN BINTANG',
            ],
            8 => [
                'code' => '9503',
                'provinsi_code' => '95',
                'name' => 'KAB. YAHUKIMO',
            ],
            9 => [
                'code' => '9504',
                'provinsi_code' => '95',
                'name' => 'KAB. TOLIKARA',
            ],
            10 => [
                'code' => '9505',
                'provinsi_code' => '95',
                'name' => 'KAB. MAMBERAMO TENGAH',
            ],
            11 => [
                'code' => '9506',
                'provinsi_code' => '95',
                'name' => 'KAB. YALIMO',
            ],
            12 => [
                'code' => '9507',
                'provinsi_code' => '95',
                'name' => 'KAB. LANNY JAYA',
            ],
            13 => [
                'code' => '9508',
                'provinsi_code' => '95',
                'name' => 'KAB. NDUGA',
            ],
        ]);

    }
}
