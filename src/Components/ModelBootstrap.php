<?php

namespace YandexDirectSDK\Components;

use Exception;
use UPTools\Arr;
use YandexDirectSDK\Exceptions\ModelBootstrapException;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

/**
 * Class ModelBootstrap
 * Snapshot initial parameters of model or model collection.
 *
 * @property-read string $name
 * @property-read ModelPropertyCollection $properties
 * @property-read ModelMethodCollection $methods
 * @property-read ModelMethodCollection $staticMethods
 * @property-read ModelCollectionInterface|ModelInterface|string|null $compatibility
 *
 * @package YandexDirectSDK\Components
 */
class ModelBootstrap
{
    /**
     * Model/ModelCollection name.
     *
     * @var string
     */
    protected $name;

    /**
     * Compatible class of model or model collection.
     *
     * @var ModelCollectionInterface|ModelInterface|string|null
     */
    protected $compatibility;

    /**
     * Declared virtual properties.
     *
     * @var ModelPropertyCollection
     */
    protected $properties;

    /**
     * Declared virtual methods.
     *
     * @var ModelMethodCollection
     */
    protected $methods;

    /**
     * Declared virtual static methods.
     *
     * @var ModelMethodCollection
     */
    protected $staticMethods;

    /**
     * ModelRegistry constructor.
     *
     * @param array $composition
     */
    public function __construct(array $composition)
    {
        if (!isset($composition['name']) or !is_string($composition['name'])){
            throw ModelBootstrapException::invalidNameInComposition($composition['name'] ?? null);
        }

        if (isset($composition['compatibility'])){
            if (!is_string($composition['compatibility'])){
                throw ModelBootstrapException::invalidCompatibilityInComposition($composition['compatibility']);
            }
        } else {
            $composition['compatibility'] = null;
        }

        if (isset($composition['properties'])){
            if (!($composition['properties'] instanceof ModelPropertyCollection)){
                throw ModelBootstrapException::invalidPropertiesInComposition($composition['properties']);
            }
        } else {
            $composition['properties'] = ModelPropertyCollection::make();
        }

        if (isset($composition['methods'])){
            if (!($composition['methods'] instanceof ModelMethodCollection)){
                throw ModelBootstrapException::invalidMethodsInComposition($composition['methods']);
            }
        } else {
            $composition['methods'] = ModelMethodCollection::make();
        }

        if (isset($composition['staticMethods'])){
            if (!($composition['staticMethods'] instanceof ModelMethodCollection)){
                throw ModelBootstrapException::invalidStaticMethodsInComposition($composition['staticMethods']);
            }
        } else {
            $composition['staticMethods'] = ModelMethodCollection::make();
        }

        $this->name = $composition['name'];
        $this->compatibility = $composition['compatibility'];
        $this->properties = $composition['properties'];
        $this->methods = $composition['methods'];
        $this->staticMethods = $composition['staticMethods'];
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
            throw ModelBootstrapException::propertyNotExist($name);
        }
    }

    /**
     * Returns specified [$propertyName] property item.
     *
     * @param string $propertyName
     * @return ModelProperty|null
     */
    public function getProperty(string $propertyName)
    {
        return $this->properties->get($propertyName);
    }

    /**
     * Check by name if there is an property in collection [$this->properties].
     *
     * @param string $propertyName
     * @return bool
     */
    public function hasProperty(string $propertyName)
    {
        return $this->properties->has($propertyName, true);
    }

    /**
     * Returns specified [$methodName] static method item.
     *
     * @param string $methodName
     * @return ModelMethod|null
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
        return $this->methods->has($methodName, true);
    }

    /**
     * Returns specified [$methodName] method item.
     *
     * @param string $methodName
     * @return ModelMethod|null
     */
    public function getStaticMethod(string $methodName)
    {
        return $this->staticMethods->get($methodName);
    }

    /**
     * Check by name if there is an static method in collection [$this->staticMethods].
     *
     * @param string $methodName
     * @return bool
     */
    public function hasStaticMethod(string $methodName)
    {
        return $this->staticMethods->has($methodName, true);
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
            'properties' => $this->properties->toArray(),
            'methods' => $this->methods->toArray(),
            'staticMethods' => $this->staticMethods->toArray(),
            'compatibility' => $this->compatibility
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