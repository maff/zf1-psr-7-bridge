<?php

namespace RstGroup\Zend1MvcPsrMessageBridge\Factory;

use Asika\Http\Response;
use Asika\Http\Stream\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RstGroup\Zend1MvcPsrMessageBridge\PsrMessageFactoryInterface;
use Zend_Controller_Request_Http;
use Zend_Controller_Response_Http;

class AsikaHttpFactory implements PsrMessageFactoryInterface
{
    /**
     * @param Zend_Controller_Request_Http $request
     * @return ServerRequestInterface
     */
    public function createRequest(Zend_Controller_Request_Http $request)
    {
        // TODO: Implement createRequest() method.
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
