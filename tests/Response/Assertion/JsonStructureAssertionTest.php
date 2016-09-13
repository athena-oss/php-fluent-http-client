<?php

namespace OLX\FluentHttpClient\Response\Assertion;

use OLX\FluentHttpClient\Response\ResponseHolder;
use OLX\FluentHttpClient\Exception\UnexpectedValueException;
use PHPUnit_Framework_MockObject_MockObject;

class JsonStructureAssertionTest extends \PHPUnit_Framework_TestCase
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

        $this->responseHolder = $this->getMockWithoutInvokingTheOriginalConstructor(ResponseHolder::class);
        $this->responseHolder->method('getBody')->willReturn($bodyContents);
    }

    public function testAssertMatchingStructure()
    {
        $structure = [
            'foo' => '*',
            'bar' => '*',
            'baz' => [
                'bazinga' => '*',
                'cha-ching' => '*'
            ],
            'fooBar' => 'whatever'
        ];

        $this->assertTrue((new JsonStructureAssertion($structure))->assert($this->responseHolder));
    }

    public function testAssertNotMatchingStructure()
    {
        $structure = [
            'foo' => '*',
            'bar' => '*',
            'baz' => [
                'bazinga' => '*',
                'lalala' => '*'
            ],
            'fooBar' => 'whatever'
        ];

        $this->setExpectedException(UnexpectedValueException::class);
        (new JsonStructureAssertion($structure))->assert($this->responseHolder);
    }

    public function testAssertNotMatchingValue()
    {
        $structure = [
            'foo' => '*',
            'bar' => '*',
            'baz' => [
                'bazinga' => '*',
                'cha-ching' => '*'
            ],
            'fooBar' => 'something else'
        ];

        $this->setExpectedException(UnexpectedValueException::class);
        (new JsonStructureAssertion($structure))->assert($this->responseHolder);
    }
}
