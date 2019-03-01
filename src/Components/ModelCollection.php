<?php

namespace YandexDirectSDK\Components;

use ReflectionClass;
use BadMethodCallException;
use InvalidArgumentException;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Common\CollectionBaseTrait;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Session;

/**
 * Class ModelCollection
 *
 * @package YandexDirectSDK\Components
 */
class ModelCollection implements ModelCollectionInterface
{
    use CollectionBaseTrait;

    /**
     * Compatible class of model.
     *
     * @var ModelInterface
     */
    protected $compatibleModel;

    /**
     * Service-providers methods.
     *
     * @var Service[]
     */
    protected $serviceProvidersMethods = [];

    /**
     * Session instance.
     *
     * @var Session|null
     */
    protected $session;

    /**
     * Returns the short class name.
     *
     * @return string
     */
    public static function getClassName(){
        return (new ReflectionClass(static::class))->getShortName();
    }

    /**
     * Create a new collection instance.
     *
     * @param ModelCollectionInterface|ModelInterface[] $models
     */
    public function __construct($models = null)
    {
        $this->initialize($models);
        if (!is_null($models)) $this->reset($models);
    }

    /**
     * Returns a string representation of the current collection.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Implementing dynamic methods.
     *
     * @param string  $method
     * @param mixed[] $arguments
     * @return $this|mixed|null
     */
    public function __call($method, $arguments)
    {
        if (array_key_exists($method, $this->serviceProvidersMethods)){
            if (!is_null($this->session)){
                return (new $this->serviceProvidersMethods[$method]($this->session))->{$method}($this);
            }

            throw new BadMethodCallException(static::class.". Failed method [{$method}]. No session to connect.");
        }

        throw new BadMethodCallException(static::class.". Method [{$method}] is missing.");
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function unwrap(){
        return Arr::map($this->items, function(ModelInterface $item){
            return $item->unwrap();
        });
    }

    /**
     * Retrieve the collection hash.
     *
     * @return string
     */
    public function hash()
    {
        return Arr::hash($this->toArray());
    }

    /**
     * Push an item onto the end of the collection.
     *
     * @param $value
     * @return $this
     */
    public function push($value){
        array_push($this->items, $this->dataItemController($value));
        return $this;
    }

    /**
     * Converts current collection to array.
     *
     * @return array
     */
    public function toArray()
    {
        return Arr::map($this->items, function(ModelInterface $item){
            return $item->toArray();
        });
    }

    /**
     * Converts current collection to JSON.
     *
     * @return string
     */
    public function toJson()
    {
        return Arr::toJson($this->toArray());
    }

    /**
     * Models sufficiency checking.
     *
     * @return $this
     */
    public function check()
    {
        Arr::each($this->items, function(ModelInterface $item){
            return $item->check();
        });
        return $this;
    }

    /**
     * Binds the collection to a session.
     *
     * @param Session $session
     * @return $this
     */
    public function setSession(Session $session){
        $this->session = $session;
        return $this;
    }

    /**
     * Retrieve the session used by the collection.
     *
     * @return null|Session
     */
    public function getSession(){
        return $this->session;
    }

    /**
     * Retrieve instance of compatible models.
     *
     * @return ModelInterface
     */
    public function getCompatibleModel(){
        return $this->compatibleModel::make();
    }

    /**
     * Retrieve metadata of service-providers methods.
     *
     * @return Service[]
     */
    public function getServiceProvidersMethodsMeta(){
        return $this->serviceProvidersMethods;
    }

    /**
     * Collection initialization handler.
     *
     * @param ModelCollectionInterface|ModelInterface[] $models
     * @return void
     */
    protected function initialize($models){}

    /**
     * Preprocessor combining collections with data.
     *
     * @param mixed $data
     * @return static[]
     */
    protected function dataFusionController($data)
    {
        if (is_null($this->compatibleModel)){
            throw new BadMethodCallException(static::class.". Collection is not serviced.");
        }

        if (is_object($data)){
            if (get_class($data) !== static::class) {
                throw new InvalidArgumentException(static::class.". Invalid collection type [".get_class($data)."]. Expected [".static::class."|array of {$this->compatibleModel}]");
            }
            return $data->all();
        }

        if (is_array($data)){
            return Arr::map($data, function($item){
                return $this->dataItemController($item);
            });
        }

        throw new InvalidArgumentException(static::class.". Invalid data type. Expected [".static::class."|array of {$this->compatibleModel}]");
    }

    /**
     * Preprocessor adding new items to the collection.
     *
     * @param mixed $item
     * @return static
     */
    protected function dataItemController($item)
    {
        if (!is_object($item) or get_class($item) !== $this->compatibleModel){
            throw new InvalidArgumentException(static::class.". Invalid model type. Expected [{$this->compatibleModel}]");
        }
        return $item;
    }
}