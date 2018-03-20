<?php

namespace RstGroup\Zend1MvcPsrMessageBridge;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Create Zend Framework 1 requests and responses from PSR-7 implementations.
 */
interface ZendMessageFactoryInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return \Zend_Controller_Request_Http
     */
    public function createRequest(ServerRequestInterface $request);

    /**
     * @param ResponseInterface $response
     * @return \Zend_Controller_Response_Http
     */
    public function createResponse(ResponseInterface $response);
}
