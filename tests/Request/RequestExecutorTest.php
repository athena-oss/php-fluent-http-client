<?php

namespace OLX\FluentHttpClient;

use OLX\FluentHttpClient\Exception\UnsupportedOperationException;
use GuzzleHttp\Client;

class RequestExecutorTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteGivenHTTPMethodIsGET()
    {
        $executor = $this->makeRequestExecutorFor('GET');

        $this->assertEquals('get', $executor());
    }

    public function testExecuteGivenHTTPMethodIsPOST()
    {
        $executor = $this->makeRequestExecutorFor('POST');

        $this->assertEquals('post', $executor());
    }

    public function testExecuteGivenHTTPMethodIsPUT()
    {
        $executor = $this->makeRequestExecutorFor('PUT');

        $this->assertEquals('put', $executor());
    }

    public function testExecuteGivenHTTPMethodIsDELETE()
    {
        $executor = $this->makeRequestExecutorFor('DELETE');

        $this->assertEquals('delete', $executor());
    }

    public function testExecuteGivenHTTPMethodIsNotSupported()
    {
        $this->setExpectedException(UnsupportedOperationException::class);
        $executor = $this->makeRequestExecutorFor('SOMERANDOMMETHOD');
        $executor();
    }

    public function testGetUriAndGetMethod()
    {
        $executor = $this->makeRequestExecutorFor('GET');

        $this->assertEquals('http://www.olx.com', $executor->getUri());
        $this->assertEquals('GET', $executor->getMethod());
    }

    private function makeRequestExecutorFor($method)
    {
        $httpClient = $this->getMock(Client::class);
        $httpClient->method('get')->willReturn('get');
        $httpClient->method('post')->willReturn('post');
        $httpClient->method('put')->willReturn('put');
        $httpClient->method('delete')->willReturn('delete');

        $requestExecutor = $this->getMockBuilder('OLX\FluentHttpClient\Request\RequestExecutor')
            ->setConstructorArgs([$method, 'http://www.olx.com', []])
            ->setMethods(['getClient'])->getMock();
        
        $requestExecutor->expects($this->any())
            ->method('getClient')
            ->willReturn($httpClient);
        return $requestExecutor;
    }
}
