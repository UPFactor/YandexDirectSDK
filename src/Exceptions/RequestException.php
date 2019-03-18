<?php

namespace YandexDirectSDK\Exceptions;

use YandexDirectSDK\Common\Str;

class RequestException extends BaseException
{
    /**
     * @return RequestException
     */
    public static function internalServerError()
    {
        return new static('Internal server error.');
    }

    /**
     * @return RequestException
     */
    public static function requestTimeout()
    {
        return new static('Request timeout.');
    }

    /**
     * @param string $message
     * @param string|null $response
     * @return RequestException
     */
    public static function badRequest(string $message, $response = null)
    {
        $message = Str::after("Bad request. {$message}", '.');

        if (is_string($response)){
            $message .= " Server response content: [{$response}].";
        }

        return new static($message);
    }

    /**
     * @param string $message
     * @param string|null $response
     * @return RequestException
     */
    public static function invalidResponse(string $message, $response = null)
    {
        $message = Str::after("Invalid server response. {$message}", '.');

        if (is_string($response)){
            $message .= " Server response content: [{$response}].";
        }

        return new static($message);
    }

    /**
     * @param string $message
     * @param string|null $response
     * @return RequestException
     */
    public static function unknown(string $message, $response = null){
        $message = Str::after("Unknown error. {$message}", '.');

        if (is_string($response)){
            $message .= " Server response content: [{$response}].";
        }

        return new static($message);
    }
}