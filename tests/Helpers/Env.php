<?php

namespace YandexDirectSDKTest\Helpers;

use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\ModelCollection;
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
        $name = trim($name);
        $namespace = __NAMESPACE__ . '\FakeModel';
        $modelClass = $namespace . '\\' . $name;
        $extendsClass = '\\' . Model::class;

        if (!class_exists($modelClass)){
            eval("
                namespace {$namespace} {
                    class {$name} extends {$extendsClass}
                    {
                        protected static \$properties = [];
                        protected static \$methods = [];
                        protected static \$staticMethods = [];
                        protected static \$compatibleCollection;
                        protected static \$nonWritableProperties = [];
                        protected static \$nonReadableProperties = [];
                        protected static \$nonUpdatableProperties = [];
                        protected static \$nonAddableProperties = [];
                        
                        public static function reboot(\$mock)
                        {
                            if (!is_null(self::\$boot)){
                                self::\$boot->remove(static::class);
                            }
                            
                            static::\$properties = \$mock['properties'] ?? [];
                            static::\$methods = \$mock['serviceMethods'] ?? [];
                            static::\$staticMethods = \$mock['serviceMethods'] ?? [];
                            static::\$compatibleCollection = \$mock['compatibleCollection'] ?? null;
                            static::\$nonWritableProperties = \$mock['nonWritableProperties'] ?? [];
                            static::\$nonReadableProperties = \$mock['nonReadableProperties'] ?? [];
                            static::\$nonUpdatableProperties = \$mock['nonUpdatableProperties'] ?? [];
                            static::\$nonAddableProperties = \$mock['nonAddableProperties'] ?? [];
                            static::boot();
                        }
                    }             
                } 
            ");
        }

        /**
         * @noinspection PhpUndefinedMethodInspection
         */
        $modelClass::reboot($mock);

        /**
         * @var ModelInterface $modelClass
         */
        return $modelClass;
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
        $name = trim($name);
        $namespace = __NAMESPACE__ . '\FakeModelCollection';
        $collectionClass = $namespace . '\\' . $name;
        $extendsClass = '\\' . ModelCollection::class;

        if (!class_exists($collectionClass)){
            eval("
                namespace {$namespace} {
                    class {$name} extends {$extendsClass}
                    {
                        public static \$methods = [];
                        public static \$staticMethods = [];
                        public static \$compatibleMode = 'asdasdasd';
                        
                        public static function reboot(\$mock)
                        {
                            if (!is_null(self::\$boot)){
                                self::\$boot->remove(static::class);
                            }
                            
                            static::\$methods = \$mock['serviceMethods'] ?? [];
                            static::\$staticMethods = \$mock['serviceMethods'] ?? [];
                            static::\$compatibleModel = \$mock['compatibleModel'] ?? null;
                            static::boot();
                        }
                    }             
                } 
            ");
        }

        /**
         * @noinspection PhpUndefinedMethodInspection
         */
        $collectionClass::reboot($mock);

        /**
         * @var ModelCollectionInterface $collectionClass
         */
        return $collectionClass;
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