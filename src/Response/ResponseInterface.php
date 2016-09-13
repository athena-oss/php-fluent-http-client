<?php
namespace OLX\FluentHttpClient\Response;

interface ResponseInterface
{
    /**
     * @return ResponseFormatterInterface
     */
    public function retrieve();
}
