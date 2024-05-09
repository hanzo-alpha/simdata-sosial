<?php

declare(strict_types=1);

return [
    'shield_resource' => [
        'should_register_navigation' => true,
        'slug' => 'peran',
        'navigation_sort' => -1,
        'navigation_badge' => false,
        'navigation_group' => true,
        'is_globally_searchable' => false,
        'show_model_path' => true,
    ],

    'auth_provider_model' => [
        'fqcn' => 'App\\Models\\User',
    ],

    'super_admin' => [
        'enabled' => true,
        'name' => 'super_admin',
        'define_via_gate' => true,
        'intercept_gate' => 'before', // after
    ],

    'panel_user' => [
        'enabled' => true,
        'name' => 'operator',
    ],

    'permission_prefixes' => [
        'resource' => [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'restore',
            'force_delete',
            'download',
            'upload',
            'change_status',
        ],

        'page' => 'page',
        'widget' => 'widget',
    ],

    'entities' => [
        'pages' => true,
        'widgets' => true,
        'resources' => true,
        'custom_permissions' => true,
    ],

    'generator' => [
        'option' => 'policies_and_permissions',
    ],

    'exclude' => [
        'enabled' => true,

        'pages' => [
            'Dashboard',
            'MyProfilePage',
        ],

        'widgets' => [
            'AccountWidget',
            'FilamentInfoWidget',
            'BantuanOverview',
            'BantuanSosialPerKecamatanChart',
        ],

        'resources' => [],
    ],

    'discovery' => [
        'discover_all_resources' => false,
        'discover_all_widgets' => false,
        'discover_all_pages' => false,
    ],

    'register_role_policy' => [
        'enabled' => true,
    ],

];
