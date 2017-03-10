<?php
namespace OLX\FluentHttpClient\Request;

use OLX\FluentHttpClient\Exception\UnsupportedOperationException;
use GuzzleHttp\Client;

class RequestExecutor
{
    private $httpClient;
    private $options;
    private $uri;
    private $method;

    /**
     * RequestExecutor constructor.
     * @param $method
     * @param string $uri
     * @param array $options
     * @param Client $httpClient
     */
    public function __construct($method, $uri, array $options, $httpClient = null)
    {
        $this->method     = strtoupper($method);
        $this->uri        = $uri;
        $this->options    = $options;
        $this->httpClient = $httpClient;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function __invoke()
    {
        return $this->execute();
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface|null
     * @throws UnsupportedOperationException
     */
    public function execute()
    {
        $requestResponse = null;
        switch ($this->method) {
            case 'GET':
                $requestResponse = $this->getClient()->get($this->uri, $this->options);
                break;
            case 'POST':
                $requestResponse = $this->getClient()->post($this->uri, $this->options);
                break;
            case 'PUT':
                $requestResponse = $this->getClient()->put($this->uri, $this->options);
                break;
            case 'PATCH':
                $requestResponse = $this->getClient()->patch($this->uri, $this->options);
                break;
            case 'DELETE':
                $requestResponse = $this->getClient()->delete($this->uri, $this->options);
                break;
            case 'HEAD':
                $requestResponse = $this->getClient()->head($this->uri, $this->options);
                break;
            default:
                throw new UnsupportedOperationException(sprintf('HTTP METHOD [%s] is not supported.', $this->method));
        }

        return $requestResponse;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return Client
     * @codeCoverageIgnore
     */
    protected function getClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new Client();
        }
        return $this->httpClient;
    }
}
