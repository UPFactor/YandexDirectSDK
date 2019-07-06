<?php

namespace YandexDirectSDKTest\Helpers;

use Exception;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Common\Dir;
use YandexDirectSDK\Common\File;
use YandexDirectSDK\Common\Str;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Session;

class FakeApi extends Session
{
    /**
     * @param string $apiPath
     * @return array
     * @throws Exception
     */
    public static function get(string $apiPath)
    {
        $apiPath = TestDir::data($apiPath);
        $apiPath = Str::end($apiPath, '.json');
        $content = File::bind($apiPath)->content();
        $content = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE){
            return [];
        }

        return Arr::wrap($content);
    }

    /**
     * @param string $apiPath
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public static function getArray(string $apiPath, string $key = null)
    {
        $arr = self::get($apiPath);

        if (is_null($key)){
            return $arr;
        }

        return Arr::get($arr, $key, []);
    }

    /**
     * @param string $apiPath
     * @param string $key
     * @return string
     * @throws Exception
     */
    public static function getJson(string $apiPath, string $key = null)
    {
        return self::getArray($apiPath, $key);
    }

    /**
     * @param $apiPath
     * @param string $key
     * @return Data
     * @throws Exception
     */
    public static function getData($apiPath, string $key = null)
    {
        $arr = self::getArray($apiPath, $key);
        return Data::make($arr);
    }
}