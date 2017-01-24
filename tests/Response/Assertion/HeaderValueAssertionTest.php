<?php

namespace OLX\FluentHttpClient\Response\Assertion;

use OLX\FluentHttpClient\Response\ResponseHolder;
use OLX\FluentHttpClient\Exception\UnexpectedValueException;
use PHPUnit_Framework_MockObject_MockObject;

class HeaderValueAssertionTest extends \PHPUnit_Framework_TestCase
{
    /** @var  PHPUnit_Framework_MockObject_MockObject */
    private $responseHolder;
    /** @var  HeaderAssertion */
    private $headerAssertion;

    public function setUp()
    {
        $this->responseHolder = $this->getMockBuilder(ResponseHolder::class)->disableOriginalConstructor()->getMock();
        $this->responseHolder->method('getHeader')->willReturnCallback(function ($headerName) {
            $headers = ['Foo' => 'bar'];

            return $headers[$headerName];
        });

        $this->headerAssertion = new HeaderAssertion('my-expected-header-name');
    }

    public function testAssertMatchingHeaderValue()
    {
        $this->assertTrue((new HeaderValueAssertion('Foo', 'bar'))->assert($this->responseHolder));
    }

    public function testAssertNotMatchingHeaderValue()
    {
        $this->setExpectedException(UnexpectedValueException::class);
        (new HeaderValueAssertion('Foo', 'wrong-value'))->assert($this->responseHolder);
    }
}
