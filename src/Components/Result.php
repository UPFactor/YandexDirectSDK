<?php

namespace YandexDirectSDK\Components;

use Exception;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
/**
 * Class Result
 *
 * @property-read string                                        $response
 * @property-read Data                                          $data
 * @property-read ModelInterface|ModelCollectionInterface       $resource
 * @property-read string                                        $code
 * @property-read array                                         $header
 * @property-read Data                                          $errors
 * @property-read Data                                          $warnings
 *
 * @package YandexDirectSDK\Components
 */
class Result
{
    /**
     * Original API response.
     *
     * @var string
     */
    protected $response;

    /**
     * Response code.
     *
     * @var int
     */
    protected $code = 0;

    /**
     * Response header parameters.
     *
     * @var array
     */
    protected $header = [];

    /**
     * Result of the API response.
     *
     * @var Data
     */
    protected $data;

    /**
     * Result related resources.
     *
     * @var ModelInterface|ModelCollectionInterface
     */
    protected $resource;

    /**
     * Error stack.
     *
     * @var Data
     */
    protected $errors;

    /**
     * Warning stack.
     *
     * @var Data
     */
    protected $warnings;

    /**
     * Create Result instance.
     * @param resource $resource
     * @throws Exception
     */
    public function __construct($resource){

        if (!is_resource($resource)) {
            throw new Exception('cURL Error.');
        }

        if (!($response = curl_exec($resource))) {
            throw new Exception('cURL Error. ' . curl_error($resource));
        }

        $this->response = $response;
        $this->data = new Data();
        $this->errors = new Data();
        $this->warnings = new Data();

        $responseHeadersSize = curl_getinfo($resource, CURLINFO_HEADER_SIZE);
        $this->setCode(curl_getinfo($resource, CURLINFO_RESPONSE_CODE));
        $this->setResult(substr($response, $responseHeadersSize));
        $this->setHeader(substr($response, 0, $responseHeadersSize));
    }

    /**
     * Dynamic call of object properties.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     * Get the value of all properties.
     *
     * @return array
     */
    public function fetch(){
        return array(
            'code' => $this->code,
            'header' => $this->header,
            'data' => $this->data->all(),
            'errors' => $this->errors->all(),
            'warnings' => $this->warnings->all()
        );
    }

    /**
     * Sets the value [$this->resource].
     *
     * @param ModelCommonInterface|ModelInterface|ModelCollectionInterface $resource
     * @return $this
     */
    public function setResource(ModelCommonInterface $resource){
        $this->resource = $resource;
        return $this;
    }

    /**
     * Sets the value [$this->code].
     *
     * @param string|integer $code
     * @return $this
     */
    protected function setCode($code){
        $this->code = (integer) $code;
        return $this;
    }

    /**
     * Sets the value [$this->header].
     *
     * @param string $header
     * @return $this
     */
    protected function setHeader($header){

        $this->header = [];

        foreach (explode("\n", $header) as $item){
            if (empty(($item = trim($item)))) {
                continue;
            }

            if (preg_match('/^HTTP\/\d.\d\s+\d{3}\s+[a-z\s]+$/i', $item)) {
                continue;
            }

            $item = explode(":", $item, 2);
            $this->header[trim($item[0])] = trim($item[1]);
        }

        return $this;
    }

    /**
     * Sets the value [$this->data].
     *
     * @param string $result
     * @return $this
     * @throws Exception
     */
    protected function setResult($result){
        $result = json_decode($result, true);
        $warnings = [];
        $errors = [];

        if (json_last_error() !== JSON_ERROR_NONE){
            throw new Exception('Invalid server response format.');
        }

        if (isset($result['error'])){
            $error = $this->parseError($result['error']);
            throw new Exception($error['message'] . '. ' . (empty($error['detail']) ? '' : $error['detail'] . '.'), $error['code']);
        }

        if (array_key_exists('result', $result)){
            $result = $result['result'];
        }

        foreach ($result as $resultItemKey => $resultItemValue){
            if (!is_array($resultItemValue)){
                continue;
            }

            if (strpos($resultItemKey,'Results') === false){
                continue;
            }

            foreach ($resultItemValue as $key => $value){

                if (!is_array($value)){
                    continue;
                }

                if (array_key_exists('Warnings', $value)){
                    foreach ($value['Warnings'] as $warning){
                        $warnings[$key][] = $this->parseError($warning);
                    }
                }

                if (array_key_exists('Errors', $value)){
                    foreach ($value['Errors'] as $error){
                        $errors[$key][] = $this->parseError($error);
                    }
                }
            }
        }

        $this->data->reset($result);
        $this->warnings->reset($warnings);
        $this->errors->reset($errors);

        return $this;
    }

    /**
     * Parsing errors.
     * Converts an array of error or warning information to the specified format.
     *
     * @param $sourceError
     * @return array
     */
    protected function parseError($sourceError){
        $error = array(
            'code' => 0,
            'message' => 'Unknown error',
            'detail' => ''
        );

        if (empty($sourceError)) {
            return $error;
        };

        foreach ($sourceError as $k => $v){
            $k = str_replace(array('error_','request_'),'',$k);
            $k = strtolower($k);
            switch ($k){
                case 'code':
                    $error['code'] = (integer) $v;
                    break;
                case 'message':
                case 'string':
                    $error['message'] = (string) $v;
                    break;
                case 'details':
                case 'detail':
                    $error['detail'] = (string) $v;
                    break;
            }
        }

        return $error;
    }

}