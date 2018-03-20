<?php

namespace RstGroup\Zend1MvcPsrMessageBridge\Test\Factory;

use RstGroup\Zend1MvcPsrMessageBridge\Factory\AsikaHttpFactory;
use RstGroup\Zend1MvcPsrMessageBridge\PsrMessageFactoryInterface;

class AsikaHttpFactoryTest extends AbstractFactoryTest
{
    /**
     * @var PsrMessageFactoryInterface
     */
    protected $factory;

    protected function setUp()
    {
        $this->factory = new AsikaHttpFactory();
    }

    /**
     * @param string $content
     * @param int $code
     * @param array $headers
     *
     * @dataProvider provideResponseData
     */
    public function testResponse($content, $code, array $headers)
    {
        $response = $this->buildZendResponseMock();
        $response
            ->setHttpResponseCode($code)
            ->setBody($content);

        foreach ($headers as $name => $values) {
            foreach ($values as $value) {
                $response->setHeader($name, $value);
            }
        }

        $psrResponse = $this->factory->createResponse($response);

        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $psrResponse);
        $this->assertInstanceOf('Asika\Http\Response', $psrResponse);

        $this->assertEquals($code, $psrResponse->getStatusCode());
        $this->assertEquals($content, $psrResponse->getBody()->__toString());

        foreach ($headers as $name => $values) {
            $this->assertEquals($values, $psrResponse->getHeader($name));
        }
    }
}
