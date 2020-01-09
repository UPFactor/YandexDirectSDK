<?php

namespace YandexDirectSDK\Components;

use Closure;
use UPTools\Arr;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
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
     * @return ModelInterface|string|null
     */
    public static function getModelClass()
    {
        return static::boot()->modelClass;
    }

    /**
     * Returns class of the collection that is used by the service.
     *
     * @return ModelCollectionInterface|string|null
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
        $result = static::call($methodName, $model->toJson(Model::IS_ADDABLE));
        return $result->setResource(
            $model->insert($result->data)
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
        $result = static::call($methodName, $model->toJson(Model::IS_UPDATABLE));
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
            try {
                $collection = $collection->toCollection();
            } catch (ModelException $error) {
                throw ServiceException::modelNotSupportMethod($collection, $methodName);
            }
        }

        if (is_null($addClassName)){
            $addClassName = $collection::getClassName();
        }

        if (is_null($resultClassName)){
            $resultClassName = 'AddResults';
        }

        $result = static::call($methodName, '{"' . $addClassName . '":' . $collection->toJson(Model::IS_ADDABLE) . '}');
        return $result->setResource(
            $collection->insert($result->data->get($resultClassName))
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
            try {
                $collection = $collection->toCollection();
            } catch (ModelException $error) {
                throw ServiceException::modelNotSupportMethod($collection, $methodName);
            }
        }

        if (is_null($updateClassName)){
            $updateClassName = $collection::getClassName();
        }

        if (is_null($resultClassName)){
            $resultClassName = 'UpdateResults';
        }

        $result = static::call($methodName, '{"' . $updateClassName . '":' . $collection->toJson(Model::IS_UPDATABLE) . '}');

        return $result->setResource(
            $collection->insert($result->data->get($resultClassName))
        );
    }

    /**
     * Creating a query builder.
     *
     * @param string $methodName
     * @param Closure|null $queryHandler
     * @return QueryBuilder
     */
    protected static function createQueryBuilder(string $methodName, Closure $queryHandler = null): QueryBuilder
    {
        if (is_null(static::boot()->modelClass) or is_null(static::boot()->modelCollectionClass)){
            throw ServiceException::serviceNotSupportMethod(static::class, $methodName);
        }

        return new QueryBuilder(
            function (QueryBuilder $query, $modifier) use ($methodName, $queryHandler){
                $result = static::call($methodName, is_null($queryHandler) ? $query->toJson() : $queryHandler($query->toArray()));
                $result = $result->data->get(static::boot()->modelCollectionClass::getClassName());

                if (is_null($result)){
                    return $modifier === 'first' ? null : static::boot()->modelCollectionClass::make();
                }

                if ($modifier === 'first'){
                    return static::boot()
                        ->modelClass::make()
                        ->insert($result->first());
                } else {
                    return static::boot()
                        ->modelCollectionClass::make()
                        ->insert($result);
                }
            }
        );
    }

    /**
     * Typical data selection method by property values.
     *
     * @param string $methodName
     * @param string $criteria
     * @param string $property
     * @param integer|integer[]|string|string[] $propertyValues
     * @param array $fields
     * @return ModelInterface|ModelCollectionInterface
     */
    protected static function selectByProperty(string $methodName, string $criteria, string $property, $propertyValues, array $fields = [])
    {
        $query = static::createQueryBuilder($methodName)
            ->select($property, ...$fields)
            ->whereIn($criteria, $propertyValues);

        if (!is_array($propertyValues) or count($propertyValues) === 1){
            return $query->first();
        } else {
            return $query->get();
        }
    }

    /**
     * Typical data selection method by id.
     *
     * @param string $methodName
     * @param integer|integer[]|string|string[] $ids
     * @param array $fields
     * @return ModelInterface|ModelCollectionInterface|null
     */
    protected static function selectById(string $methodName, $ids, array $fields = [])
    {
        return static::selectByProperty($methodName, 'Ids', 'Id', $ids, $fields);
    }

    /**
     * Typical method for action by property values.
     *
     * @param string $methodName
     * @param ModelCommonInterface|string[]|integer[]|string|integer $elements
     * @param string $property
     * @param string $criteria
     * @return Result
     */
    protected static function actionByProperty(string $methodName, $elements, string $criteria = 'Ids', string $property = 'id'): Result
    {
        if (is_null(static::boot()->modelClass) or is_null(static::boot()->modelCollectionClass)){
            throw ServiceException::serviceNotSupportMethod(static::class, $methodName);
        }

        if ($elements instanceof ModelCommonInterface){
            if ($elements instanceof ModelInterface){
                try {
                    $elements = $elements->toCollection();
                } catch (ModelException $error) {
                    throw ServiceException::modelNotSupportMethod($elements, $methodName);
                }
            }
            $resource = $elements;
            $elements = $elements->extract($property);
        } else {
            $resource = static::boot()->modelCollectionClass::make();
            $elements = is_array($elements) ? $elements : [$elements];
            foreach ($elements as $element){
                if (!is_string($element) and !is_integer($element)){
                    throw InvalidArgumentException::serviceMethod(static::class, $methodName, "int|int[]|string|string[]|".ModelCollectionInterface::class."|".ModelInterface::class);
                }
                $resource->push(static::boot()->modelClass::make([$property => $element]));
            }
        }

        return static::call($methodName, (new QueryBuilder())->whereIn($criteria, $elements)->toJson())
            ->setResource($resource);
    }

    /**
     * Typical method for action by id.
     *
     * @param string $methodName
     * @param ModelCommonInterface|string[]|integer[]|string|integer $elements
     * @return Result
     */
    protected static function actionById(string $methodName, $elements): Result
    {
        return static::actionByProperty($methodName, $elements);
    }
}