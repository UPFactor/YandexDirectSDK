<?php

namespace YandexDirectSDK\Components;

use Closure;
use UPTools\Arr;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Session;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

/**
 * Class Service
 *
 * @package YandexDirectSDK\Components
 */
abstract class Service
{
    /**
     * Boot data registry.
     *
     * @var Registry
     */
    protected static $boot;

    /**
     * Service name.
     *
     * @var string
     */
    protected static $name;

    /**
     * Declared virtual methods of the service provider.
     *
     * @var array
     */
    protected static $methods = [];

    /**
     * The class of the model that is used by the service.
     *
     * @var ModelInterface
     */
    protected static $modelClass;

    /**
     * The class of the collection that is used by the service.
     *
     * @var ModelCollectionInterface
     */
    protected static $modelCollectionClass;

    /**
     * Dynamic call to service methods.
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        if (!static::boot()->hasMethod($method)){
            throw ServiceException::serviceMethodNotExist(static::class, $method);
        }

        return static::boot()->getMethod($method)->call(...$arguments);
    }

    /**
     * Returns service provider name.
     *
     * @return string|null
     */
    public static function getName()
    {
        return static::boot()->name;
    }

    /**
     * Returns class of the model that is used by the service.
     *
     * @return string|null
     */
    public static function getModelClass()
    {
        return static::boot()->modelClass;
    }

    /**
     * Returns class of the collection that is used by the service.
     *
     * @return string|null
     */
    public static function getModelCollectionClass()
    {
        return static::boot()->modelCollectionClass;
    }

    /**
     * Returns the metadata of the declared service provider methods.
     *
     * @return array
     */
    public static function getMethodsMeta()
    {
        return static::boot()->methods->toArray();
    }

    /**
     * Call to services API.
     *
     * @param string $method API service method
     * @param array $params API service parameters
     * @return Result
     */
    public static function call($method, $params = array()): Result
    {
        return Session::call(static::boot()->name, $method, $params);
    }

    /**
     * Bootstrap of the object.
     *
     * @return ServiceBootstrap
     */
    protected static function boot()
    {
        $class = static::class;

        if (is_null(self::$boot)){
            self::$boot = new Registry();
        } elseif (self::$boot->has($class)) {
            return self::$boot->get($class);
        }

        self::$boot->set($class, new ServiceBootstrap([
            'name' => static::$name,
            'methods' => new ServiceMethodCollection(Arr::map(static::$methods, function($signature, $name){
                return new ServiceMethod($name, static::class, $signature);
            })),
            'modelClass' => static::$modelClass,
            'modelCollectionClass' => static::$modelCollectionClass
        ]));

        return self::$boot->get($class);
    }


    /**
     * Gets an array of identifiers from the passed source.
     *
     * @param string|string[]|integer|integer[]|ModelCommonInterface $source
     * @param string $container
     * @return array
     */
    protected static function extractIds($source, $container = 'id'): array
    {
        if ($source instanceof ModelInterface){
            $keys = [$source->getPropertyValue($container)];
        } elseif ($source instanceof ModelCollectionInterface) {
            $keys = $source->extract($container);
        } else {
            $keys = is_array($source) ? array_values($source) : [$source];
        }

        return $keys;
    }

    /**
     * Binds the [$owner] model/collection to the [$related] model/collection
     * using the [$foreignKey] and [$ownerKey].
     * As a result, the [$related] collection will be returned, which contains the
     * models for each [$owner] item associated with it.
     *
     * @param string|string[]|integer|integer[]|ModelCommonInterface $owner
     * @param ModelCommonInterface $related
     * @param string $foreignKey
     * @param string $ownerKey
     * @return ModelCollectionInterface
     */
    protected static function bind($owner, $related, $foreignKey, $ownerKey = 'id'): ModelCollectionInterface
    {
        $keys = static::extractIds($owner, $ownerKey);
        $elements = [];

        if (empty($keys)){
            throw ServiceException::noIdToBind();
        }

        if ($related instanceof ModelInterface){
            foreach ($keys as $key){
                $elements[] = array_merge($related->toArray(), [$foreignKey => $key]);
            }

            if (is_null($related = $related::getCompatibleCollectionClass())){
                throw ServiceException::modelNotSupportBinding($related);
            }
        } elseif ($related instanceof ModelCollectionInterface){
            foreach ($keys as $key){
                foreach ($related->toArray() as $item){
                    $elements[] = array_merge($item, [$foreignKey => $key]);
                }
            }
        } else {
            throw ServiceException::invalidObjectToBind();
        }

        return $related::make()->insert($elements);
    }

    /**
     * Typical method for adding model data.
     *
     * @param string $methodName
     * @param ModelInterface $model
     * @return Result
     */
    protected static function addModel(string $methodName, ModelInterface $model): Result
    {
        $result = static::call($methodName, $model->toArray(Model::IS_ADDABLE));
        return $result->setResource(
            $model->insert($result->data)
        );
    }

    /**
     * Typical method for adding collection data
     *
     * @param string $methodName
     * @param ModelCommonInterface $collection
     * @param string|null $addClassName
     * @param string|null $resultClassName
     * @return Result
     */
    protected static function addCollection(string $methodName, ModelCommonInterface $collection, $addClassName = null, $resultClassName = null): Result
    {
        if ($collection instanceof ModelInterface){
            if (is_null($modelCollection = $collection::getCompatibleCollectionClass())){
                throw ServiceException::modelNotSupportMethod($collection, $methodName);
            }

            $collection = $modelCollection::make($collection);
        }

        if (is_null($addClassName)){
            $addClassName = $collection::getClassName();
        }

        if (is_null($resultClassName)){
            $resultClassName = 'AddResults';
        }

        $result = static::call($methodName, [$addClassName => $collection->toArray(Model::IS_ADDABLE)]);

        return $result->setResource(
            $collection->insert($result->data->get($resultClassName))
        );
    }

    /**
     * Typical method for updating model data.
     *
     * @param string $methodName
     * @param ModelInterface $model
     * @return Result
     */
    protected static function updateModel(string $methodName, ModelInterface $model): Result
    {
        $result = static::call($methodName, $model->toArray(Model::IS_UPDATABLE));
        return $result->setResource(
            $model->insert($result->data)
        );
    }

    /**
     * Typical method for updating collection data.
     *
     * @param string $methodName
     * @param ModelCommonInterface $collection
     * @param string|null $updateClassName
     * @param string|null $resultClassName
     * @return Result
     */
    protected static function updateCollection(string $methodName, ModelCommonInterface $collection, $updateClassName = null, $resultClassName = null): Result
    {
        if ($collection instanceof ModelInterface){
            if (is_null($modelCollection = $collection::getCompatibleCollectionClass())){
                throw ServiceException::modelNotSupportMethod($collection, $methodName);
            }

            $collection = $modelCollection::make($collection);
        }

        if (is_null($updateClassName)){
            $updateClassName = $collection::getClassName();
        }

        if (is_null($resultClassName)){
            $resultClassName = 'UpdateResults';
        }

        $result = static::call($methodName, [$updateClassName => $collection->toArray(Model::IS_UPDATABLE)]);

        return $result->setResource(
            $collection->insert($result->data->get($resultClassName))
        );
    }

    /**
     * Typical data selection method.
     *
     * @param string $methodName
     * @param Closure|null $handler
     * @return QueryBuilder
     */
    protected static function selectionElements(string $methodName, Closure $handler = null): QueryBuilder
    {
        if (is_null(static::boot()->modelClass) or is_null(static::boot()->modelCollectionClass)){
            throw ServiceException::serviceNotSupportMethod(static::class, $methodName);
        }

        return new QueryBuilder(function (QueryBuilder $query) use ($methodName, $handler){
            $result = static::call($methodName, is_null($handler) ? $query->toArray() : $handler($query->toArray()));

            return $result->setResource(
                static::boot()->modelCollectionClass::make()
                    ->insert($result->data->get(static::boot()->modelCollectionClass::getClassName()))
            );
        });
    }

    /**
     * Typical data selection method by ID.
     *
     * @param string $methodName
     * @param integer|integer[]|string|string[] $elements
     * @param array $fields
     * @return ModelInterface|ModelCollectionInterface|null
     */
    protected static function selectionByIds(string $methodName, $elements, array $fields = ['Id'])
    {
        $result = static::selectionElements($methodName)
            ->select($fields)
            ->whereIn('Ids', $elements)
            ->get()
            ->getResource();

        if (!is_array($elements) or count($elements) === 1){
            return $result->first();
        }

        return $result;
    }

    /**
     * Typical method for action based on object property values.
     *
     * @param string $methodName
     * @param ModelCommonInterface|string[]|integer[]|string|integer $elements
     * @param string $modelProperty
     * @param string $actionProperty
     * @return Result
     */
    protected static function actionByProperty(string $methodName, $elements, $modelProperty, $actionProperty): Result
    {
        if ($elements instanceof ModelCommonInterface){
            if ($elements instanceof ModelCollectionInterface){
                $elements = $elements->extract($modelProperty);
            } elseif ($elements instanceof ModelInterface){
                $elements = $elements->getPropertyValue($modelProperty);
            } else {
                throw InvalidArgumentException::serviceMethod(static::class, $methodName, ModelCollectionInterface::class."|".ModelInterface::class);
            }
        } elseif (!is_array($elements)) {
            $elements = [$elements];
        }

        return static::call($methodName, (new QueryBuilder())->whereIn($actionProperty, $elements)->toArray());
    }

    /**
     * Typical method for action based on object ids.
     *
     * @param string $methodName
     * @param ModelCommonInterface|string[]|integer[]|string|integer $elements
     * @return Result
     */
    protected static function actionByIds(string $methodName, $elements): Result
    {
        return static::actionByProperty($methodName, $elements, 'id', 'Ids');
    }
}