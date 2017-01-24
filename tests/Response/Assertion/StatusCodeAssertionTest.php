<?php

namespace OLX\FluentHttpClient\Response\Assertion;

use OLX\FluentHttpClient\Response\ResponseHolder;
use OLX\FluentHttpClient\Exception\UnexpectedValueException;
use PHPUnit_Framework_MockObject_MockObject;

class StatusCodeAssertionTest extends \PHPUnit_Framework_TestCase
{
    /** @var  PHPUnit_Framework_MockObject_MockObject */
    private $responseHolder;

    public function setUp()
    {
        $this->responseHolder = $this->getMockBuilder(ResponseHolder::class)->disableOriginalConstructor()->getMock();
    }

    public function testMatchingStatusCode()
    {
        $this->responseHolder->method('getStatusCode')->willReturn(200);

        $this->assertTrue((new StatusCodeAssertion(200))->assert($this->responseHolder));
    }

    public function testNotMatchingStatusCode()
    {
        $this->responseHolder->method('getStatusCode')->willReturn(404);

        $this->setExpectedException(UnexpectedValueException::class);
        (new StatusCodeAssertion(200))->assert($this->responseHolder);
    }
}
