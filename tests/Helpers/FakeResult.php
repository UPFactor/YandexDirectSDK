<?php


namespace YandexDirectSDKTest\Helpers;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

class FakeResult extends Result
{
    /**
     * Bootstrap of the object.
     *
     * @param $response
     */
    protected function bootstrap($response): void
    {
        $this->response = $response;
        $this->code = 200;
        $this->header = ['Content-Type' => 'application/json'];
        $this->setResult($response);
    }

    /**
     * Check this object.
     *
     * @return Result
     */
    public function check()
    {
        return Checklists::checkResult($this);
    }

    /**
     * Check [resource] property of this object.
     *
     * @param null $expectedClass
     * @param array $expectedProperties
     * @return ModelInterface|ModelCollectionInterface|null
     */
    public function checkResource($expectedClass = null, $expectedProperties = [])
    {
        return Checklists::checkResource($this, $expectedClass, $expectedProperties);
    }
}