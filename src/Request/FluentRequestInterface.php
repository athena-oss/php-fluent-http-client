<?php
namespace OLX\FluentHttpClient\Request;

use OLX\FluentHttpClient\Response\Response;

interface FluentRequestInterface
{
    /**
     * @param $content
     * @param $contentType
     * @return $this
     */
    public function withBody($content, $contentType);

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function withHeader($name, $value);

    /**
     * @param array $parameters
     * @return $this
     */
    public function withQueryParameters(array $parameters);

    /**
     * @param $param
     * @param $value
     * @return $this
     */
    public function withQueryParameter($param, $value);

    /**
     * @param array $parameters
     * @return $this
     */
    public function withFormParameters(array $parameters);

    /**
     * @param $param
     * @param $value
     * @return $this
     */
    public function withFormParameter($param, $value);

    /**
     * @param $username
     * @param $password
     * @return $this
     */
    public function withBasicAuth($username, $password);

    /**
     * @param $username
     * @param $password
     * @return $this
     */
    public function withDigestAuth($username, $password);

    /**
     * @param $userAgentString
     * @return $this
     */
    public function withUserAgent($userAgentString);

    /**
     * @param $url
     * @param $port
     * @return $this
     */
    public function withProxy($url, $port);

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function withOption($name, $value);

    /**
     * @return Response
     */
    public function then();
}
