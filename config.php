<?php

use TestInpsyde\Wp\Plugin\Services\PageRendererService;
use TestInpsyde\Wp\Plugin\Services\UserRemoteJsonService;
use TestInpsyde\Wp\Plugin\Services\ViewService;

$textDomain = 'inpsyde';

return [
    'version'    => '0.1.0',
    'basePath'   => __DIR__,
    'baseUrl'    => plugins_url(null, __FILE__),
    'textDomain' => $textDomain,
    'services'   => [
        ViewService::class         => [
        ],
        PageRendererService::class => [
            'textDomain' => $textDomain,
        ],
        UserRemoteJsonService::class         => [
            'baseUri' => 'https://jsonplaceholder.typicode.com',
            'timeout' => 7.7,
            'debug' => false,
        ],
    ],
];
