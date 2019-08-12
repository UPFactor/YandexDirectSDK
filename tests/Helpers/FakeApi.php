<?php

namespace YandexDirectSDKTest\Helpers;

use Exception;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Common\File;
use YandexDirectSDK\Common\Str;
use YandexDirectSDK\Components\Data;

class FakeApi
{
    /**
     * @param string $apiPath
     * @param string $key
     * @return mixed
     */
    public static function get(string $apiPath, string $key = null)
    {
        $apiPath = str_replace(['\\','/'], DIRECTORY_SEPARATOR, $apiPath);
        $apiPath = Str::end($apiPath, '.api');
        $apiPath = Env::getDataPath($apiPath);
        $apiFile = File::bind($apiPath);
        $apiContent = $apiFile->content();

        if (Str::isJSON($apiContent)) {

            $apiContent = json_decode($apiContent, true);

        } else {

            if (preg_match_all('/\((.*?)\)(, \.{3})?/', $apiContent, $segments)){
                foreach ($segments[0] as $index => $lexeme){
                    $string = trim($segments[1][$index]);
                    $isMultiple = !empty($segments[2][$index]);

                    if (strpos($string, '|') !== false){
                        $string = static::enumGenerate($string, $isMultiple);
                    } else {
                        switch ($string){
                            case 'decimal': $string = static::decimalGenerate($isMultiple); break;
                            case 'int': $string = static::intGenerate($isMultiple); break;
                            case 'long': $string = static::longGenerate($isMultiple); break;
                            case 'string': $string = static::stringGenerate($isMultiple); break;
                            case 'base64Binary': $string = static::stringGenerate($isMultiple); break;
                        }
                    }

                    $apiContent = Str::replaceFirst($lexeme, $string, $apiContent);
                }
            }

            $apiContent = preg_replace('/\/\*.*?\*\//i', '', $apiContent);
            $apiContent = preg_replace('/\},\s*\.{3}\s*]/i', '}]', $apiContent);
            $apiContent = str_replace('...', '', $apiContent);

            if (Str::isJSON($apiContent)){
                $apiContent = json_decode($apiContent, true);
                $apiFile->put(json_encode($apiContent, JSON_PRETTY_PRINT));
            } else {
                throw new Exception('File API [' . $apiFile->path . '], has invalid content');
            }
        }

        if (!is_array($apiContent)){
            throw new Exception('File API [' . $apiFile->path . '], has invalid content');
        }

        return is_null($key) ? $apiContent : Arr::get($apiContent, $key);
    }

    /**
     * @param string $apiPath
     * @param string $key
     * @return string
     */
    public static function getJson(string $apiPath, string $key = null): string
    {
        return json_encode(static::get($apiPath, $key), JSON_PRETTY_PRINT);
    }

    /**
     * @param $apiPath
     * @param string $key
     * @return Data
     */
    public static function getData($apiPath, string $key = null): Data
    {
        return Data::make(static::get($apiPath, $key));
    }

    /**
     * @param string $content
     * @param bool $isMultiple
     * @return array|mixed
     */
    protected static function enumGenerate(string $content, bool $isMultiple = false)
    {
        $content = str_replace( ' ', '', $content);
        $content = explode('|', $content);

        foreach ($content as $index => $item){
            $item = trim($item);
            if ($item === '...'){
                unset($content[$index]);
                continue;
            }
            $item = Str::begin($item, '"');
            $item = Str::end($item, '"');
            $content[$index] = $item;
        }

        return $isMultiple ? implode(', ', $content) : Arr::first($content, '');
    }

    /**
     * @param bool $isMultiple
     * @return string
     */
    protected static function decimalGenerate(bool $isMultiple = false)
    {
        static $value = 100.10;
        $value++;
        return $isMultiple ? $value.', '.static::decimalGenerate() : (string) $value;
    }

    /**
     * @param bool $isMultiple
     * @return string
     */
    protected static function intGenerate(bool $isMultiple = false)
    {
        static $value = 10000;
        $value++;
        return $isMultiple ? $value.', '.static::intGenerate() : (string) $value;
    }

    /**
     * @param bool $isMultiple
     * @return string
     */
    protected static function longGenerate(bool $isMultiple = false)
    {
        static $value = 1000000;
        $value++;
        return $isMultiple ? $value.', '.static::longGenerate() : (string) $value;
    }

    /**
     * @param bool $isMultiple
     * @return string
     */
    protected static function stringGenerate(bool $isMultiple = false)
    {
        static $value = 1;
        $string = 'This is string #' . (string)(++$value);

        return $isMultiple ? '"' . $string . '", '.static::stringGenerate() : '"' . $string . '"';
    }
}