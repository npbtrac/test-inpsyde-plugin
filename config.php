<?php

use TestInpsyde\Wp\Plugin\Services\ViewService;

$textDomain = 'inpsyde';

return [
    'basePath'   => __DIR__,
    'baseUrl'    => plugins_url(null, __FILE__),
    'textDomain' => $textDomain,
    'services'    => [
        ViewService::class => [
            'text_domain' => $textDomain,
        ],
    ],
];
