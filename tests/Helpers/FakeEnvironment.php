<?php

namespace YandexDirectSDKTest\Helpers;

use YandexDirectSDK\Environment;

class FakeEnvironment extends Environment
{
    /**
     * Initializes the test environment.
     *
     * @return void
     */
    public static function setUp()
    {
        $init = TestDir::init('init.json');

        if(!file_exists($init)){
            die("Failed to get session initialization data: File to initialize a session [{$init}] not found.");
        }

        $init = json_decode(file_get_contents($init), true);

        if (json_last_error() !== JSON_ERROR_NONE or !is_array($init) or empty($init)){
            die("Failed to get session initialization data: The data for session initiation is not set or incorrect.");
        }

        $init['YD_SESSION_LOG_FILE'] = TestDir::run('session.log');

        $_ENV = array_merge($_ENV, $init);
    }

    /**
     * Resets environment variables to default values.
     *
     * @return void
     */
    public static function tearDown(){
        self::set([]);
    }
}