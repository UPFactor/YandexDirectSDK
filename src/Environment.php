<?php


namespace YandexDirectSDK;

/**
 * Class Environment
 *
 * @package YandexDirectSDK
 */
class Environment
{
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
     * Set options
     *
     * @param array $options
     */
    public static function set(array $options)
    {
        if (isset($options['token'])){
            self::setToken($options['token']);
        } else {
            self::setToken('');
        }

        if (isset($options['client'])){
            self::setClient($options['client']);
        } else {
            self::setClient('');
        }

        if (isset($options['language'])){
            self::setLanguage($options['language']);
        } else {
            self::setLanguage('en');
        }

        if (isset($options['sandbox'])){
            self::useSandbox($options['sandbox']);
        } else {
            self::useSandbox(false);
        }

        if (isset($options['operatorUnits'])){
            self::useOperatorUnits($options['operatorUnits']);
        } else {
            self::useOperatorUnits(false);
        }

        if (isset($options['logFile'])){
            self::useLogFile(true, $options['logFile']);
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
        if (!empty($_ENV['YD_SESSION_TOKEN']) and is_string($_ENV['YD_SESSION_TOKEN'])){
            $options['token'] = $_ENV['YD_SESSION_TOKEN'];
        } else {
            $options['token'] = '';
        }

        if (!empty($_ENV['YD_SESSION_CLIENT']) and is_string($_ENV['YD_SESSION_CLIENT'])){
            $options['client'] = $_ENV['YD_SESSION_CLIENT'];
        } else {
            $options['client'] = '';
        }

        if (!empty($_ENV['YD_SESSION_LANGUAGE']) and is_string($_ENV['YD_SESSION_LANGUAGE'])){
            $options['language'] = $_ENV['YD_SESSION_LANGUAGE'];
        } else {
            $options['language'] = 'en';
        }

        if (!empty($_ENV['YD_SESSION_SANDBOX']) and ($_ENV['YD_SESSION_SANDBOX'] === '1' or $_ENV['YD_SESSION_SANDBOX'] === 'true')){
            $options['sandbox'] = true;
        } else {
            $options['sandbox'] = false;
        }

        if (!empty($_ENV['YD_SESSION_OPERATOR_UNITS']) and ($_ENV['YD_SESSION_OPERATOR_UNITS'] === '1' or $_ENV['YD_SESSION_OPERATOR_UNITS'] === 'true')){
            $options['operatorUnits'] = true;
        } else {
            $options['operatorUnits'] = false;
        }

        if (!empty($_ENV['YD_SESSION_LOG_FILE']) and is_string($_ENV['YD_SESSION_LOG_FILE'])){
            $options['logFile'] = $_ENV['YD_SESSION_LOG_FILE'];
        } else {
            $options['logFile'] = null;
        }

        return $options;
    }
}