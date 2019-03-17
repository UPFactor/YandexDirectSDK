<?php

namespace YandexDirectSDK\Components;

use ReflectionClass;
use ReflectionException;
use BadMethodCallException;
use InvalidArgumentException;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Common\CollectionBaseTrait;
use YandexDirectSDK\Common\SessionTrait;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Session;

/**
 * Class ModelCollection
 *
 * @package YandexDirectSDK\Components
 */
abstract class ModelCollection implements ModelCollectionInterface
{
    use CollectionBaseTrait;
    use SessionTrait;

    /**
     * The models contained in the collection.
     *
     * @var ModelInterface[]
     */
    protected $items = [];

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
     * Returns the short class name.
     *
     * @return string
     * @throws ReflectionException
     */
    public static function getClassName()
    {
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
                return (new $this->serviceProvidersMethods[$method]($this->session))->{$method}($this, ...$arguments);
            }

            throw new BadMethodCallException(static::class.". Failed method [{$method}]. No session to connect.");
        }

        throw new BadMethodCallException(static::class.". Method [{$method}] is missing.");
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
     * @param ModelInterface $value
     * @return $this
     */
    public function push($value)
    {
        $value = $this->dataItemController($value);

        if (!is_null($this->session)){
            $value->setSession($this->session);
        }

        array_push($this->items, $value);
        return $this;
    }

    /**
     * Insert model source into the collection.
     *
     * @param Data|array $source
     * @return $this
     */
    public function insert($source)
    {
        if (empty($source)){
            return $this;
        }

        if (!is_array($source)){
            if (!($source instanceof Data)){
                return $this;
            }

            $source = $source->all();
        }

        foreach ($source as $index => $model){
            if (array_key_exists($index, $this->items)){
                $this->items[$index]->insert($model);
            } else {
                $model = $this->compatibleModel::make($model);

                if (!is_null($this->session)){
                    $model->setSession($this->session);
                }

                $this->push($model);
            }
        }

        return $this;
    }

    /**
     * Extract the array of model property values from the collection.
     *
     * @param string|string[] $properties
     * @return array
     */
    public function extract($properties)
    {
        if (is_string($properties)){
            return Arr::map($this->items, function($model) use ($properties){
                return $model->{$properties};
            });
        }

        if (is_array($properties)){
            return Arr::map($this->items, function($model) use ($properties){
                $result = [];
                foreach ($properties as $property){
                    $result[$property] = $model->{$property};
                }
                return $result;
            });
        }

        return [];
    }

    /**
     * Converts the current collection to array.
     *
     * @param int $filters
     * @return array
     */
    public function toArray($filters = 0)
    {
        return Arr::map($this->items, function(ModelInterface $item) use ($filters){
            return $item->toArray($filters);
        });
    }

    /**
     * Converts the current collection to a Data object.
     *
     * @return Data
     */
    public function toData(){
        return new Data($this->toArray());
    }

    /**
     * Converts the current collection to JSON.
     *
     * @param int $filters
     * @return string
     */
    public function toJson($filters = 0)
    {
        return Arr::toJson($this->toArray());
    }

    /**
     * Binds the collection to a session.
     *
     * @param Session $session
     * @return $this
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
        foreach ($this->items as $model){
            $model->setSession($session);
        }
        return $this;
    }

    /**
     * Retrieve instance of compatible models.
     *
     * @return ModelInterface
     */
    public function getCompatibleModel()
    {
        return $this->compatibleModel::make();
    }

    /**
     * Retrieve metadata of service-providers methods.
     *
     * @return Service[]
     */
    public function getServiceProvidersMethodsMeta()
    {
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