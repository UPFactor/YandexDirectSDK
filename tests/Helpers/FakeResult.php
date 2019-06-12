<?php


namespace YandexDirectSDKTest\Helpers;

use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

class FakeResult extends Result
{
    /**
     * @var Checklists
     */
    protected $checklists;

    /**
     * FakeResult constructor.
     *
     * @param $response
     * @throws RequestException
     */
    public function __construct($response)
    {
        $this->checklists = new Checklists();

        $this->header = [
            'Content-Type' => 'application/json'
        ];

        $this->response = $response;
        $this->code = 200;
        $this->data = new Data();
        $this->errors = new Data();
        $this->warnings = new Data();

        $this->setResult($response);
    }

    /**
     * Check this object.
     *
     * @return Result
     */
    public function check()
    {
        return $this->checklists->checkResult($this);
    }

    /**
     * Check [resource] property of this object.
     *
     * @param null $expectedClass
     * @param array $expectedProperties
     * @return ModelInterface|ModelCollectionInterface|null
     * @throws ModelException
     */
    public function checkResource($expectedClass = null, $expectedProperties = [])
    {
        return $this->checklists->checkResource($this, $expectedClass, $expectedProperties);
    }
}