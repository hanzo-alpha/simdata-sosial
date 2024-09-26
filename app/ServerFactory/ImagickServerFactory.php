<?php

declare(strict_types=1);

namespace App\ServerFactory;

use Awcodes\Curator\Glide\Contracts\ServerFactory;
use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\Server;
use League\Glide\ServerFactory as GlideServerFactory;

class ImagickServerFactory implements ServerFactory
{
    public function getFactory(): GlideServerFactory|Server
    {
        return GlideServerFactory::create([
            'driver' => 'imagick',
            'response' => new SymfonyResponseFactory(app('request')),
            'source' => storage_path('app'),
            'source_path_prefix' => 'public',
            'cache' => storage_path('app'),
            'cache_path_prefix' => '.cache',
            'max_image_size' => 2000 * 2000,
        ]);
    }
}
