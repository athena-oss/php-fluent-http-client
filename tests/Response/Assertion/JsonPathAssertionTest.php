<?php

namespace OLX\FluentHttpClient\Response\Assertion;

use OLX\FluentHttpClient\Response\ResponseHolder;
use OLX\FluentHttpClient\Exception\UnexpectedValueException;
use PHPUnit_Framework_MockObject_MockObject;

class JsonPathAssertionTest extends \PHPUnit_Framework_TestCase
{
    /** @var  PHPUnit_Framework_MockObject_MockObject */
    private $responseHolder;

    public function setUp()
    {
        $bodyContents = json_encode(
            [
                'bar' => 'lalala',
                'foo' => 'lalala',
                'fooBar' => 'whatever',
                'baz' => [
                    'numberz' => 123,
                    'cha-ching' => 'lalala',
                    'bazinga' => 'lalala'
                ]
            ],
            JSON_PRETTY_PRINT
        );

        $this->responseHolder = $this->getMockBuilder(ResponseHolder::class)->disableOriginalConstructor()->getMock();
        $this->responseHolder->method('getBody')->willReturn($bodyContents);
    }

    public function testAssertMatchingPath()
    {
        $path = '$.foo';
        $this->assertTrue((new JsonPathAssertion($path))->assert($this->responseHolder));
    }

    public function testAssertMatchingSublevelPath()
    {
        $path = '$.baz.bazinga';
        $this->assertTrue((new JsonPathAssertion($path))->assert($this->responseHolder));
    }

    public function testAssertPathNotFound()
    {
        $path = '$.path.not.found';

        $this->setExpectedException(UnexpectedValueException::class);
        (new JsonPathAssertion($path))->assert($this->responseHolder);
    }

}
