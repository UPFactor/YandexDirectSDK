<?php

namespace YandexDirectSDKTest\Unit\Session;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Environment;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Session;
use YandexDirectSDKTest\Helpers\FakeEnvironment;
use YandexDirectSDKTest\Helpers\FakeSession;
use YandexDirectSDKTest\Helpers\TestDir;

class SessionTest extends TestCase
{
    public static $logFile;

    public static function setUpBeforeClass():void
    {
        FakeEnvironment::setUp();
        self::$logFile = TestDir::run('testConstructLogFile.log', '');
    }

    public static function tearDownAfterClass():void
    {
        FakeEnvironment::tearDown();
        if (file_exists(self::$logFile)){
            unlink(self::$logFile);
        }
    }

    public function InitDataProvider(){
        return [
            [
                'init' => [
                    'token' => ''
                ],
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
                'init' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => true,
                    'operatorUnits' => true,
                    'logFile' => self::$logFile
                ],
                'fetch' => [
                    'token' => 'testToken',
                    'client' => 'testClient',
                    'language' => 'testLanguage',
                    'sandbox' => true,
                    'operatorUnits' => true,
                    'logFile' => self::$logFile
                ]
            ]
        ];
    }

    /**
     * @dataProvider InitDataProvider
     *
     * @param array $a
     * @param array $b
     * @throws RuntimeException
     */
    public function testConstruct(array $a, array $b)
    {
        $session = new Session($a['token'], $a);
        $this->assertEquals($b, $session->fetch());
    }

    /**
     * @dataProvider InitDataProvider
     * @depends testConstruct
     *
     * @param array $a
     * @param array $b
     * @throws RuntimeException
     */
    public function testMake(array $a, array $b)
    {
        $session = Session::make($a['token'], $a);
        $this->assertEquals($b, $session->fetch());
    }

    /**
     * @dataProvider InitDataProvider
     * @depends testConstruct
     *
     * @param array $a
     * @param array $b
     * @throws RuntimeException
     */
    public function testInit(array $a, array $b)
    {
        Environment::set($a);
        $session = Session::init();
        $this->assertEquals($b, $session->fetch());

        FakeEnvironment::setUp();
    }

    /**
     * Calling the Yandex.Direct API method.
     *
     * @depends testInit
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testApiCall(): void
    {
        $result = FakeSession::init()->call('dictionaries', 'get', [
            'DictionaryNames' => ['Currencies']
        ]);

        $this->assertTrue($result instanceof Result);
    }

    /**
     * Yandex.Direct API method exception: Bad Request.
     *
     * @depends testInit
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testApiCall_RequestException_BadRequest():void
    {
        $this->expectException(RequestException::class);
        FakeSession::init()->call('dictionaries', 'get', []);
    }

    /**
     * Yandex.Direct API method exception: Not Found.
     *
     * @depends testInit
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testApiCall_RequestException_NotFound():void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionCode(404);
        FakeSession::init()->call('', '');
    }

    /**
     * Yandex.Direct API method exception: URI Too Long.
     *
     * @depends testInit
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testApiCall_RequestException_URILong():void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionCode(414);
        FakeSession::init()->call(str_repeat('dictionaries', 1000), '');
    }

    /**
     * Yandex.Direct API method exception: Lack of access to the log file.
     *
     * @depends testInit
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function testApiCall_RuntimeException_LogFileUnavailable():void
    {
        $this->expectException(RuntimeException::class);

        $session = FakeSession::init();
        $session->useLogFile(true, self::$logFile);

        chmod(self::$logFile, 000);

        try {
            $session->call('dictionaries', 'get', [
                'DictionaryNames' => ['Currencies']
            ]);
        } catch (RuntimeException $e){
            unlink(self::$logFile);
            throw $e;
        }
    }

}