<?php

namespace OLX\FluentHttpClient\Response;

use OLX\FluentHttpClient\Response\Decorator\ResponseWithAssertions;
use OLX\FluentHttpClient\Holder\ClosureHolder;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @var ClosureHolder */
    private $closureHolder;
    /** @var Response */
    private $response;

    public function setUp()
    {
        $response = $this->getMockBuilder(GuzzleResponse::class)->disableOriginalConstructor()->getMock();
        $this->closureHolder = $this->getMockBuilder(ClosureHolder::class)->disableOriginalConstructor()->getMock();
        $this->closureHolder->method('get')->willReturn($response);
        $this->response = new Response($this->closureHolder);
    }

    public function testAssertThat()
    {
        $requestWithAssertions = $this->response->assertThat();

        $this->assertInstanceOf(ResponseWithAssertions::class, $requestWithAssertions);
    }

    public function testRetrieve()
    {
        $responseFormatter = $this->response->retrieve();

        $this->assertInstanceOf(ResponseFormatter::class, $responseFormatter);
    }

    public function testGetClosureHolder()
    {
        $closureHolder = $this->response->getClosureHolder();

        $this->assertSame($this->closureHolder, $closureHolder);
    }
}
