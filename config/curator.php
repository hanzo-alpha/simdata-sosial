<?php

declare(strict_types=1);

use App\ServerFactory\ImagickServerFactory;
use Awcodes\Curator\PathGenerators\UserPathGenerator;

return [
    'accepted_file_types' => [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/svg+xml',
        'application/pdf',
        'application/vnd.ms-excel',
        'application/x-msexcel',
        'application/xls',
    ],
    'cloud_disks' => [
        's3',
        'cloudinary',
        'imgix',
    ],
    'curation_formats' => [
        'jpg',
        'jpeg',
        'webp',
        'png',
        'avif',
    ],
    'tabs' => [
        'display_curation' => false,
        'display_upload_new' => true,
    ],
    'curation_presets' => [
        Awcodes\Curator\Curations\ThumbnailPreset::class,
    ],
    'directory' => 'media',
    'disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
    'glide' => [
        //        'server' => Awcodes\Curator\Glide\DefaultServerFactory::class,
        'server' => ImagickServerFactory::class,
        'fallbacks' => [],
        'route_path' => 'storage',
    ],
    'image_crop_aspect_ratio' => null,
    'image_resize_mode' => null,
    'image_resize_target_height' => null,
    'image_resize_target_width' => null,
    'is_limited_to_directory' => false,
    'max_size' => 5000,
    'model' => Awcodes\Curator\Models\Media::class,
    'min_size' => 0,
    'path_generator' => UserPathGenerator::class,
    'resources' => [
        'label' => 'Media',
        'plural_label' => 'Media',
        'navigation_group' => null,
        'navigation_icon' => 'heroicon-o-photo',
        'navigation_sort' => null,
        'navigation_count_badge' => false,
        'resource' => Awcodes\Curator\Resources\MediaResource::class,
    ],
    'should_preserve_filenames' => false,
    'should_register_navigation' => true,
    'visibility' => 'public',
];
