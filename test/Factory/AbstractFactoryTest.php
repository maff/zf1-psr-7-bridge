<?php

namespace Maff\Zend1MvcPsrMessageBridge\Test\Factory;

use PHPUnit\Framework\TestCase;

abstract class AbstractFactoryTest extends TestCase
{
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

    /**
     * @return \Zend_Controller_Response_Http
     */
    protected function buildZendResponseMock()
    {
        $mock = $this->getMockBuilder(\Zend_Controller_Response_Http::class)
            ->setMethods(['canSendHeaders'])
            ->getMock();

        $mock
            ->method('canSendHeaders')
            ->willReturn(true);

        return $mock;
    }
}
