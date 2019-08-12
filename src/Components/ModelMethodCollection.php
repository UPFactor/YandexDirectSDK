<?php

namespace YandexDirectSDK\Components;

use Closure;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Common\CollectionBaseTrait;
use YandexDirectSDK\Common\CollectionMapTrait;
use YandexDirectSDK\Exceptions\InvalidArgumentException;

/**
 * Class ModelMethodCollection
 *
 * @method static ModelMethodCollection make(...$values)
 * @method static ModelMethodCollection wrap(ModelMethod[] $value)
 * @method ModelMethodCollection reset(ModelMethod[] $value = [])
 * @method string hash()
 * @method ModelMethodCollection copy()
 * @method ModelMethod[] all()
 * @method integer count()
 * @method boolean isEmpty(Closure $callable = null)
 * @method boolean isNotEmpty(Closure $callable = null)
 * @method array keys()
 * @method array values()
 * @method array divide()
 * @method ModelMethod|mixed|null first($default = null, $callback = null)
 * @method ModelMethod|mixed|null last($default = null, $callback = null)
 * @method ModelMethod|mixed|null shift($default = null)
 * @method ModelMethod|mixed|null pop($default = null)
 * @method ModelMethodCollection initial($count = 1)
 * @method ModelMethodCollection tail($count = 1)
 * @method ModelMethodCollection map(Closure $callable, $context = null)
 * @method $this each(Closure $callable, $context = null)
 * @method ModelMethodCollection filter(Closure $callable, $context = null)
 * @method ModelMethodCollection slice($offset, $length = null)
 * @method ModelMethod|ModelMethod[] get($keys, $default = null)
 * @method ModelMethod|ModelMethod[] pull($keys, $default = null)
 * @method boolean has($keys, $strict = false)
 * @method ModelMethodCollection remove($keys)
 * @method ModelMethodCollection except($keys)
 *
 * @package YandexDirectSDK\Components
 */
class ModelMethodCollection
{
    use CollectionBaseTrait,
        CollectionMapTrait;

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
     * @param ModelMethod $value
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
     * @param ModelMethod $value
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
        return Arr::map($this->items, function(ModelMethod $method){
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
     * @param ModelMethod[] $methods
     * @return ModelMethodCollection[]
     */
    protected function dataFusionController($methods)
    {
        if (!is_array($methods)){
            throw InvalidArgumentException::modelMethodCollectionMerge('array', $methods);
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
     * @param ModelMethod $method
     * @return ModelMethod
     */
    protected function dataItemController($method)
    {
        if (!is_object($method) or !($method instanceof ModelMethod)){
            throw InvalidArgumentException::modelMethodCollectionItem(ModelMethod::class, $method);
        }

        return $method;
    }
}