<?php

namespace Maff\Zend1MvcPsrMessageBridge\Test\Factory;

use Maff\Zend1MvcPsrMessageBridge\Factory\ZendMessageFactory;
use Maff\Zend1MvcPsrMessageBridge\ZendMessageFactoryInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

class ZendMessageFactoryTest extends AbstractFactoryTest
{
    /**
     * @var ZendMessageFactoryInterface
     */
    protected $factory;

    protected function setUp()
    {
        // mock the buildResponse method and create a zend response instance which doesn't set/check
        // headers via PHP builtins (fails in CLI mode) - specifically it calls headers_sent to check if headers
        // were already sent
        $mock = $this->getMockBuilder(ZendMessageFactory::class)
            ->setMethods(['buildResponse'])
            ->getMock();

        $mock
            ->method('buildResponse')
            ->willReturnCallback(function () {
                return $this->buildZendResponseMock();
            });

        $this->factory = $mock;
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
        $stream = new Stream('php://temp', 'wb+');
        $stream->write($content);

        $response = new Response($stream, $code);
        foreach ($headers as $name => $values) {
            foreach ($values as $value) {
                $response = $response->withAddedHeader($name, $value);
            }
        }

        $zendResponse = $this->factory->createResponse($response);

        $this->assertEquals($code, $zendResponse->getHttpResponseCode());
        $this->assertEquals($content, $zendResponse->getBody());

        $zendHeaders = [];
        foreach ($zendResponse->getHeaders() as $header) {
            $zendHeaders[$header['name']][] = $header['value'];
        }

        $this->assertEquals($headers, $zendHeaders);
    }
}
