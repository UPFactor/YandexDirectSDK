<?php

namespace YandexDirectSDK\Exceptions;

use Exception;
use Throwable;

class BaseException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @return static
     */
    public static function make(string $message = "", int $code = 0, Throwable $previous = null){
        return new static(...func_get_args());
    }
}