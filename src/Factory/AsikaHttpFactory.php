<?php

namespace RstGroup\Zend1MvcPsrMessageBridge\Factory;

use Asika\Http\Response;
use Asika\Http\ServerRequest;
use Asika\Http\Stream\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RstGroup\Zend1MvcPsrMessageBridge\PsrMessageFactoryInterface;
use Zend_Controller_Request_Http;
use Zend_Controller_Response_Http;

final class AsikaHttpFactory implements PsrMessageFactoryInterface
{
    /**
     * @param Zend_Controller_Request_Http $request
     * @return ServerRequestInterface
     */
    public function createRequest(Zend_Controller_Request_Http $request)
    {
        $serverParams = $request->getServer();
        $serverParams = empty($serverParams) ? array() : $serverParams;
        $uri = $request->getRequestUri();
        $method = $request->getMethod();
        $headers = getallheaders();

        return new ServerRequest($serverParams, array(), $uri, $method, 'php://input', $headers);
    }

    /**
     * @param Zend_Controller_Response_Http $response
     * @return ResponseInterface
     */
    public function createResponse(Zend_Controller_Response_Http $response)
    {
        $stream = new Stream('php://temp', 'wb+');
        $stream->write($response->getBody());

        $psrResponse = new Response($stream, $response->getHttpResponseCode());

        foreach ($response->getHeaders() as $header) {
            $psrResponse = $psrResponse->withAddedHeader($header['name'], $header['value']);
        }

        return $psrResponse;
    }
}
