<?php


namespace YandexDirectSDKTest\Helpers;

use PHPUnit\Framework\Assert;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

class Checklists extends Assert
{
    /**
     * Checklist for [Result] object.
     *
     * @param Result $result
     * @return Result
     */
    public function checkResult(Result $result)
    {
        $this->assertEquals(200, $result->code);
        $this->assertTrue($result->errors->isEmpty(), 'Result errors: ' . $result->errors->toJson());
        $this->assertTrue($result->warnings->isEmpty(), 'Result warnings: ' . $result->warnings->toJson());
        return $result;
    }

    /**
     * Checklist for [Result.resource] property.
     *
     * @param Result $result
     * @param null $expectedClass
     * @param array $expectedProperties
     * @return ModelInterface|ModelCollectionInterface|null
     * @throws ModelException
     */
    public function checkResource(Result $result, $expectedClass = null, $expectedProperties = [])
    {
        $resource = $result->getResource();
        $this->checkResult($result);

        if (is_null($expectedClass)){
            $this->assertNull($resource);
            return $resource;
        }

        $this->assertInstanceOf($expectedClass, $resource);

        if (!empty($expectedProperties)){
            $this->checkModelCollection($resource, $expectedProperties);
        }

        return $resource;
    }

    /**
     * Checklist for [Model] properties.
     *
     * @param ModelInterface $model
     * @param array $expectedProperties
     * @return ModelInterface
     * @throws ModelException
     */
    public function checkModel(ModelInterface $model, array $expectedProperties)
    {
        if ($model instanceof ModelInterface){

            $arrModel = $model->toArray();

            foreach ($expectedProperties as $index => $property){
                if (is_integer($index)){
                    $value = Arr::get($arrModel, $property);
                    $this->assertNotNull($value, $property);
                } else {
                    $type = $property;
                    $value = Arr::get($arrModel, $index);
                    $this->assertEquals($type, gettype($value), $index);
                    $this->assertNotNull($value, $index);
                }
            }
        }
        return $model;
    }

    /**
     * Checklist for [Model] properties in [ModelCollection].
     *
     * @param ModelCollectionInterface $collection
     * @param array $expectedProperties
     * @return ModelCollectionInterface
     * @throws ModelException
     */
    public function checkModelCollection(ModelCollectionInterface $collection, array $expectedProperties)
    {
        $this->assertTrue($collection->isNotEmpty(), 'Collection is empty');
        $collection->each(function(ModelInterface $model) use ($expectedProperties){
            $this->checkModel($model, $expectedProperties);
        });

        return $collection;
    }
}