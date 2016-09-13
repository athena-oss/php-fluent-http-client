<?php
namespace OLX\FluentHttpClient\Request;

use OLX\FluentHttpClient\Response\Response;
use OLX\FluentHttpClient\Response\ResponseInterface;
use OLX\FluentHttpClient\Exception\UnsupportedOperationException;
use OLX\FluentHttpClient\Holder\ClosureHolder;
use GuzzleHttp\Client;

class FluentRequest implements FluentRequestInterface
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $options;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var array
     */
    private $formParams;

    /**
     * FluentRequest constructor.
     * @param $method
     * @param $uri
     * @param null $httpClient
     */
    public function __construct($method, $uri, $httpClient = null)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->httpClient = $httpClient;
        $this->options = [
            'headers' => [],
            'query' => []
        ];
        $this->formParams = [];
    }

    /**
     * @param string|array $content
     * @param $contentType
     * @return $this
     * @throws UnsupportedOperationException
     */
    public function withBody($content, $contentType)
    {
        if (in_array($this->method, ['GET', 'HEAD'])) {
            throw new UnsupportedOperationException('This HTTP Method MUST NOT have a BODY');
        }

        $this->handleBody($content, $contentType);
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function withHeader($name, $value)
    {
        $this->options['headers'][$name] = $value;
        return $this;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function withQueryParameters(array $parameters)
    {
        foreach ($parameters as $param => $value) {
            $this->withQueryParameter($param, $value);
        }
        return $this;
    }

    /**
     * @param $param
     * @param $value
     * @return $this
     */
    public function withQueryParameter($param, $value)
    {
        $this->options['query'][$param] = $value;
        return $this;
    }

    /**
     * @param array $parameters
     * @return $this
     * @throws UnsupportedOperationException
     */
    public function withFormParameters(array $parameters)
    {
        foreach ($parameters as $param => $value) {
            $this->withFormParameter($param, $value);
        }
        return $this;
    }

    /**
     * @param $param
     * @param $value
     * @return $this
     * @throws UnsupportedOperationException
     */
    public function withFormParameter($param, $value)
    {
        if (in_array($this->method, ['GET', 'HEAD'])) {
            throw new UnsupportedOperationException('This HTTP Method MUST NOT have a BODY');
        }

        $this->formParams[$param] = $value;
        return $this;
    }

    /**
     * @param $username
     * @param $password
     * @return $this
     */
    public function withBasicAuth($username, $password)
    {
        $this->options['auth'] = [$username, $password, 'Basic'];
        return $this;
    }

    /**
     * @param $username
     * @param $password
     * @return $this
     */
    public function withDigestAuth($username, $password)
    {
        $this->options['auth'] = [$username, $password, 'Digest'];
        return $this;
    }

    /**
     * @param $token
     * @return $this
     */
    public function withOAuth($token)
    {
        $this->withHeader("Authorization", "Bearer $token");
        return $this;
    }

    /**
     * @param $userAgentString
     * @return $this
     */
    public function withUserAgent($userAgentString)
    {
        $this->options['headers']['User-Agent'] = $userAgentString;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function withOption($name, $value)
    {
        $this->options[$name] = $value;
        return $this;
    }

    /**
     * @param string $url
     * @param int $port
     * @return $this
     */
    public function withProxy($url, $port)
    {
        $this->options['proxy'] = sprintf('tcp://%s:%d', $url, $port);
        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function then()
    {
        if (!empty($this->formParams)) {
            $this->handleBody($this->formParams, "application/x-www-form-urlencoded");
        }

        $requestExecutor = new RequestExecutor($this->method, $this->uri, $this->options, $this->httpClient);
        return new Response(new ClosureHolder($requestExecutor));
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->options['headers'];
    }

    public function getQueryParams()
    {
        return $this->options['query'];
    }

    /**
     * @return mixed
     */
    public function getFormParams()
    {
        return $this->formParams;
    }
    
    /**
     * @param string|array $content
     * @param $contentType
     */
    private function handleBody($content, $contentType)
    {
        if (is_array($content)) {
            $content = http_build_query($content);
            $contentType = "application/x-www-form-urlencoded";
        }

        $this->options['body'] = $content;
        $this->options['headers']['Content-Type'] = $contentType;
    }
}
