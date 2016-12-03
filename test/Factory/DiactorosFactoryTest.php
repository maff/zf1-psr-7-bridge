<?php

namespace Maff\Zend1MvcPsrMessageBridge\Test\Factory;

use Maff\Zend1MvcPsrMessageBridge\Factory\DiactorosFactory;
use Maff\Zend1MvcPsrMessageBridge\PsrMessageFactoryInterface;

class DiactorosFactoryTest extends AbstractFactoryTest
{
    /**
     * @var PsrMessageFactoryInterface
     */
    protected $factory;

    protected function setUp()
    {
        $this->factory = new DiactorosFactory();
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

        $psrRequest = $this->factory->createResponse($response);

        $this->assertEquals($code, $psrRequest->getStatusCode());
        $this->assertEquals($content, $psrRequest->getBody()->__toString());

        foreach ($headers as $name => $values) {
            $this->assertEquals($values, $psrRequest->getHeader($name));
        }
    }
}
