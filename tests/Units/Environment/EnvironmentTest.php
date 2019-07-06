<?php


namespace YandexDirectSDKTest\Units\Environment;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Environment;
use YandexDirectSDKTest\Helpers\FakeEnvironment;

class EnvironmentTest extends TestCase
{
    public static function tearDownAfterClass():void
    {
        FakeEnvironment::tearDown();
    }

    public function setDataProvider(){
        return [
            [
                'set' => [],
                'fetch' => [
                    'token' => '',
                    'client' => '',
                    'language' => 'en',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => null
                ]
            ],
            [
                'set' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => true,
                    'operatorUnits' => true,
                    'logFile' => 'testLogFile'
                ],
                'fetch' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => true,
                    'operatorUnits' => true,
                    'logFile' => 'testLogFile'
                ]
            ]
        ];
    }

    public function resetDataProvider(){
        return [
            [
                'set' => [],
                'reset' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                ],
                'fetch' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => null
                ]
            ],
            [
                'set' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => true,
                    'operatorUnits' => true,
                    'logFile' => 'testLogFile'
                ],
                'reset' => [],
                'fetch' => [
                    'token' => '',
                    'client' => '',
                    'language' => 'en',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => null
                ]
            ]
        ];
    }

    public function fetchDataProvider(){
        return [
            [
                'set' => [],
                'fetch' => [
                    'token' => '',
                    'client' => '',
                    'language' => 'en',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => null
                ]
            ],
            [
                'set' => [
                    'YD_SESSION_TOKEN' => 'testToken',
                    'YD_SESSION_CLIENT' => 'testClient',
                    'YD_SESSION_LANGUAGE' => 'testLanguage',
                    'YD_SESSION_SANDBOX' => 'true',
                    'YD_SESSION_OPERATOR_UNITS' => 'true',
                    'YD_SESSION_LOG_FILE' => 'testLogFile'
                ],
                'fetch' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => true,
                    'operatorUnits' => true,
                    'logFile' => 'testLogFile'
                ]
            ],
            [
                'set' => [
                    'YD_SESSION_TOKEN' => '',
                    'YD_SESSION_CLIENT' => '',
                    'YD_SESSION_LANGUAGE' => '',
                    'YD_SESSION_SANDBOX' => 'false',
                    'YD_SESSION_OPERATOR_UNITS' => 'false',
                    'YD_SESSION_LOG_FILE' => ''
                ],
                'fetch' => [
                    'token' => '',
                    'client' => '',
                    'language' => 'en',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => null
                ]
            ]
        ];
    }

    /**
     * @dataProvider setDataProvider
     *
     * @param $a
     * @param $b
     */
    public function testSet(array $a, array $b):void
    {
        Environment::set($a);
        $this->assertEquals($b, Environment::fetch());
    }

    /**
     * @dataProvider resetDataProvider
     *
     * @param $a
     * @param $b
     * @param $c
     */
    public function testReset(array $a, array $b, array $c):void
    {
        Environment::set($a);
        Environment::set($b);
        $this->assertEquals($c, Environment::fetch());
    }

    /**
     * @dataProvider fetchDataProvider
     *
     * @param array $a
     * @param array $b
     */
    public function testFetch(array $a, array $b):void
    {
        $_ENV = $a;
        $this->assertEquals($b, Environment::fetch());
    }
}