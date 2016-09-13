<?php
namespace OLX\FluentHttpClient;

use OLX\FluentHttpClient\Request\FluentRequestInterface;

interface HttpClientInterface
{
    /**
     * @param $uri
     * @return FluentRequestInterface
     */
    public function get($uri);

    /**
     * @param $uri
     * @return FluentRequestInterface
     */
    public function post($uri);

    /**
     * @param $uri
     * @return FluentRequestInterface
     */
    public function put($uri);

    /**
     * @param $uri
     * @return FluentRequestInterface
     */
    public function delete($uri);
}
