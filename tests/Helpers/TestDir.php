<?php


namespace YandexDirectSDKTest\Helpers;

use Exception;

class TestDir
{
    /**
     * @param $directory
     * @param $path
     * @param null|string $content
     * @return string
     */
    private static function getPath($directory, $path, $content = null):string
    {
        $directory = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $directory);
        $path = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $path);

        if (!file_exists($directory)){
            if (!mkdir($directory, 0777, true)) {
                die("Failed to create folder [{$directory}]");
            }
        }

        $path = realpath($directory) . DIRECTORY_SEPARATOR . $path;

        if (is_string($content)){
            try {
                file_put_contents($path, $content);
            } catch (Exception $error){
                die($error->getMessage());
            }
        }

        return $path;
    }

    /**
     * @param string $path
     * @param null|string $content
     * @return string
     */
    public static function init(string $path = '', $content = null):string
    {
        return self::getPath(__DIR__ . '/../Init', $path, $content);
    }

    /**
     * @param string $path
     * @param null|string $content
     * @return string
     */
    public static function run(string $path = '', $content = null):string
    {
        return self::getPath(__DIR__ . '/../Run', $path, $content);
    }

    /**
     * @param string $path
     * @return string
     */
    public static function data(string $path = ''):string
    {
        return self::getPath(__DIR__ . '/../Data', $path);
    }
}