<?php
namespace OLX\FluentHttpClient;

use GuzzleHttp\Client;
use OLX\FluentHttpClient\Request\FluentRequest;
use OLX\FluentHttpClient\Request\FluentRequestInterface;

class HttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * HttpClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client;
    }


    /**
     * @param $uri
     * @return FluentRequestInterface
     */
    public function get($uri)
    {
        return new FluentRequest('GET', $uri, $this->client);
    }

    /**
     * @param $uri
     * @return FluentRequestInterface
     */
    public function post($uri)
    {
        return new FluentRequest('POST', $uri, $this->client);
    }

    /**
     * @param $uri
     * @return FluentRequestInterface
     */
    public function put($uri)
    {
        return new FluentRequest('PUT', $uri, $this->client);
    }

    /**
     * @param $uri
     * @return FluentRequestInterface
     */
    public function patch($uri)
    {
        return new FluentRequest('PATCH', $uri, $this->client);
    }

    /**
     * @param $uri
     * @return FluentRequestInterface
     */
    public function delete($uri)
    {
        return new FluentRequest('DELETE', $uri, $this->client);
    }
    
    /**
     * @param $uri
     * @return FluentRequestInterface
     */
    public function head($uri)
    {
        return new FluentRequest('HEAD', $uri, $this->client);
    }
}
