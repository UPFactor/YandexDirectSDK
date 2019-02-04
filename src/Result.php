<?php

namespace YandexDirectSDK;

/**
 * Class Result
 *
 * @property-read Session       session
 * @property-read string        response
 * @property-read integer       code
 * @property-read array         header
 * @property-read null|array    data
 * @property-read array         error
 *
 * @method array                all()
 * @method integer              count()
 * @method boolean              isEmpty()
 * @method array                keys()
 * @method array                values()
 * @method array                dot()
 * @method string               serialize()
 * @method string               json()
 * @method Data|mixed           get($keys, $default = null)
 * @method boolean              has($keys, $strict = false)
 * @method Data                 only($keys, $strict = false)
 * @method Data                 except($keys)
 * @method Data                 map(callable $callable, $context = null)
 * @method void                 each(callable $callable, $context = null)
 * @method Data                 filter(callable $callable, $context = null)
 * @method Data                 pluck($keys)
 * @method Data                 group($condition)
 * @method Data                 chunk($size)
 * @method Data                 where($key, $operator = null, $value = null)
 * @method Data                 whereIn($key, $values, $strict = false)
 * @method Data                 whereNotIn($key, $values, $strict = false)
 * @method mixed                max($key = null)
 * @method mixed                min($key = null)
 * @method float|int            avg($key = null)
 * @method float|int            sum($key = null)
 *
 * @package YandexDirectSDK
 */
class Result
{
    /**
     * Session instance.
     *
     * @var Session
     */
    protected $session;

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
     * Response data.
     *
     * @var array|null
     */
    protected $data = [];

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
     * @param Session $session
     * @param resource $resource
     */
    public function __construct(Session $session, $resource){

        $this->session = $session;

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

        $this->response = $response;

        $responseHeadersSize = curl_getinfo($resource, CURLINFO_HEADER_SIZE);
        $this->setCode(curl_getinfo($resource, CURLINFO_RESPONSE_CODE));
        $this->setData(substr($response, $responseHeadersSize));
        $this->setHeader(substr($response, 0, $responseHeadersSize));
    }

    /**
     * Dynamic call of properties of the current object.
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name){
        return $this->{$name};
    }

    /**
     * Dynamic call methods of Data.
     *
     * @param $method
     * @param $arguments
     * @return Data|mixed
     */
    public function __call($method, $arguments){
        return Data::wrap($this->data)->{$method}(...$arguments);
    }

    /**
     * Determine whether the result is successful.
     *
     * @param callable $callable
     * @return bool
     */
    public function isSuccess(callable $callable = null){
        if (empty($this->error) and !empty($this->data)){
            if (!is_null($callable)){
                $callable($this);
            }
            return true;
        }

        return false;
    }

    /**
     * Determine if the result is a failure.
     *
     * @param callable $callable
     * @return bool
     */
    public function isError(callable $callable = null){
        if (!empty($this->error)){
            if (!is_null($callable)){
                $callable($this);
            }
            return true;
        }

        return false;
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
            $this->data = [];
            return $this;
        }

        if (isset($data['error'])){
            $this->setError($data['error']);
            $this->data = [];
            return $this;
        }

        if (array_key_exists('result', $data)){
            $data = $data['result'];
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