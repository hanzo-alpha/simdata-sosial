<?php

return [
    'tabs' => [
        'general' => 'Umum',
        'styling' => 'Gaya',
        'scheduling' => 'Penjadwalan',
    ],
    'fields' => [
        'id' => 'ID',
        'name' => 'Nama',
        'content' => 'Isi',
        'render_location' => 'Render Lokasi',
        'render_location_help' => 'Dengan lokasi render, Anda dapat memilih di mana spanduk dirender pada halaman. Dikombinasikan dengan cakupan, ini menjadi alat yang ampuh untuk mengelola di mana dan kapan spanduk Anda ditampilkan. Anda dapat memilih untuk merender spanduk di header, sidebar, atau lokasi strategis lainnya untuk memaksimalkan visibilitas dan dampaknya.',
        'render_location_options' => [
            'panel' => [
                'header' => 'Header',
                'page_start' => 'Awal Halaman',
                'page_end' => 'Akhir Halaman',
            ],
            'authentication' => [
                'login_form_before' => 'Sebelum Form Login',
                'login_form_after' => 'Sesudah Form Login',
                'password_reset_form_before' => 'Sebelum formulir reset kata sandi',
                'password_reset_form_after' => 'Setelah formulir reset kata sandi',
                'register_form_before' => 'Sebelum Form Registrasi',
                'register_form_after' => 'Sesudah Form Registrasi',
            ],
            'global_search' => [
                'before' => 'Sebelum pencarian global',
                'after' => 'Setelah pencarian global',
            ],
            'page_widgets' => [
                'header_before' => 'Sebelum widget header',
                'header_after' => 'Setelah widget header',
                'footer_before' => 'Sebelum widget footer',
                'footer_after' => 'Setelah widget footer',
            ],
            'sidebar' => [
                'nav_start' => 'Sebelum navigasi bilah sisi',
                'nav_end' => 'Setelah navigasi bilah sisi',
            ],
            'resource_table' => [
                'before' => 'Sebelum tabel sumber daya',
                'after' => 'Setelah tabel sumber daya',
            ],
        ],
        'scope' => 'Cakupan',
        'scope_help' => 'Dengan pelingkupan, Anda dapat mengontrol di mana spanduk Anda ditampilkan. Anda dapat menargetkan spanduk Anda ke halaman tertentu atau seluruh sumber daya, memastikannya ditampilkan kepada audiens yang tepat pada waktu yang tepat.',
        'options' => 'Pilihan',
        'can_be_closed_by_user' => 'Spanduk dapat ditutup oleh pengguna',
        'can_truncate_message' => 'Memotong konten spanduk',
        'is_active' => 'Aktif',
        'text_color' => 'Warna Teks',
        'icon' => 'Ikon',
        'icon_color' => 'Warna Ikon',
        'background' => 'Latar belakang',
        'background_type' => 'Jenis Latar Belakang',
        'background_type_solid' => 'Solid',
        'background_type_gradient' => 'Gradient',
        'start_color' => 'Warna Awal',
        'end_color' => 'Warna Akhir',
        'start_time' => 'Waktu Mulai',
        'start_time_reset' => 'Atur Ulang Waktu Mulai',
        'end_time' => 'Waktu Akhir',
        'end_time_reset' => 'Atur Ulang Waktu Akhir',
    ],
    'badges' => [
        'scheduling_status' => [
            'active' => 'Aktif',
            'scheduled' => 'Dijadwalkan',
            'expired' => 'Kedaluwarsa',
        ],
    ],
    'actions' => [
        'help' => 'Bantuan',
        'reset' => 'Atur Ulang',
    ],
];
