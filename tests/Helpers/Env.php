<?php

namespace YandexDirectSDKTest\Helpers;

use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Session;

class Env
{
    /**
     * Sets the session parameters in accordance with
     * the settings of the test environment.
     *
     * @return void
     */
    public static function setUpSession():void
    {
        $initFile = static::getInitPath('init.json', true);
        $initContent = json_decode(file_get_contents($initFile), true);

        if (json_last_error() !== JSON_ERROR_NONE or !is_array($initContent) or empty($initContent)){
            die("No session connection settings. Set connection parameters in file: [" . static::getInitPath('init.json') . "]");
        }

        static::tearDownSession();

        foreach ($initContent as $key => $value){
            $_ENV[$key] = $value;
        }
    }

    /**
     * Resets session parameters.
     *
     * @return void
     */
    public static function tearDownSession():void
    {
        unset(
            $_ENV['YD_SESSION_TOKEN'],
            $_ENV['YD_SESSION_CLIENT'],
            $_ENV['YD_SESSION_LANGUAGE'],
            $_ENV['YD_SESSION_SANDBOX'],
            $_ENV['YD_SESSION_OPERATOR_UNITS'],
            $_ENV['YD_SESSION_LOG_FILE']
        );
    }

    /**
     * Switch Local/Cloud API mode for session.
     *
     * @param bool $switch
     * @param string $apiName
     */
    public static function useLocalApi(bool $switch, string $apiName = 'Base'):void
    {
        if ($switch === true){
            Session::$callHandler = function ($service, $method) use ($apiName){
                $apiContent = FakeApi::getJson($apiName.DIRECTORY_SEPARATOR.$service.DIRECTORY_SEPARATOR.$method);
                return new FakeResult($apiContent);
            };
        } else {
            Session::$callHandler = null;
        }
    }

    /**
     * Constructor of a fake model.
     * Creates a model class according to the passed parameters.
     * Returns the name of the created class.
     *
     * @param string $name
     * @param array $mock
     * @return string|ModelInterface
     */
    public static function setUpModel(string $name, array $mock = [])
    {
        $classSource = file_get_contents(static::getInitPath('FakeModel.class'));
        $classSource = str_replace('{$name}', trim($name), $classSource);
        $class = 'YandexDirectSDK\FakeModels\\'.trim($name);

        if (!class_exists($class)){
            eval($classSource);
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $class::reboot($mock);
        return $class;
    }

    /**
     * Constructor of a fake model collection.
     * Creates a model class according to the passed parameters.
     * Returns the name of the created class.
     *
     * @param string $name
     * @param array $mock
     * @return string|ModelCollectionInterface
     */
    public static function setUpModelCollection(string $name, array $mock = [])
    {
        $classSource = file_get_contents(static::getInitPath('FakeModelCollection.class'));
        $classSource = str_replace('{$name}', trim($name), $classSource);
        $class = 'YandexDirectSDK\FakeCollections\\'.trim($name);

        if (!class_exists($class)){
            eval($classSource);
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $class::reboot($mock);
        return $class;
    }

    /**
     * Path constructor.
     *
     * @param string $directory
     * @param string $path
     * @param bool $required
     * @return string
     */
    public static function getPath(string $directory, string $path, $required = false):string
    {
        $directory = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $directory);
        $path = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $path);

        if (!file_exists($directory)){
            if (!mkdir($directory, 0777, true)) {
                die("Failed to create folder [{$directory}]");
            }
        }

        if ($required === true) {
            $path = realpath($directory . DIRECTORY_SEPARATOR . $path);
            if (!is_string($path)){
                die("Required file [{$path}] not found");
            }
        } else {
            $path = realpath($directory) . DIRECTORY_SEPARATOR . $path;
        }

        return $path;
    }

    /**
     * Path constructor for [init] directory.
     *
     * @param string $path
     * @param bool $required
     * @return string
     */
    public static function getInitPath(string $path = '', $required = false):string
    {
        return static::getPath(__DIR__ . '/../Init', $path, $required);
    }

    /**
     * Path constructor for [run] directory.
     *
     * @param string $path
     * @param bool $required
     * @return string
     */
    public static function getRunPath(string $path = '', $required = false):string
    {
        return static::getPath(__DIR__ . '/../Run', $path, $required);
    }

    /**
     * Path constructor for [data] directory.
     *
     * @param string $path
     * @param bool $required
     * @return string
     */
    public static function getDataPath(string $path = '', $required = false):string
    {
        return static::getPath(__DIR__ . '/../Data', $path, $required);
    }

    /**
     * Path constructor for [files] directory.
     *
     * @param string $path
     * @param bool $required
     * @return string
     */
    public static function getFilesPath(string $path = '', $required = false):string
    {
        return static::getPath(__DIR__ . '/../Files', $path, $required);
    }
}