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

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->_httpClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->baseUri,
            'timeout'  => $this->timeout,
            'debug'    => $this->debug,
        ]);
    }

    /**
     * Get list of users
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList()
    {
        return $this->getResponse('GET', '/users');
    }

    /**
     * Get details of a single user
     *
     * @param $id
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSingle($id)
    {
        return $this->getResponse('GET', sprintf('/users/%s', $id));
    }

    /**
     * Get remote response with 120 seconds cache
     *
     * @param $method
     * @param string $uri
     * @param null $options
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getResponse($method, $uri = '', $options = [])
    {
        $cacheKey = md5(json_encode([
            'caller'  => 'getResponse',
            'baseUri' => $this->baseUri,
            'method'  => $method,
            'uri'     => $uri,
            'options' => $options,
        ]));
        if (empty($result = get_transient($cacheKey))) {
            $response = $this->_httpClient->request($method, $uri, $options);
            if ((200 === $response->getStatusCode())) {
                $result = json_decode($response->getBody()->getContents(), true);
                set_transient($cacheKey, $result, 120);
            }
        }

        return $result;
    }
}
