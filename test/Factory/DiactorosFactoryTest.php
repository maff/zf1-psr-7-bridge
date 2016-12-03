<?php

namespace Maff\Zend1MvcPsrMessageBridge\Test\Factory;

use Maff\Zend1MvcPsrMessageBridge\Factory\DiactorosFactory;
use Maff\Zend1MvcPsrMessageBridge\PsrMessageFactoryInterface;

class DiactorosFactoryTest extends \PHPUnit\Framework\TestCase
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
     * @return \Zend_Controller_Response_Http
     */
    protected function buildResponseMock()
    {
        $mock = $this->getMockBuilder(\Zend_Controller_Response_Http::class)
            ->setMethods(['canSendHeaders'])
            ->getMock();

        $mock
            ->method('canSendHeaders')
            ->willReturn(true);

        return $mock;
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
        $response = $this->buildResponseMock();
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

    /**
     * @return array
     */
    public function provideResponseData()
    {
        return [
            [
                'Foo bar bazinga',
                200,
                [
                    'Content-Type' => ['text/html'],
                ],
            ],
            [
                '', 204, [],
            ],
            [
                'Foo bar bazinga',
                200,
                [
                    'Content-Type'   => ['text/html; charset=utf-8'],
                    'Content-Length' => ['5'],
                ],
            ],
            [
                'Foo bar bazinga',
                202,
                [
                    'Content-Type'   => ['text/html; level=1', 'text/html'],
                    'Content-Length' => ['5'],
                ],
            ],
        ];
    }
}
