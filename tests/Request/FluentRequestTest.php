<?php

namespace OLX\FluentHttpClient;

use OLX\FluentHttpClient\Request\FluentRequest;
use OLX\FluentHttpClient\Exception\UnsupportedOperationException;

class FluentRequestTest extends \PHPUnit_Framework_TestCase
{
    private function makeFluentRequestFor($method)
    {
        return new FluentRequest($method, 'http://www.olx.com');
    }

    public function testWithBodyGivenMethodIsGET()
    {
        $this->setExpectedException(UnsupportedOperationException::class);

        $requestObj = $this->makeFluentRequestFor('GET');
        $requestObj->withBody('', '');
    }

    public function testWithBodyGivenMethodIsHEAD()
    {
        $this->setExpectedException(UnsupportedOperationException::class);

        $requestObj = $this->makeFluentRequestFor('HEAD');
        $requestObj->withBody('', '');
    }

    public function testWithBodyGivenContentIsArray()
    {
        $requestObj = $this->makeFluentRequestFor('POST');
        $requestObj->withBody(['my-content', ['xpto' => 'ole']], 'my-content-type');

        $expectedOptions = [
            'body' => '0=my-content&1%5Bxpto%5D=ole',
            'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
            'query' => []
        ];

        $this->assertAttributeEquals($expectedOptions, 'options', $requestObj);
    }

    public function testWithBodyGivenContentIsNotArray()
    {
        $requestObj = $this->makeFluentRequestFor('PUT');
        $requestObj->withBody('my content', 'custom content type');

        $expectedOptions = [
            'body' => 'my content',
            'headers' => ['Content-Type' => 'custom content type'],
            'query' => []
        ];

        $this->assertAttributeEquals($expectedOptions, 'options', $requestObj);
    }

    public function testWithHeader()
    {
        $requestObj = $this->makeFluentRequestFor('POST');
        $requestObj->withHeader('My-Header', 'some random stuff');

        $expectedOptions = [
            'headers' => ['My-Header' => 'some random stuff'],
            'query' => []
        ];

        $this->assertAttributeEquals($expectedOptions, 'options', $requestObj);
    }

    public function testWithQueryParameters()
    {
        $requestObj = $this->makeFluentRequestFor('GET');
        $requestObj->withQueryParameters(['param1'=>'valueeee', 'param2'=>'value']);
        $this->assertEquals(['param1'=>'valueeee', 'param2'=>'value'], $requestObj->getQueryParams());
    }

    public function testWithQueryParameter()
    {
        $requestObj = $this->makeFluentRequestFor('GET');
        $requestObj->withQueryParameter('param1', 'valueeee');
        $this->assertEquals(['param1'=>'valueeee'], $requestObj->getQueryParams());
    }

    public function testWithFormParameters()
    {
        $requestObj = $this->makeFluentRequestFor('POST');
        $requestObj->withFormParameters(['param1'=>'valueeee', 'param2'=>'value']);
        $expectedOptions = ['param1'=>'valueeee', 'param2'=>'value'];
        $this->assertEquals($expectedOptions, $requestObj->getFormParams());
    }

    public function testWithFormParameter()
    {
        $requestObj = $this->makeFluentRequestFor('POST');
        $requestObj->withFormParameter('param1', 'valueeee');
        $this->assertEquals(['param1'=>'valueeee'], $requestObj->getFormParams());
    }

    public function testWithBasicAuth()
    {
        $requestObj = $this->makeFluentRequestFor('GET');
        $requestObj->withBasicAuth('myusername', 'somepassword');

        $expectedOptions = [
            'auth' => ['myusername', 'somepassword', 'Basic'],
            'headers' => [],
            'query' => []
        ];

        $this->assertAttributeEquals($expectedOptions, 'options', $requestObj);
    }

    public function testWithDigestAuth()
    {
        $requestObj = $this->makeFluentRequestFor('GET');
        $requestObj->withDigestAuth('myusername', 'somepassword');

        $expectedOptions = [
            'auth' => ['myusername', 'somepassword', 'Digest'],
            'headers' => [],
            'query' => []
        ];

        $this->assertAttributeEquals($expectedOptions, 'options', $requestObj);
    }

    public function testWithUserAgent()
    {
        $requestObj = $this->makeFluentRequestFor('GET');
        $requestObj->withUserAgent('my user agent');

        $expectedOptions = [
            'headers' => ['User-Agent' => 'my user agent'],
            'query' => []
        ];

        $this->assertAttributeEquals($expectedOptions, 'options', $requestObj);
    }

    public function testWithOption()
    {
        $requestObj = $this->makeFluentRequestFor('DELETE');
        $requestObj->withOption('someoption', 'randomvalue');
        $requestObj->withOption('someotheroption', ['1', 2]);

        $expectedOptions = [
            'headers' => [],
            'someoption' => 'randomvalue',
            'someotheroption' => ['1', 2],
            'query' => []
        ];

        $this->assertAttributeEquals($expectedOptions, 'options', $requestObj);
    }

    public function testWithProxy()
    {
        $requestObj = $this->makeFluentRequestFor('GET');
        $requestObj->withProxy('myproxyhost', 233302);

        $expectedOptions = [
            'headers' => [],
            'proxy' => 'tcp://myproxyhost:233302',
            'query' => []
        ];

        $this->assertAttributeEquals($expectedOptions, 'options', $requestObj);
    }

    public function testWithFormParameter_IsGetMethod_ThrowUnsupportedOperationException()
    {
        $this->setExpectedException(UnsupportedOperationException::class);
        $requestObj = $this->makeFluentRequestFor('GET');
        $requestObj->withFormParameter('param', 'myvalue');
    }

    public function testWithFormParameter_IsHeadMethod_ThrowUnsupportedOperationException()
    {
        $this->setExpectedException(UnsupportedOperationException::class);
        $requestObj = $this->makeFluentRequestFor('GET');
        $requestObj->withFormParameter('param', 'myvalue');
    }

    public function testWithFormParameter_IsPostMethod_AddParameterToFormParams()
    {
        $requestObj = $this->makeFluentRequestFor('POST');
        $requestObj->withFormParameter('param', 'myvalue');
        $this->assertEquals($requestObj->getFormParams(), ['param' => 'myvalue']);
    }

    public function testWithOAuth_TokenIsAdded_AddParameterToHeaders()
    {
        $requestObj = $this->makeFluentRequestFor('POST');
        $requestObj->withOAuth('mytoken');
        $this->assertEquals($requestObj->getHeaders(), ['Authorization' => "Bearer mytoken"]);
    }

    public function testWithOAuth_NoHeaders_AddParameterToHeaders()
    {
        $requestObj = $this->makeFluentRequestFor('POST');
        $requestObj->withOAuth('mytoken');
        $this->assertEquals($requestObj->getHeaders(), ['Authorization' => "Bearer mytoken"]);
    }
}
