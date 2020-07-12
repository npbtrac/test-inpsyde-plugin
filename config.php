<?php

use TestInpsyde\Wp\Plugin\Services\PageRendererService;
use TestInpsyde\Wp\Plugin\Services\ViewService;

$textDomain = 'inpsyde';

return [
    'version'    => '0.0.2',
    'basePath'   => __DIR__,
    'baseUrl'    => plugins_url(null, __FILE__),
    'textDomain' => $textDomain,
    'services'   => [
        ViewService::class         => [
            'text_domain' => $textDomain,
        ],
        PageRendererService::class => [
            'text_domain' => $textDomain,
        ],
    ],
];
