<?php

namespace RstGroup\Zend1MvcPsrMessageBridge\Test\Factory;

use PHPUnit\Framework\TestCase;

abstract class AbstractFactoryTest extends TestCase
{
    /**
     * @return array
     */
    public function provideResponseData()
    {
        return array(
            array(
                'Foo bar bazinga',
                200,
                array(
                    'Content-Type' => array('text/html'),
                ),
            ),
            array(
                '', 204, array(),
            ),
            array(
                'Foo bar bazinga',
                200,
                array(
                    'Content-Type'   => array('text/html; charset=utf-8'),
                    'Content-Length' => array('5'),
                ),
            ),
            array(
                'Foo bar bazinga',
                202,
                array(
                    'Content-Type'   => array('text/html; level=1', 'text/html'),
                    'Content-Length' => array('5'),
                ),
            ),
        );
    }

    /**
     * @return \Zend_Controller_Response_Http
     */
    public function buildZendResponseMock()
    {
        $mock = $this->getMockBuilder('Zend_Controller_Response_Http')
            ->setMethods(array('canSendHeaders'))
            ->getMock();

        $mock
            ->method('canSendHeaders')
            ->willReturn(true);

        return $mock;
    }
}
