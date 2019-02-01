<?php

namespace YandexDirectSDK;

/**
 * Class Result
 *
 * @property-read integer       code
 * @property-read array         header
 * @property-read null|array    data
 * @property-read array         error
 * @property-read boolean       isSuccess
 * @property-read boolean       isError
 *
 * @package YandexDirectSDK
 */
class Result
{
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
     * Response data.
     *
     * @var array|null
     */
    protected $data = null;

    /**
     * Error information:
     *
     *   - id:      Error code;
     *   - string:  Error text;
     *   - detail:  Detailed description of the error.
     *
     * @var array
     */
    protected $error = [];

    /**
     * Create Result instance.
     *
     * @param resource $resource
     */
    public function __construct($resource){

        if (!is_resource($resource)) {
            $this->setError([
                'string' => 'cURL Error'
            ]);
            return;
        }

        if (!($response = curl_exec($resource))) {
            $this->setError([
                'string' => 'cURL Error',
                'detail' => curl_error($resource)
            ]);
            return;
        }

        $responseHeadersSize = curl_getinfo($resource, CURLINFO_HEADER_SIZE);
        $this->setCode(curl_getinfo($resource, CURLINFO_RESPONSE_CODE));
        $this->setData(substr($response, $responseHeadersSize));
        $this->setHeader(substr($response, 0, $responseHeadersSize));
    }

    /**
     * Dynamic call of object instance properties.
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name){
        switch ($name){
            case 'code': return $this->code; break;
            case 'header': return $this->header; break;
            case 'data': return $this->data; break;
            case 'error': return $this->error; break;
            case 'isSuccess': return (empty($this->error) and is_array($this->data)); break;
            case 'isError': return !empty($this->error); break;
            default: return null;
        }
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
            'data' => $this->data,
            'error' => $this->error
        );
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
     * @param string $data
     * @return $this
     */
    protected function setData($data){
        $data = json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE){
            $this->setError([
                'string' => 'Request failed'
            ]);
            $this->data = null;
            return $this;
        }

        if (isset($data['error'])){
            $this->setError($data['error']);
            $this->data = null;
            return $this;
        }

        $this->data = $data;

        return $this;
    }

    /**
     * Sets the value [$this->error].
     *
     * @param array $error
     * @return $this
     */
    protected function setError(array $error){

        $this->error = array(
            'id' => 0,
            'code' => 0,
            'string' => 'Unknown error',
            'detail' => ''
        );

        if (empty($error)) {
            return $this;
        };

        foreach ($error as $k => $v){
            $k = str_replace(array('error_','request_'),'',$k);
            switch ($k){
                case 'id':
                    $this->error['id'] = (integer) $v;
                    break;
                case 'code':
                    $this->error['code'] = (integer) $v;
                    break;
                case 'string':
                    $this->error['string'] = (string) $v;
                    break;
                case 'detail':
                    $this->error['detail'] = (string) $v;
                    break;
                default: unset($error[$k]);
            }
        }

        return $this;
    }
}