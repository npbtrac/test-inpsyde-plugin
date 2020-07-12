<?php


namespace TestInpsyde\Wp\Plugin\Helpers;


use GuzzleHttp\Client;

class RemoteJsonHelper {
    public function getList($remoteUrl) {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://jsonplaceholder.typicode.com/users/',
            // Timeout to 7.7 seconds
            'timeout'  => 7.7,
            'debug' => WP_DEBUG ?? false,
        ]);
    }
}
