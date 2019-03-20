<?php

namespace YandexDirectSDK\Exceptions;

use YandexDirectSDK\Common\Str;

class RequestException extends BaseException
{
    /**
     * @param integer $code
     * @param string $message
     * @param string $detail
     * @return static
     */
    public static function badRequest($code, string $message, string $detail = '')
    {
        $code = intval($code);
        $message = Str::end(trim($message), '.');
        $detail = trim($detail);

        return new static(
            empty($detail) ? $message : ("{$message} " . Str::end($detail,'.')),
            $code
        );
    }

    /**
     * @param string $message
     * @param string $response
     * @return static
     */
    public static function badResponse(string $message, string $response = '')
    {
        $message = Str::end(trim($message), '.');
        $response = trim($response);

        return new static(
            "Unsupported data type. " . (empty($response) ? $message : "{$message} Server response: {$response}"),
            415
        );
    }

    /**
     * @return static
     */
    public static function requestTimeout()
    {
        return new static(
            'Request timeout. Request processing time has exceeded the server limit.',
            502
        );
    }

    /**
     * @return static
     */
    public static function internalApiError()
    {
        return new static(
            'Internal error of the Yandex.Direct API service. Try calling the method later. If the error persists, contact the support service.',
            500
        );
    }

    /**
     * @param string $response
     * @return static
     */
    public static function unknownError(string $response = '')
    {
        return new static(
            "Unknown error. " . (empty($response) ? '' : "Server response: {$response}"),
            520
        );
    }
}