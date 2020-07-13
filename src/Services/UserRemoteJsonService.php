<?php


namespace TestInpsyde\Wp\Plugin\Services;

use GuzzleHttp\Client;
use TestInpsyde\Wp\Plugin\Traits\ConfigTrait;
use TestInpsyde\Wp\Plugin\Traits\ServiceTrait;
use TestInpsyde\Wp\Plugin\Traits\WPAttributeTrait;

class UserRemoteJsonService
{
    use ConfigTrait;
    use WPAttributeTrait;
    use ServiceTrait;

    public $baseUri;
    public $timeout;
    public $debug;

    /**
     * @var Client
     */
    protected $_httpClient;

    public function init()
    {
        $this->_httpClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->baseUri,
            'timeout'  => $this->timeout,
            'debug'    => $this->debug,
        ]);
    }

    public function getList()
    {
        $response = $this->_httpClient->request('GET', '/users');

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getSingle($id)
    {
        $response = $this->_httpClient->request('GET', sprintf('/users/%s', $id));

        return json_decode($response->getBody()->getContents(), true);
    }
}
