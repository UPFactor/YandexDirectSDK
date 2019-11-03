<?php

namespace YandexDirectSDKTest\Unit\Session;

use PHPUnit\Framework\TestCase;
use UPTools\Arr;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\Env;

class SessionTest extends TestCase
{
    public function setUp(): void
    {
        Env::tearDownSession();
    }

    public static function tearDownAfterClass():void
    {
        Env::tearDownSession();
    }

    /*
    |--------------------------------------------------------------------------
    | Data providers
    |--------------------------------------------------------------------------
    */

    /**
     * @return array
     */
    public function fetchDataProvider(){
        return [
            [
                'set' => [],
                'expected' => [
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
                'expected' => [
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
                    'YD_SESSION_SANDBOX' => '',
                    'YD_SESSION_OPERATOR_UNITS' => '',
                    'YD_SESSION_LOG_FILE' => ''
                ],
                'expected' => [
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
                    'YD_SESSION_TOKEN' => '',
                    'YD_SESSION_CLIENT' => '',
                    'YD_SESSION_LANGUAGE' => '',
                    'YD_SESSION_SANDBOX' => 'true',
                    'YD_SESSION_OPERATOR_UNITS' => 'true',
                    'YD_SESSION_LOG_FILE' => ''
                ],
                'expected' => [
                    'token' => '',
                    'client' => '',
                    'language' => 'en',
                    'sandbox' => true,
                    'operatorUnits' => true,
                    'logFile' => null
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function setDataProvider(){
        return [
            [
                'set-1' => [],
                'set-2' => [],
                'expected' => [
                    'token' => '',
                    'client' => '',
                    'language' => 'en',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => null
                ]
            ],
            [
                'set-1' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => true,
                    'operatorUnits' => true,
                    'logFile' => 'testLogFile'
                ],
                'expected' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => true,
                    'operatorUnits' => true,
                    'logFile' => 'testLogFile'
                ]
            ],
            [
                'set-1' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => true,
                    'operatorUnits' => true,
                    'logFile' => 'testLogFile'
                ],
                'set-2' => [
                    'token' => '',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => null
                ],
                'expected' => [
                    'token' => '',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => null
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function resetDataProvider(){
        return [
            [
                'set' => [],
                'reset' => [],
                'expected' => [
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
                'reset' => [],
                'expected' => [
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
                'reset' => [
                    'token' => 'testToken_2',
                    'client' => 'testClient_2',
                    'language' => 'testLanguage_2',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => 'testLogFile_2'
                ],
                'expected' => [
                    'token' => 'testToken_2',
                    'client' => 'testClient_2',
                    'language' => 'testLanguage_2',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => 'testLogFile_2'
                ]
            ],
            [
                'set' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => 'testLogFile'
                ],
                'reset' => [
                    'token' => 'testToken_2',
                    'language' => 'testLanguage_2',
                    'operatorUnits' => true,
                ],
                'expected' => [
                    'token' => 'testToken_2',
                    'client' => '',
                    'language' => 'testLanguage_2',
                    'sandbox' => false,
                    'operatorUnits' => true,
                    'logFile' => null
                ]
            ],
            [
                'set' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => false,
                    'operatorUnits' => false,
                    'logFile' => 'testLogFile'
                ],
                'reset' => [
                    'client' => 'testClient_2',
                    'sandbox' => true,
                    'logFile' => 'testLogFile_2'
                ],
                'expected' => [
                    'token' => '',
                    'client' => 'testClient_2',
                    'language' => 'en',
                    'sandbox' => true,
                    'operatorUnits' => false,
                    'logFile' => 'testLogFile_2'
                ]
            ]
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Tests
    |--------------------------------------------------------------------------
    */

    /**
     * @dataProvider fetchDataProvider
     *
     * @param array $set
     * @param array $expected
     */
    public function testFetch(array $set, array $expected)
    {
        foreach ($set as $key => $value){
            $_ENV[$key] = $value;
        }

        $this->assertEquals(
            $expected,
            Session::fetch()
        );
    }

    /**
     * @dataProvider setDataProvider
     *
     * @param array $options
     */
    public function testSet(...$options)
    {
        $this->assertTrue(
            count($options) > 1,
            'Data provider is invalid'
        );

        foreach (Arr::initial($options) as $set){
            Session::set($set);
        }

        $this->assertEquals(
            Arr::last($options),
            Session::fetch()
        );
    }

    /**
     * @dataProvider resetDataProvider
     * @depends testFetch
     *
     * @param array $set
     * @param array $reset
     * @param array $expected
     */
    public function testReset(array $set, array $reset, array $expected)
    {
        Session::set($set);
        Session::reset($reset);

        $this->assertEquals(
            $expected,
            Session::fetch()
        );
    }

    /**
     * @return void
     */
    public function testSetAndGetToken(): void
    {
        Session::setToken('testString');
        $this->assertEquals('testString', Session::getToken());
    }

    /**
     * @return void
     */
    public function testSetAndGetClient(): void
    {
        Session::setClient('testString');
        $this->assertEquals('testString', Session::getClient());
    }

    /**
     * @return void
     */
    public function testSetAndGetLanguage(): void
    {
        Session::setLanguage('testString');
        $this->assertEquals('testString', Session::getLanguage());
    }

    /**
     * @return void
     */
    public function testSetAndGetSandbox(): void
    {
        Session::useSandbox(true);
        $this->assertEquals(true, Session::usedSandbox());

        Session::useSandbox(false);
        $this->assertEquals(false, Session::usedSandbox());
    }

    /**
     * @return void
     */
    public function testSetAndGetOperatorUnits(): void
    {
        Session::useOperatorUnits(true);
        $this->assertEquals(true, Session::usedOperatorUnits());

        Session::useOperatorUnits(false);
        $this->assertEquals(false, Session::usedOperatorUnits());
    }

    /**
     * @return void
     */
    public function testSetAndGetLogFile(): void
    {
        Session::useLogFile(true, 'filePath');
        $this->assertEquals('filePath', Session::getLogFile());

        Session::useLogFile(false);
        $this->assertEquals(null, Session::getLogFile());
    }

    /**
     * Calling the Yandex.Direct API method.
     *
     * @return void
     */
    public function testCall(): void
    {
        Env::setUpSession();
        $result = Session::call('dictionaries', 'get', [
            'DictionaryNames' => ['Currencies']
        ]);

        $this->assertTrue($result instanceof Result);
    }

    /**
     * Yandex.Direct API method exception: Bad Request.
     *
     * @return void
     */
    public function testCall_RequestException_BadRequest(): void
    {
        Env::setUpSession();
        $this->expectException(RequestException::class);
        Session::call('dictionaries', 'get', []);
    }

    /**
     * Yandex.Direct API method exception: Not Found.
     *
     * @return void
     */
    public function testCall_RequestException_NotFound(): void
    {
        Env::setUpSession();
        $this->expectException(RequestException::class);
        $this->expectExceptionCode(404);
        Session::call('', '');

    }

    /**
     * Yandex.Direct API method exception: URI Too Long.
     *
     * @return void
     */
    public function testCall_RequestException_URILong(): void
    {
        Env::setUpSession();
        $this->expectException(RequestException::class);
        $this->expectExceptionCode(414);
        Session::call(str_repeat('dictionaries', 1000), '');
    }

    /**
     * Yandex.Direct API method exception: Lack of access to the log file.
     *
     * @return void
     */
    public function testCall_RuntimeException_LogFileUnavailable(): void
    {
        Env::setUpSession();
        $this->expectException(RuntimeException::class);

        file_put_contents($file = Env::getRunPath('SessionTest@testCall_RuntimeException_LogFileUnavailable.log'), '');
        chmod($file, 000);

        try {
            Session::useLogFile(true, $file);
            Session::call('dictionaries', 'get', [
                'DictionaryNames' => ['Currencies']
            ]);
        } catch (RuntimeException $error){
            unlink($file);
            throw $error;
        }

        unlink($file);
    }
}