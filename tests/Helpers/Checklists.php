<?php


namespace YandexDirectSDKTest\Helpers;

use PHPUnit\Framework\Assert;
use UPTools\Arr;
use YandexDirectSDK\Components\Result;
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
    public static function checkResult(Result $result)
    {
        static::assertEquals(200, $result->code);
        static::assertTrue($result->errors->isEmpty(), 'Result errors: ' . $result->errors->toJson());
        static::assertTrue($result->warnings->isEmpty(), 'Result warnings: ' . $result->warnings->toJson());
        return $result;
    }

    /**
     * Checklist for [Result.resource] property.
     *
     * @param Result $result
     * @param null $expectedClass
     * @param array $expectedProperties
     * @return ModelInterface|ModelCollectionInterface|null
     */
    public static function checkResource(Result $result, $expectedClass = null, $expectedProperties = [])
    {
        $resource = $result->getResource();
        static::checkResult($result);

        if (is_null($expectedClass)){
            static::assertNull($resource);
        } else {
            static::assertInstanceOf($expectedClass, $resource);
        }

        if (!empty($expectedProperties)){
            static::checkModelCollection($resource, $expectedProperties);
        }

        return $resource;
    }

    /**
     * Checklist for [Model] properties.
     *
     * @param ModelInterface $model
     * @param array|string $expectedProperties
     * @return ModelInterface
     */
    public static function checkModel(ModelInterface $model, $expectedProperties)
    {
        $arrModel = $model->toArray();

        if (is_string($expectedProperties)){

            $expectedProperties = explode(':', $expectedProperties, 2);
            $path = $expectedProperties[0];
            $key = $expectedProperties[1] ?? null;

            static::assertEquals(
                FakeApi::get($path, $key),
                $arrModel
            );

        } else if (is_array($expectedProperties)){

            foreach ($expectedProperties as $index => $property){
                if (is_integer($index)){
                    $value = Arr::get($arrModel, $property);
                    static::assertNotNull($value, $property);
                } else {
                    $type = $property;
                    $value = Arr::get($arrModel, $index);
                    static::assertEquals($type, gettype($value), $index);
                    static::assertNotNull($value, $index);
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
     */
    public static function checkModelCollection(ModelCollectionInterface $collection, $expectedProperties)
    {
        static::assertTrue($collection->isNotEmpty(), 'Collection is empty');

        if (is_string($expectedProperties)){

            $arrCollection = $collection->toArray();
            $expectedProperties = explode(':', $expectedProperties, 2);
            $path = $expectedProperties[0];
            $key = $expectedProperties[1] ?? null;

            static::assertEquals(
                FakeApi::get($path, $key),
                $arrCollection
            );

        } else if (is_array($expectedProperties)){

            $collection->each(function(ModelInterface $model) use ($expectedProperties){
                Checklists::checkModel($model, $expectedProperties);
            });

        }

        return $collection;
    }
}