<?php
namespace OLX\FluentHttpClient\Response\Assertion;

use OLX\FluentHttpClient\Response\ResponseHolder;

interface ResponseAssertionInterface
{
    /**
     * @param ResponseHolder $response
     * @return mixed
     */
    public function assert(ResponseHolder $response);
}
