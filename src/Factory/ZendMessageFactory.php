<?php

namespace RstGroup\Zend1MvcPsrMessageBridge\Factory;

use RstGroup\Zend1MvcPsrMessageBridge\ZendMessageFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ZendMessageFactory implements ZendMessageFactoryInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return \Zend_Controller_Request_Http
     */
    public function createRequest(ServerRequestInterface $request)
    {
        // TODO: Implement createRequest() method.
    }

    /**
     * @param ResponseInterface $response
     * @return \Zend_Controller_Response_Http
     */
    public function createResponse(ResponseInterface $response)
    {
        $zendResponse = $this->buildResponse();
        $zendResponse->setBody($response->getBody()->__toString());
        $zendResponse->setHttpResponseCode($response->getStatusCode());

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                $zendResponse->setHeader($name, $value);
            }
        }

        return $zendResponse;
    }

    /**
     * @return \Zend_Controller_Response_Http
     */
    public function buildResponse()
    {
        return new \Zend_Controller_Response_Http();
    }
}
