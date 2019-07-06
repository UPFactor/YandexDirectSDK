<?php


namespace YandexDirectSDKTest\Helpers;

use Exception;
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
     * @throws Exception
     */
    public function checkResource(Result $result, $expectedClass = null, $expectedProperties = [])
    {
        $resource = $result->getResource();
        $this->checkResult($result);

        if (is_null($expectedClass)){
            $this->assertNull($resource);
        } else {
            $this->assertInstanceOf($expectedClass, $resource);
        }

        if (!empty($expectedProperties)){
            $this->checkModelCollection($resource, $expectedProperties);
        }

        return $resource;
    }

    /**
     * Checklist for [Model] properties.
     *
     * @param ModelInterface $model
     * @param array|string $expectedProperties
     * @return ModelInterface
     * @throws Exception
     */
    public function checkModel(ModelInterface $model, $expectedProperties)
    {
        $arrModel = $model->toArray();

        if (is_string($expectedProperties)){

            $expectedProperties = explode(':', $expectedProperties, 2);
            $path = $expectedProperties[0];
            $key = $expectedProperties[1] ?? null;

            $this->assertEquals(
                FakeApi::getArray($path, $key),
                $arrModel
            );

        } else if (is_array($expectedProperties)){

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
     * @param array|string $expectedProperties
     * @return ModelCollectionInterface
     * @throws Exception
     */
    public function checkModelCollection(ModelCollectionInterface $collection, $expectedProperties)
    {
        $this->assertTrue($collection->isNotEmpty(), 'Collection is empty');

        if (is_string($expectedProperties)){

            $arrCollection = $collection->toArray();
            $expectedProperties = explode(':', $expectedProperties, 2);
            $path = $expectedProperties[0];
            $key = $expectedProperties[1] ?? null;

            $this->assertEquals(
                FakeApi::getArray($path, $key),
                $arrCollection
            );

        } else if (is_array($expectedProperties)){

            $collection->each(function(ModelInterface $model) use ($expectedProperties){
                $this->checkModel($model, $expectedProperties);
            });

        }

        return $collection;
    }
}