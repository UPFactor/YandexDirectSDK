<?php

namespace YandexDirectSDK\Components;

use Closure;
use UPTools\Arr;
use UPTools\Components\Collection\BaseTrait;
use UPTools\Components\Collection\MapTrait;
use YandexDirectSDK\Exceptions\InvalidArgumentException;

/**
 * Class ServiceMethodCollection
 *
 * @method static ServiceMethodCollection     make(...$values)
 * @method static ServiceMethodCollection     wrap(ServiceMethod[] $value)
 *
 * @method ServiceMethod[]                    unwrap()
 * @method ServiceMethodCollection            copy()
 * @method ServiceMethodCollection            reset(ServiceMethod[] $value = [])
 * @method string                             hash()
 * @method ServiceMethod[]                    all()
 * @method integer                            count()
 * @method boolean                            isEmpty(Closure $callable = null)
 * @method boolean                            isNotEmpty(Closure $callable = null)
 * @method array                              keys()
 * @method array                              values()
 * @method array                              divide()
 * @method ServiceMethod|mixed|null           first($default = null, $callback = null)
 * @method ServiceMethod|mixed|null           last($default = null, $callback = null)
 * @method ServiceMethod|mixed|null           shift($default = null)
 * @method ServiceMethod|mixed|null           pop($default = null)
 * @method ServiceMethodCollection            only($keys)
 * @method ServiceMethodCollection            not($keys)
 * @method ServiceMethodCollection            initial($count = 1)
 * @method ServiceMethodCollection            tail($count = 1)
 * @method ServiceMethodCollection            map(Closure $callable, $context = null)
 * @method $this                              each(Closure $callable, $context = null)
 * @method ServiceMethodCollection            filter(Closure $callable, $context = null)
 * @method ServiceMethodCollection            slice($offset, $length = null)
 * @method ServiceMethod|ServiceMethod[]      get($keys, $default = null)
 * @method ServiceMethod|ServiceMethod[]      pull($keys, $default = null)
 * @method boolean                            has($keys, $strict = false)
 * @method $this                              remove($keys)
 *
 * @package YandexDirectSDK\Components
 */
class ServiceMethodCollection
{
    use BaseTrait,
        MapTrait;

    /**
     * Create a new collection.
     *
     * @param mixed $items
     */
    public function __construct($items = []){
        $this->reset($items);
    }

    /**
     * Set collection item for given value.
     *
     * @param ServiceMethod $value
     * @return $this
     */
    public function set($value)
    {
        $value = $this->dataItemController($value);
        $this->items[$value->name] = $value;
        return $this;
    }

    /**
     * Add an item to the collection if it does not exist.
     *
     * @param ServiceMethod $value
     * @return $this
     */
    public function add($value)
    {
        $value = $this->dataItemController($value);

        if (!array_key_exists($value->name, $this->items)){
            $this->items[$value->name] = $value;
        }

        return $this;
    }

    /**
     * Convert collection to array.
     *
     * @return array
     */
    public function toArray()
    {
        return Arr::map($this->items, function(ServiceMethod $method){
            return $method->toArray();
        });
    }

    /**
     * Convert collection to JSON.
     *
     * @return string
     */
    public function toJson()
    {
        return Arr::toJson($this->toArray());
    }

    /**
     * Preprocessor combining collections with data.
     *
     * @param ServiceMethod[] $methods
     * @return ServiceMethodCollection[]
     */
    protected function dataFusionController($methods)
    {
        if (!is_array($methods)){
            throw InvalidArgumentException::serviceMethodCollectionMerge('array', $methods);
        }

        $result = [];

        foreach ($methods as $method){
            $method = $this->dataItemController($method);
            $result[$method->name] = $method;
        }

        return $result;
    }

    /**
     * Preprocessor adding new items to the collection.
     *
     * @param ServiceMethod $method
     * @return ServiceMethod
     */
    protected function dataItemController($method)
    {
        if (!is_object($method) or !($method instanceof ServiceMethod)){
            throw InvalidArgumentException::serviceMethodCollectionItem(ServiceMethod::class, $method);
        }

        return $method;
    }
}