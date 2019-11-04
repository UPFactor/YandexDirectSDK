<?php


namespace YandexDirectSDKTest\Helpers;

use PHPUnit\Framework\Assert;
use UPTools\Arr;
use UPTools\Validator;
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
     * @param array $rules
     * @return ModelInterface
     */
    public static function checkModel(ModelInterface $model, array $rules)
    {
        $validator = Validator::make($model->toArray(), $rules);
        static::assertFalse($validator->fails, Arr::first($validator->failed) ?? '');
        return $model;
    }

    /**
     * Checklist for [Model] properties in [ModelCollection].
     *
     * @param ModelCollectionInterface $collection
     * @param array $rules
     * @return ModelCollectionInterface
     */
    public static function checkModelCollection(ModelCollectionInterface $collection, array $rules)
    {
        static::assertTrue($collection->isNotEmpty(), 'Collection is empty');
        $collection->each(function(ModelInterface $model) use ($rules){
            Checklists::checkModel($model, $rules);
        });

        return $collection;
    }
}