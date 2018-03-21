<?php

namespace RstGroup\Zend1MvcPsrMessageBridge;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Creates PSR-7 requests and response from Zend Framework 1 implementations.
 */
interface PsrMessageFactoryInterface
{
    /**
     * @param \Zend_Controller_Request_Http $request
     * @return ServerRequestInterface
     */
    public function createRequest(\Zend_Controller_Request_Http $request);

    /**
     * @param \Zend_Controller_Response_Http $response
     * @return ResponseInterface
     */
    public function createResponse(\Zend_Controller_Response_Http $response);
}
