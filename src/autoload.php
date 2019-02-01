<?php

function UPFYandexDirectSDK($className){
    if (strncmp('YandexDirectSDK', $className, 15) === 0) {
        $path = dirname(__FILE__) . str_replace('\\', '/', substr($className, 15)) . '.php';
        if (file_exists($path)) {
            require $path;
        }
    } else {
        return;
    }
}

spl_autoload_register('UPFYandexDirectSDK');
