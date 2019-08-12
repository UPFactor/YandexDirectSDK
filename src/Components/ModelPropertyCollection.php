<?php

namespace YandexDirectSDK\Components;

use Closure;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Common\CollectionBaseTrait;
use YandexDirectSDK\Common\CollectionMapTrait;
use YandexDirectSDK\Exceptions\InvalidArgumentException;

/**
 * Class ModelPropertyCollection
 *
 * @method static ModelPropertyCollection make(...$values)
 * @method static ModelPropertyCollection wrap(ModelProperty[] $value)
 * @method ModelPropertyCollection reset(ModelProperty[] $value = [])
 * @method string hash()
 * @method ModelPropertyCollection copy()
 * @method ModelProperty[] all()
 * @method integer count()
 * @method boolean isEmpty(Closure $callable = null)
 * @method boolean isNotEmpty(Closure $callable = null)
 * @method array keys()
 * @method array values()
 * @method array divide()
 * @method ModelProperty|mixed|null first($default = null, $callback = null)
 * @method ModelProperty|mixed|null last($default = null, $callback = null)
 * @method ModelProperty|mixed|null shift($default = null)
 * @method ModelProperty|mixed|null pop($default = null)
 * @method ModelPropertyCollection initial($count = 1)
 * @method ModelPropertyCollection tail($count = 1)
 * @method ModelPropertyCollection map(Closure $callable, $context = null)
 * @method $this each(Closure $callable, $context = null)
 * @method ModelPropertyCollection filter(Closure $callable, $context = null)
 * @method ModelPropertyCollection slice($offset, $length = null)
 * @method ModelProperty|ModelProperty[] get($keys, $default = null)
 * @method ModelProperty|ModelProperty[] pull($keys, $default = null)
 * @method boolean has($keys, $strict = false)
 * @method ModelPropertyCollection remove($keys)
 * @method ModelPropertyCollection except($keys)
 *
 * @package YandexDirectSDK\Components
 */
class ModelPropertyCollection
{
    use CollectionBaseTrait,
        CollectionMapTrait;

    /**
     * Create a new collection.
     *
     * @param mixed $items
     */
    public function __construct($items = [])
    {
        $this->reset($items);
    }

    /**
     * Set collection item for given value.
     *
     * @param ModelProperty $value
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
     * @param ModelProperty $value
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
        return Arr::map($this->items, function(ModelProperty $property){
            return $property->toArray();
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
     * @param ModelProperty[] $properties
     * @return ModelPropertyCollection[]
     */
    protected function dataFusionController($properties)
    {
        if (!is_array($properties)){
            throw InvalidArgumentException::modelPropertyCollectionMerge('array', $properties);
        }

        $result = [];

        foreach ($properties as $property){
            $property = $this->dataItemController($property);
            $result[$property->name] = $property;
        }

        return $result;
    }

    /**
     * Preprocessor adding new items to the collection.
     *
     * @param ModelProperty $property
     * @return ModelProperty
     */
    protected function dataItemController($property)
    {
        if (!is_object($property) or !($property instanceof ModelProperty)){
            throw InvalidArgumentException::modelPropertyCollectionItem(ModelProperty::class, $property);
        }

        return $property;
    }
}