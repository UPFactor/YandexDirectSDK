<?php

namespace YandexDirectSDK\Components;

use Closure;
use YandexDirectSDK\Common\SessionTrait;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
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
    use SessionTrait;

    /**
     * Service name.
     *
     * @var string
     */
    protected $serviceName;

    /**
     * The class of the model that is used by the service.
     *
     * @var ModelInterface
     */
    protected $serviceModelClass;

    /**
     * The class of the collection that is used by the service.
     *
     * @var ModelCollectionInterface
     */
    protected $serviceModelCollectionClass;

    /**
     * Available service methods.
     *
     * @var array
     */
    protected $serviceMethods = [];

    /**
     * Create Service instance.
     *
     * @param mixed ...$arguments
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Create Service instance.
     *
     * @param mixed ...$arguments
     */
    public function __construct(...$arguments)
    {
        $this->initialize(...$arguments);

        foreach ($this->serviceMethods as $methodAlias => $methodMeta){
            $methodMeta = explode(':', $methodMeta, 2);
            $methodName = trim($methodMeta[0]);
            $methodType = trim($methodMeta[1] ?? '');

            if (empty($methodMeta)){
                continue;
            }

            $this->serviceMethods[$methodAlias] = [
                'name' => $methodName,
                'type' => $methodType
            ];
        }
    }

    /**
     * Dynamic call to service methods.
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (!isset($this->serviceMethods[$method])){
            throw ServiceException::make(static::class.". Method [{$method}] is missing.");
        }
        return $this->{$this->serviceMethods[$method]['type']}($this->serviceMethods[$method]['name'], ...$arguments);
    }

    /**
     * Call to services API.
     *
     * @param string $method API service method
     * @param array $params API service parameters
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function call($method, $params = array()): Result
    {
        return ($this->session ?? Session::init())->call($this->serviceName, $method, $params);
    }

    /**
     * Retrieve service name.
     *
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * Get the class of the model used by the service.
     *
     * @return ModelInterface
     */
    public function getServiceModelClass()
    {
        return $this->serviceModelClass;
    }

    /**
     * Get the class of the collection used by the service.
     *
     * @return ModelCollectionInterface
     */
    public function getServiceModelCollectionClass()
    {
        return $this->serviceModelCollectionClass;
    }

    /**
     * Retrieve service methods metadata.
     *
     * @return array
     */
    public function getMethodsMeta(): array
    {
        return $this->serviceMethods;
    }

    /**
     * Service initialization handler.
     *
     * @param mixed ...$arguments
     * @return void
     */
    protected function initialize(...$arguments): void {}

    /**
     * Gets an array of identifiers from the passed source.
     *
     * @param string|string[]|integer|integer[]|ModelCommonInterface $source
     * @param string $container
     * @return array
     * @throws ModelException
     */
    protected function extractIds($source, $container = 'id'): array
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
     * @throws ServiceException
     * @throws ModelException
     */
    protected function bind($owner, $related, $foreignKey, $ownerKey = 'id'): ModelCollectionInterface
    {
        $keys = $this->extractIds($owner, $ownerKey);
        $elements = [];

        if (empty($keys)){
            throw ServiceException::make(static::class.". Failed bind model. Missing IDs for binding");
        }

        if ($related instanceof ModelInterface){

            foreach ($keys as $key){
                $elements[] = array_merge($related->toArray(), [$foreignKey => $key]);
            }

            if (is_null($related = $related->getCompatibleCollection())){
                throw ServiceException::make(static::class.". Failed bind model. Model [".get_class($related)."] does not support this operation.");
            }

        } elseif ($related instanceof ModelCollectionInterface){

            foreach ($keys as $key){
                foreach ($related->toArray() as $item){
                    $elements[] = array_merge($item, [$foreignKey => $key]);
                }
            }

            $related = $related::make();

        } else {
            throw ServiceException::make(static::class.". Failed bind model. Invalid object type to bind. Expected [".ModelCollectionInterface::class."|".ModelInterface::class.".");
        }

        return $related->insert($elements);
    }

    /**
     * Typical method for adding model data.
     *
     * @param string $methodName
     * @param ModelInterface $model
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    protected function addModel(string $methodName, ModelInterface $model): Result
    {
        $result = $this->call($methodName, $model->toArray(Model::IS_ADDABLE));
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
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    protected function addCollection(string $methodName, ModelCommonInterface $collection, $addClassName = null, $resultClassName = null): Result
    {
        if ($collection instanceof ModelInterface){
            if (is_null($modelCollection = $collection->getCompatibleCollection())){
                throw ServiceException::make(static::class.". Failed method [{$methodName}]. Model [".get_class($collection)."] does not support this operation.");
            }

            $collection = $modelCollection::make($collection);
        }

        if (is_null($addClassName)){
            $addClassName = $collection::getClassName();
        }

        if (is_null($resultClassName)){
            $resultClassName = 'AddResults';
        }

        $result = $this->call($methodName, [$addClassName => $collection->toArray(Model::IS_ADDABLE)]);

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
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    protected function updateModel(string $methodName, ModelInterface $model): Result
    {
        $result = $this->call($methodName, $model->toArray(Model::IS_UPDATABLE));
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
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    protected function updateCollection(string $methodName, ModelCommonInterface $collection, $updateClassName = null, $resultClassName = null): Result
    {
        if ($collection instanceof ModelInterface){
            if (is_null($modelCollection = $collection->getCompatibleCollection())){
                throw ServiceException::make(static::class.". Failed method [{$methodName}]. Model [".get_class($collection)."] does not support this operation.");
            }

            $collection = $modelCollection::make($collection);
        }

        if (is_null($updateClassName)){
            $updateClassName = $collection::getClassName();
        }

        if (is_null($resultClassName)){
            $resultClassName = 'UpdateResults';
        }

        $result = $this->call($methodName, [$updateClassName => $collection->toArray(Model::IS_UPDATABLE)]);

        return $result->setResource(
            $collection->insert($result->data->get($resultClassName))
        );
    }

    /**
     * Typical data selection method.
     *
     * @param string $methodName
     * @param Closure|null $queryHandler
     * @return QueryBuilder
     */
    protected function selectionElements(string $methodName, $queryHandler = null): QueryBuilder
    {
        if (is_null($this->serviceModelClass) or is_null($this->serviceModelCollectionClass)){
            throw ServiceException::make(static::class.". Failed method [{$methodName}]. Service does not support this operation.");
        }

        if (!($queryHandler instanceof Closure)){
            $queryHandler = null;
        }

        return new QueryBuilder(function (QueryBuilder $query) use ($methodName, $queryHandler){
            $result = $this->call($methodName, is_null($queryHandler) ? $query->toArray() : $queryHandler($query->toArray()));

            return $result->setResource(
                $this->serviceModelCollectionClass::make()
                    ->insert($result->data->get($this->serviceModelCollectionClass::getClassName()))
            );
        });
    }

    /**
     * @param string $methodName
     * @param $elements
     * @param array $fields
     * @return ModelInterface|ModelCollectionInterface|null
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ModelException
     */
    protected function selectionByIds(string $methodName, $elements, array $fields)
    {
        if ($elements instanceof ModelCommonInterface){
            if ($elements instanceof ModelCollectionInterface){
                $elements = $elements->extract('id');
            } elseif ($elements instanceof ModelInterface){
                $elements = $elements->getPropertyValue('id');
            } else {
                throw InvalidArgumentException::invalidType(static::class."::{$methodName}", null, ModelCollectionInterface::class."|".ModelInterface::class);
            }
        } elseif (!is_array($elements)) {
            $elements = [$elements];
        }

        $result = $this->selectionElements($methodName)
            ->select($fields)
            ->whereIn('Ids', $elements)
            ->get()
            ->getResource();

        if (count($elements) === 1){
            $result = $result->first();
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
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
     */
    protected function actionByProperty(string $methodName, $elements, $modelProperty, $actionProperty): Result
    {
        if ($elements instanceof ModelCommonInterface){
            if ($elements instanceof ModelCollectionInterface){
                $elements = $elements->extract($modelProperty);
            } elseif ($elements instanceof ModelInterface){
                $elements = $elements->getPropertyValue($modelProperty);
            } else {
                throw InvalidArgumentException::invalidType(static::class."::{$methodName}", null, ModelCollectionInterface::class."|".ModelInterface::class);
            }
        } elseif (!is_array($elements)) {
            $elements = [$elements];
        }

        return $this->call($methodName, (new QueryBuilder())->whereIn($actionProperty, $elements)->toArray());
    }

    /**
     * Typical method for action based on object ids.
     *
     * @param string $methodName
     * @param ModelCommonInterface|string[]|integer[]|string|integer $elements
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
     */
    protected function actionByIds(string $methodName, $elements): Result
    {
        return $this->actionByProperty($methodName, $elements, 'id', 'Ids');
    }


}