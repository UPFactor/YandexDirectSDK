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
        $_ENV['YD_SESSION_SANDBOX'] = (int) $switch;
    }

    /**
     * Switch on/off mode in which the points of the agency,
     * and not the advertiser are spent when executing the request.
     *
     * @param bool $switch
     */
    public static function useOperatorUnits(bool $switch)
    {
        $_ENV['YD_SESSION_OPERATOR_UNITS'] = (int) $switch;
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
     * Reset options
     *
     * @param array $options
     */
    public static function reset(array $options)
    {
        foreach ($options as $option => $value){
            switch ($option){
                case 'token': self::setToken($value); break;
                case 'client': self::setClient($value); break;
                case 'language': self::setLanguage($value); break;
                case 'sandbox': self::useSandbox($value); break;
                case 'operatorUnits': self::useOperatorUnits($value); break;
                case 'logFile': self::useLogFile(true, $value); break;
            }
        }
    }

    /**
     * Get all options.
     *
     * @return array
     */
    public static function fetch()
    {
        return [
            'token' => $_ENV['YD_SESSION_TOKEN'] ?? '',
            'client' => $_ENV['YD_SESSION_CLIENT'] ?? '',
            'language' => $_ENV['YD_SESSION_LANGUAGE'] ?? 'en',
            'sandbox' => $_ENV['YD_SESSION_SENDBOX'] ?? false,
            'operatorUnits' => $_ENV['YD_SESSION_OPERATOR_UNITS'] ?? true,
            'logFile' => empty($_ENV['YD_SESSION_LOG_FILE']) ? null : $_ENV['YD_SESSION_LOG_FILE']
        ];
    }
}