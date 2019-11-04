<?php

if (!function_exists('UPFactorYandexDirectSDKAutoload')){
    function UPFactorYandexDirectSDKAutoload($className)
    {
        if (strncmp('YandexDirectSDKTest', $className, 19) === 0){
            $path = dirname(dirname(__FILE__)) .
                DIRECTORY_SEPARATOR . 'tests' .
                str_replace('\\', DIRECTORY_SEPARATOR, substr($className, 19)) . '.php';
        } elseif (strncmp('YandexDirectSDK', $className, 15) === 0) {
            $path = dirname(__FILE__) .
                str_replace('\\', DIRECTORY_SEPARATOR, substr($className, 15)) . '.php';
        } else {
            return;
        }

        if (file_exists($path)) {
            require $path;
        }
    }

    spl_autoload_register('UPFactorYandexDirectSDKAutoload');
}
