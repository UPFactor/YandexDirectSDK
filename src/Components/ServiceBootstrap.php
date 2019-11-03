<?php

namespace YandexDirectSDK\Components;

use Exception;
use UPTools\Arr;
use YandexDirectSDK\Exceptions\ServiceBootstrapException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

/**
 * Class ServiceBootstrap
 * Snapshot initial parameters of service.
 *
 * @property-read string $name
 * @property-read ServiceMethodCollection $methods
 * @property-read ModelInterface|null $modelClass
 * @property-read ModelCollectionInterface|null $modelCollectionClass
 *
 * @package YandexDirectSDK\Components
 */
class ServiceBootstrap
{
    /**
     * Service name.
     *
     * @var string
     */
    protected $name;

    /**
     * Declared virtual methods of the service provider.
     *
     * @var ModelMethodCollection
     */
    protected $methods;

    /**
     * The class of the model that is used by the service.
     *
     * @var ModelInterface
     */
    protected $modelClass;

    /**
     * The class of the collection that is used by the service.
     *
     * @var ModelCollectionInterface
     */
    protected $modelCollectionClass;

    /**
     * ModelRegistry constructor.
     *
     * @param array $composition
     */
    public function __construct(array $composition)
    {
        if (!isset($composition['name']) or !is_string($composition['name'])){
            throw ServiceBootstrapException::invalidNameInComposition($composition['name'] ?? null);
        }

        if (isset($composition['methods'])){
            if (!($composition['methods'] instanceof ServiceMethodCollection)){
                throw ServiceBootstrapException::invalidMethodsInComposition($composition['methods']);
            }
        } else {
            $composition['methods'] = ServiceMethodCollection::make();
        }

        if (isset($composition['modelClass'])){
            if (!is_string($composition['modelClass'])){
                throw ServiceBootstrapException::invalidModelClassInComposition($composition['modelClass']);
            }
        } else {
            $composition['modelClass'] = null;
        }

        if (isset($composition['modelCollectionClass'])){
            if (!is_string($composition['modelCollectionClass'])){
                throw ServiceBootstrapException::invalidModelCollectionClassInComposition($composition['modelCollectionClass']);
            }
        } else {
            $composition['modelCollectionClass'] = null;
        }

        $this->name = $composition['name'];
        $this->methods = $composition['methods'];
        $this->modelClass = $composition['modelClass'];
        $this->modelCollectionClass = $composition['modelCollectionClass'];
    }

    /**
     * Overload registry properties.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        try {
            return $this->{$name};
        } catch (Exception $error){
            throw ServiceBootstrapException::propertyNotExist($name);
        }
    }

    /**
     * Returns specified [$methodName] method item.
     *
     * @param string $methodName
     * @return ServiceMethod|null
     */
    public function getMethod(string $methodName)
    {
        return $this->methods->get($methodName);
    }

    /**
     * Check by name if there is an method in collection [$this->methods].
     *
     * @param string $methodName
     * @return bool
     */
    public function hasMethod(string $methodName)
    {
        return $this->methods->has($methodName);
    }

    /**
     * Convert object to array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'methods' => $this->methods->toArray(),
            'modelClass' => $this->modelClass,
            'modelCollectionClass' => $this->modelCollectionClass
        ];
    }

    /**
     * Convert object to JSON.
     *
     * @return string
     */
    public function toJson()
    {
        return Arr::toJson($this->toArray());
    }
}