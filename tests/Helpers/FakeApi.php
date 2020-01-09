<?php

namespace YandexDirectSDKTest\Helpers;

use Exception;
use UPTools\Arr;
use UPTools\File;
use UPTools\Str;
use YandexDirectSDK\Components\Data;

class FakeApi
{
    protected $apiPath = null;

    /**
     * FakeApi static constructor.
     *
     * @param string $apiPath
     * @return static
     */
    public static function make(string $apiPath)
    {
        return new static($apiPath);
    }

    /**
     * FakeApi constructor.
     *
     * @param string $apiPath
     */
    public function __construct(string $apiPath)
    {
        $this->apiPath = $apiPath;
    }

    /**
     * @param string $key
     * @return array|mixed|object|null
     * @throws Exception
     */
    public function getAsObject(string $key = null)
    {
        $object = $this->get($this->apiPath);

        if (is_null($key)){
            return $object;
        }

        foreach (explode('.', $key) as $key){
            if(is_object($object) and isset($object->{$key})){
                $object = $object->{$key};
            } elseif (is_array($object) and isset($object[$key])) {
                $object = $object[$key];
            } else {
                return null;
            }
        }

        return $object;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getAsJson(string $key = null)
    {
        return json_encode($this->getAsObject($key));
    }

    /**
     * @param string $key
     * @return array|mixed|null
     */
    public function getAsArray(string $key = null)
    {
        $array = json_decode(json_encode($this->get($this->apiPath)), true);
        return is_null($key) ? $array : Arr::get($array, $key);
    }

    /**
     * @param string $key
     * @return Data
     */
    public function getAsData(string $key = null)
    {
        return Data::make($this->getAsArray($key));
    }

    /**
     * @param string $apiPath
     * @return array|object
     */
    protected function get(string $apiPath)
    {
        $apiPath = str_replace(['\\','/'], DIRECTORY_SEPARATOR, $apiPath);
        $apiPath = Str::end($apiPath, '.api');
        $apiPath = Env::getDataPath($apiPath);
        $apiFile = File::bind($apiPath);
        $apiContent = $apiFile->content();

        if (Str::isJSON($apiContent)) {
            $apiContent = json_decode($apiContent);
        } else {
            if (preg_match_all('/\((.*?)\)(, \.{3})?/', $apiContent, $segments)){
                foreach ($segments[0] as $index => $lexeme){
                    $string = trim($segments[1][$index]);
                    $isMultiple = !empty($segments[2][$index]);

                    if (strpos($string, '|') !== false){
                        $string = $this->enumGenerate($string, $isMultiple);
                    } else {
                        switch ($string){
                            case 'decimal': $string = $this->decimalGenerate($isMultiple); break;
                            case 'int': $string = $this->intGenerate($isMultiple); break;
                            case 'long': $string = $this->longGenerate($isMultiple); break;
                            case 'string': $string = $this->stringGenerate($isMultiple); break;
                            case 'base64Binary': $string = $this->stringGenerate($isMultiple); break;
                        }
                    }

                    $apiContent = Str::replaceFirst($lexeme, $string, $apiContent);
                }
            }

            $apiContent = preg_replace('/\/\*.*?\*\//i', '', $apiContent);
            $apiContent = preg_replace('/\},\s*\.{3}\s*]/i', '}]', $apiContent);
            $apiContent = str_replace('...', '', $apiContent);

            if (Str::isJSON($apiContent)){
                $apiContent = json_decode($apiContent);
                $apiFile->put(json_encode($apiContent, JSON_PRETTY_PRINT));
            } else {
                throw new Exception('File API [' . $apiFile->path . '], has invalid content');
            }
        }

        return $apiContent;
    }

    /**
     * @param string $content
     * @param bool $isMultiple
     * @return array|mixed
     */
    protected function enumGenerate(string $content, bool $isMultiple = false)
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
    protected function decimalGenerate(bool $isMultiple = false)
    {
        static $value = 100.10;
        $value++;
        return $isMultiple ? $value.', '.static::decimalGenerate() : (string) $value;
    }

    /**
     * @param bool $isMultiple
     * @return string
     */
    protected function intGenerate(bool $isMultiple = false)
    {
        static $value = 10000;
        $value++;
        return $isMultiple ? $value.', '.static::intGenerate() : (string) $value;
    }

    /**
     * @param bool $isMultiple
     * @return string
     */
    protected function longGenerate(bool $isMultiple = false)
    {
        static $value = 1000000;
        $value++;
        return $isMultiple ? $value.', '.static::longGenerate() : (string) $value;
    }

    /**
     * @param bool $isMultiple
     * @return string
     */
    protected function stringGenerate(bool $isMultiple = false)
    {
        static $value = 1;
        $string = 'This is string #' . (string)(++$value);

        return $isMultiple ? '"' . $string . '", '.static::stringGenerate() : '"' . $string . '"';
    }
}