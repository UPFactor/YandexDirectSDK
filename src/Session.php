<?php

namespace YandexDirectSDK;

use Exception;
use UPTools\File;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;

/**
 * Class Session
 *
 * @package YandexDirectSDK
 */
class Session
{
    /**
     * API URL v5
     *
     * @var string
     */
    protected const api = 'https://api.direct.yandex.com/json/v5/';

    /**
     * URL API v5 for sandbox
     *
     * @var string
     */
    protected const sandboxApi = 'https://api-sandbox.direct.yandex.com/json/v5/';

    /**
     * Default session options:
     *
     * - token:         The OAuth token of the Yandex.Direct user on whose
     *                  behalf the request to the API is made.
     *
     * - client:        Login advertiser - client advertising agency.
     *                  Mandatory if the request is made on behalf of the agency.
     *
     * - language:      The language of response messages.
     *                  In the selected language, textual explanations of the statuses of the objects,
     *                  the texts of errors and warnings are returned.
     *
     * - sandbox:       Sandbox mode.
     *
     * - operatorUnits: The mode in which the points of the agency, and not the advertiser,
     *                  are spent when executing the request.
     *
     * - logFile:       Log file.
     *
     * @var array
     */
    protected const defaultOptions = [
        'token' => '',
        'client' => '',
        'language' => 'en',
        'sandbox' => false,
        'operatorUnits' => false,
        'logFile' => null
    ];

    /**
     * Custom API call handler.
     *
     * @var null
     */
    public static $callHandler = null;

    /**
     * Session initialization.
     *
     * @param string $token
     * @param array $options
     */
    public static function init(string $token, array $options = [])
    {
        $options['token'] = $token;
        static::reset($options);
    }

    /**
     * Sets OAuth token.
     *
     * @param string $token
     */
    public static function setToken(string $token)
    {
        $_ENV['YD_SESSION_TOKEN'] = $token;
    }

    /**
     * Sets login advertiser - client advertising agency.
     *
     * @param string $client
     */
    public static function setClient(string $client)
    {
        $_ENV['YD_SESSION_CLIENT'] = $client;
    }

    /**
     * Sets language of response messages.
     *
     * @param string $language
     */
    public static function setLanguage(string $language)
    {
        $_ENV['YD_SESSION_LANGUAGE'] = $language;
    }

    /**
     * Switch on/off sandbox mode.
     *
     * @param bool $switch
     */
    public static function useSandbox(bool $switch)
    {
        $_ENV['YD_SESSION_SANDBOX'] = (string) $switch;
    }

    /**
     * Switch on/off mode in which the points of the agency,
     * and not the advertiser are spent when executing the request.
     *
     * @param bool $switch
     */
    public static function useOperatorUnits(bool $switch)
    {
        $_ENV['YD_SESSION_OPERATOR_UNITS'] = (string) $switch;
    }

    /**
     * Switch on/off logging to file
     *
     * @param bool $switch
     * @param string|null $pathToFile
     */
    public static function useLogFile(bool $switch, string $pathToFile = null)
    {
        if ($switch){
            $_ENV['YD_SESSION_LOG_FILE'] = $pathToFile ?? '';
        } else {
            $_ENV['YD_SESSION_LOG_FILE'] = '';
        }
    }

    /**
     * Retrieve OAuth token.
     *
     * @return string
     */
    public static function getToken()
    {
        if (!empty($_ENV['YD_SESSION_TOKEN']) and is_string($_ENV['YD_SESSION_TOKEN'])){
            return $_ENV['YD_SESSION_TOKEN'];
        }

        return static::defaultOptions['token'];
    }

    /**
     * Retrieve login advertiser - client advertising agency.
     *
     * @return string
     */
    public static function getClient()
    {
        if (!empty($_ENV['YD_SESSION_CLIENT']) and is_string($_ENV['YD_SESSION_CLIENT'])){
            return $_ENV['YD_SESSION_CLIENT'];
        }

        return static::defaultOptions['client'];
    }

    /**
     * Retrieve language of response messages.
     *
     * @return string
     */
    public static function getLanguage()
    {
        if (!empty($_ENV['YD_SESSION_LANGUAGE']) and is_string($_ENV['YD_SESSION_LANGUAGE'])){
            return $_ENV['YD_SESSION_LANGUAGE'];
        }

        return static::defaultOptions['language'];
    }

    /**
     * Returns [true] if sandbox mode is used, otherwise [false].
     *
     * @return bool
     */
    public static function usedSandbox()
    {
        if (!empty($_ENV['YD_SESSION_SANDBOX']) and ($_ENV['YD_SESSION_SANDBOX'] === '1' or $_ENV['YD_SESSION_SANDBOX'] === 'true')){
            return true;
        }

        return static::defaultOptions['sandbox'];
    }

    /**
     * Returns [true] if mode in which the points of the agency, and not the advertiser
     * are spent when executing the request is enable, otherwise [false].
     *
     * @return bool
     */
    public static function usedOperatorUnits()
    {
        if (!empty($_ENV['YD_SESSION_OPERATOR_UNITS']) and ($_ENV['YD_SESSION_OPERATOR_UNITS'] === '1' or $_ENV['YD_SESSION_OPERATOR_UNITS'] === 'true')){
            return true;
        }

        return static::defaultOptions['operatorUnits'];
    }

    /**
     * Returns path to the file for recording logs.
     * If no file is specified, [NULL] will be returned.
     *
     * @return string|null
     */
    public static function getLogFile()
    {
        if (!empty($_ENV['YD_SESSION_LOG_FILE']) and is_string($_ENV['YD_SESSION_LOG_FILE'])){
            return $_ENV['YD_SESSION_LOG_FILE'];
        } else {
            return static::defaultOptions['logFile'];
        }
    }

    /**
     * Set options
     *
     * @param array $options
     */
    public static function set(array $options)
    {
        foreach ($options as $option => $value){
            switch ($option){
                case 'token': static::setToken($value); break;
                case 'client': static::setClient($value); break;
                case 'language': static::setLanguage($value); break;
                case 'sandbox': static::useSandbox($value); break;
                case 'operatorUnits': static::useOperatorUnits($value); break;
                case 'logFile': static::useLogFile(!is_null($value), $value); break;
            }
        }
    }

    /**
     * Reset options
     *
     * @param array $options
     */
    public static function reset(array $options)
    {
        if (isset($options['token'])){
            static::setToken($options['token']);
        } else {
            static::setToken(static::defaultOptions['token']);
        }

        if (isset($options['client'])){
            static::setClient($options['client']);
        } else {
            static::setClient(static::defaultOptions['client']);
        }

        if (isset($options['language'])){
            static::setLanguage($options['language']);
        } else {
            static::setLanguage(static::defaultOptions['language']);
        }

        if (isset($options['sandbox'])){
            static::useSandbox($options['sandbox']);
        } else {
            static::useSandbox(static::defaultOptions['sandbox']);
        }

        if (isset($options['operatorUnits'])){
            self::useOperatorUnits($options['operatorUnits']);
        } else {
            self::useOperatorUnits(static::defaultOptions['operatorUnits']);
        }

        if (isset($options['logFile'])){
            self::useLogFile(!is_null($options['logFile']), $options['logFile']);
        } else {
            self::useLogFile(false);
        }
    }

    /**
     * Fetch all options.
     *
     * @return array
     */
    public static function fetch()
    {
        return [
            'token' => static::getToken(),
            'client' => static::getClient(),
            'language' => static::getLanguage(),
            'sandbox' => static::usedSandbox(),
            'operatorUnits' => static::usedOperatorUnits(),
            'logFile' => static::getLogFile()
        ];
    }

    /**
     * Call to services API.
     *
     * @param string $service API service name
     * @param string $method API service method
     * @param array $params API service parameters
     * @return Result
     */
    public static function call($service, $method, $params = []): Result
    {
        if (key_exists('SelectionCriteria', $params)){
            $params['SelectionCriteria'] = (object) $params['SelectionCriteria'];
        }

        $url = (static::usedSandbox() ? static::sandboxApi : static::api).$service;
        $params = json_encode(['method' => (string) $method,'params' => $params], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $requestID = str_replace(['.',' '], '', microtime());

        static::requestLogging($requestID, $url, $params);

        if (is_null(static::$callHandler)){

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . static::getToken(),
                'Accept-Language: ' . static::getLanguage(),
                'Client-Login: ' . static::getClient(),
                'Use-Operator-Units: ' . static::usedOperatorUnits(),
                'Content-Type: application/json; charset=utf-8'
            ));

            try {
                $result = new Result($curl);
            } catch (RequestException $exception){
                static::exceptionLogging($requestID, $exception);
                throw $exception;
            }

        } else {

            try {
                $result = call_user_func(static::$callHandler, $service, $method, $params);
            } catch (Exception $exception){
                static::exceptionLogging($requestID, $exception);
                throw $exception;
            }

        }

        static::responseLogging($requestID, $result);
        static::errorLogging($requestID, $result);
        static::warningLogging($requestID, $result);

        return $result;
    }

    /**
     * Logging information about the request.
     *
     * @param $requestID
     * @param $url
     * @param $params
     */
    protected static function requestLogging($requestID, $url, $params): void
    {
        $logFile = static::getLogFile();

        if (is_null($logFile)){
            return;
        }

        $content = [
            $requestID,
            date('Y-m-d H:i:s'),
            'request',
            'sandbox: ' . static::usedSandbox(),
            'client: ' . static::getClient(),
            'url: ' . $url,
            'params' . $params

        ];

        try {
            File::bind($logFile)->append(implode("\t", $content) . "\n");
        } catch (Exception $error) {
            throw RuntimeException::make(static::class."::requestLogging. {$error->getMessage()}");
        }
    }

    /**
     * Logging information about the response.
     *
     * @param string $requestID
     * @param Result $result
     */
    protected static function responseLogging($requestID, Result $result): void
    {
        $logFile = static::getLogFile();

        if (is_null($logFile)){
            return;
        }

        $content = [
            $requestID,
            date('Y-m-d H:i:s'),
            'response',
            'sandbox: ' . static::usedSandbox(),
            'client: ' . static::getClient(),
            'requestId: ' . $result->requestId,
            'errors: ' . $result->errors->count(),
            'warnings: ' . $result->warnings->count(),
            'unitsUsedLogin: ' . $result->unitsUsedLogin,
            'unitsSpent: ' . $result->unitsSpent,
            'unitsBalance: ' . $result->unitsBalance,
            'unitsLimit: ' . $result->unitsLimit

        ];

        try {
            File::bind($logFile)->append(implode("\t", $content) . "\n");
        } catch (Exception $error) {
            throw RuntimeException::make(static::class."::responseLogging. {$error->getMessage()}");
        }
    }

    /**
     * Logging information about fatal errors.
     *
     * @param string $requestID
     * @param Exception $exception
     */
    protected static function exceptionLogging($requestID, Exception $exception): void
    {
        $logFile = static::getLogFile();

        if (is_null($logFile)){
            return;
        }

        $content = [
            $requestID,
            date('Y-m-d H:i:s'),
            'fatal error',
            'sandbox: ' . static::usedSandbox(),
            'client: ' . static::getClient(),
            'code: ' . $exception->getCode(),
            'message: ' . $exception->getMessage()
        ];

        try {
            File::bind($logFile)->append(implode("\t", $content) . "\n");
        } catch (Exception $error) {
            throw RuntimeException::make(static::class."::exceptionLogging. {$error->getMessage()}");
        }
    }

    /**
     * Logging error information when executing a request.
     *
     * @param string $requestID
     * @param Result $result
     */
    protected static function errorLogging($requestID, Result $result): void
    {
        $logFile = static::getLogFile();

        if (is_null($logFile) or $result->errors->isEmpty()){
            return;
        }

        $logFile = File::bind($logFile);
        $time = date('Y-m-d H:i:s');
        $sandbox = 'sandbox: ' . static::usedSandbox();
        $client = 'client: ' . static::getClient();

        $result->errors->each(function($errors) use ($requestID, $logFile, $time, $sandbox, $client){
            foreach ($errors as $error){

                $content = [
                    $requestID,
                    $time,
                    'error',
                    'sandbox: ' . $sandbox,
                    'client: ' . $client,
                    'code: ' . $error['code'],
                    'message: ' . $error['message'] . (empty($error['detail']) ? '' : $error['detail'] . '.')
                ];

                try {
                    $logFile->append(implode("\t", $content) . "\n");
                } catch (Exception $error) {
                    throw RuntimeException::make(static::class."::errorLogging. {$error->getMessage()}");
                }
            }
        });
    }

    /**
     * Logging warning information when executing a request.
     *
     * @param string $requestID
     * @param Result $result
     */
    protected static function warningLogging($requestID, Result $result): void
    {
        $logFile = static::getLogFile();

        if (is_null($logFile) or $result->errors->isEmpty()){
            return;
        }

        $logFile = File::bind($logFile);
        $time = date('Y-m-d H:i:s');
        $sandbox = 'sandbox: ' . static::usedSandbox();
        $client = 'client: ' . static::getClient();

        $result->warnings->each(function($warnings) use ($requestID, $logFile, $time, $sandbox, $client){
            foreach ($warnings as $warning){

                $content = [
                    $requestID,
                    $time,
                    'warning',
                    'sandbox: ' . $sandbox,
                    'client: ' . $client,
                    'code: ' . $warning['code'],
                    'message: ' . $warning['message'] . (empty($warning['detail']) ? '' : $warning['detail'] . '.')
                ];

                try {
                    $logFile->append(implode("\t", $content) . "\n");
                } catch (Exception $error) {
                    throw RuntimeException::make(static::class."::warningLogging. {$error->getMessage()}");
                }
            }
        });
    }
}