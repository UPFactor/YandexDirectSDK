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
     * @var Checklists
     */
    protected $checklists;

    /**
     * @var Dir
     */
    protected $fakeApi;

    /**
     * Session initialization handler.
     *
     * @return void
     */
    protected function initialize()
    {
        $this->checklists = new Checklists();
    }

    /**
     * Switch on/off fake api
     *
     * @param bool $switch
     * @param string|null $apiName
     * @return $this
     */
    public function fakeApi(bool $switch, string $apiName = null)
    {
        if ($switch and !is_null($apiName)){
            $dataPath = TestDir::data($apiName);
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
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function call($service, $method, $params = []): Result
    {
        if (is_null($this->fakeApi)){
            return parent::call($service, $method, $params);
        }

        return new FakeResult(
            $this->fakeApi
                ->getFile(DIRECTORY_SEPARATOR . $service . DIRECTORY_SEPARATOR. $method . '.json')
                ->content()
        );
    }
}