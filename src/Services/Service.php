<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Result;
use YandexDirectSDK\Session;

/**
 * Class Service
 *
 * @package YandexDirectSDK\Services
 */
abstract class Service
{
    /**
     * Session instance.
     *
     * @var Session
     */
    protected $session;

    /**
     * Service name.
     *
     * @var string
     */
    protected $serviceName = '';

    /**
     * List of service methods.
     *
     * @var array
     */
    protected $methodList = array();

    /**
     * Create Service instance.
     *
     * @param Session $session
     */
    public function __construct(Session $session) {
        $this->session = $session;
        $this->serviceName = (string) $this->getServiceName();
        $this->methodList = (array) $this->getMethodList();
    }

    /**
     * Dynamic call to service methods.
     *
     * @param string $method
     * @param array $params
     * @return null|Result
     */
    public function __call($method, $params){
        if (in_array($method, (array) $this->getMethodList())){
            $params = (array) $this->requestHandler($method, $params);
            return $this->resultHandler($method, $this->session->call($this->serviceName, $method, $params));
        }
        return null;
    }

    /**
     * Retrieve service name.
     *
     * @return string
     */
    abstract protected function getServiceName();

    /**
     * Retrieve available service methods.
     *
     * @return array
     */
    abstract protected function getMethodList();

    /**
     * Handler of the request to API Yandex.Direct.
     *
     * @param $method
     * @param array $request
     * @return array
     */
    protected function requestHandler($method, array $request){
        return $request;
    }

    /**
     * Handler of the response from API Yandex.Direct.
     *
     * @param $method
     * @param Result $result
     * @return Result
     */
    protected function resultHandler($method, Result $result){
        return $result;
    }
}