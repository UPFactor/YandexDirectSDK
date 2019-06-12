<?php

namespace YandexDirectSDKTest\Helpers;

use Exception;
use YandexDirectSDK\Common\Dir;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Session;

class FakeSession extends Session
{
    /**
     * @var Dir|null
     */
    protected $fakeApi = null;

    /**
     * Switch on/off fake api
     *
     * @param bool $switch
     * @param string|null $dataPath
     * @return $this
     */
    public function useFakeApi(bool $switch, string $dataPath = null)
    {
        if ($switch){
            $this->fakeApi = Dir::bind($dataPath);
        } else {
            $this->fakeApi = null;
        }
        return $this;
    }

    /**
     * Escaping parent method to call API
     *
     * @param string $service
     * @param string $method
     * @param array $params
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws Exception
     */
    public function call($service, $method, $params = []): Result
    {
        if (is_null($this->fakeApi)){
            return parent::call($service, $method, $params);
        }

        return new FakeResult(
            $this->fakeApi->getFile("/{$service}/{$method}.json")->content()
        );
    }
}