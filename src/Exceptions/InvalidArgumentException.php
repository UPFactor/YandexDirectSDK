<?php

namespace YandexDirectSDK\Exceptions;

class InvalidArgumentException extends BaseException
{
    /**
     * @param string $function
     * @param string $argument
     * @param array|string|null $expected
     * @param string|null $actual
     * @return static
     */
    public static function invalidType($function, $argument = null, $expected = null, string $actual = null){
        if (is_null($argument)){
            $message = "{$function}. Invalid type of argument.";
        } else {
            $message = "{$function}. Invalid type of argument [$argument].";
        }

        if (!is_null($expected)){
            $expected = is_array($expected) ? implode('|', $expected) : strval($expected);
            $actual = is_null($actual) ? '' : strval($actual);
            $message = "{$message} Expected type [{$expected}], [{$actual}] given.";
        }

        return new static($message);
    }
}