<?php

namespace YandexDirectSDKTest\Helpers;

use Exception;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Session;

class SessionTools
{
    protected static $initFile = __DIR__.'/../Init/init.php';

    /**
     * Get data for session initialization with API Yandex.Direct.
     *
     * @return array
     */
    public static function getInitData(){
        if(!file_exists(self::$initFile)){
            die("Failed to get session initialization data: File to initialize a session [".realpath(self::$initFile)."] not found.");
        }

        require self::$initFile;

        if (!isset($sessionInit) or !is_array($sessionInit)){
            die("Failed to get session initialization data: The data for session initiation is not set or incorrect.");
        }

        if (!isset($sessionInit['token']) or !is_string($sessionInit['token'])){
            die("Failed to get session initialization data: Session token not set or incorrect.");
        }

        return $sessionInit;
    }

    /**
     * Initialize a new session with API Yandex.Direct.
     *
     * @param array $exclude
     * @return Session
     */
    public static function init($exclude = []){

        $sessionInit =  self::getInitData();

        $token = $sessionInit['token'];
        $exclude[] = 'token';

        foreach ($exclude as $option){
            if (is_string($option)){
                unset($sessionInit[$option]);
            }
        }

        try {
            return new Session($token, $sessionInit);
        } catch (Exception $error){
            die("Failed session init: {$error->getMessage()}");
        }
    }

    /**
     * Initialize a new fake session
     *
     * @param string $dataPath
     * @return FakeSession
     * @throws RuntimeException
     */
    public static function fake(string $dataPath){
        return (new FakeSession(''))->useFakeApi(true, $dataPath);
    }
}