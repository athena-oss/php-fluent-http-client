<?php

namespace OLX\FluentHttpClient;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var HttpClient */
    private $httpClient;

    public function setUp()
    {
        $this->httpClient = new HttpClient();
    }

    public function testGetMethodIsCalledShouldReturnFluentRequestWithHTTPGetMethod()
    {
        $requestObj = $this->httpClient->get('http://www.olx.com');

        $this->assertAttributeEquals('GET', 'method', $requestObj);
        $this->assertAttributeEquals('http://www.olx.com', 'uri', $requestObj);
    }

    public function testPostMethodIsCalledShouldReturnFluentRequestWithHTTPPostMethod()
    {
        $requestObj = $this->httpClient->post('http://www.olx.com');

        $this->assertAttributeEquals('POST', 'method', $requestObj);
        $this->assertAttributeEquals('http://www.olx.com', 'uri', $requestObj);
    }

    public function testPutMethodIsCalledShouldReturnFluentRequestWithHTTPPutMethod()
    {
        $requestObj = $this->httpClient->put('http://www.olx.com');

        $this->assertAttributeEquals('PUT', 'method', $requestObj);
        $this->assertAttributeEquals('http://www.olx.com', 'uri', $requestObj);
    }

    public function testDeleteMethodIsCalledShouldReturnFluentRequestWithHTTPDeleteMethod()
    {
        $requestObj = $this->httpClient->delete('http://www.olx.com');

        $this->assertAttributeEquals('DELETE', 'method', $requestObj);
        $this->assertAttributeEquals('http://www.olx.com', 'uri', $requestObj);
    }
}
