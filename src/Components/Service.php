<?php

namespace YandexDirectSDK\Components;

use Exception;
use BadMethodCallException;
use InvalidArgumentException;
use YandexDirectSDK\Common\SessionTrait;
use YandexDirectSDK\Session;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

/**
 * Class Service
 *
 * @package YandexDirectSDK\Services
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
     * @param Session $session
     * @param mixed ...$arguments
     * @return static
     */
    public static function make(Session $session, ...$arguments){
        return new static($session, ...$arguments);
    }

    /**
     * Create Service instance.
     *
     * @param Session $session
     * @param mixed ...$arguments
     */
    public function __construct(Session $session, ...$arguments)
    {
        $this->session = $session;
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
     * @return null
     */
    public function __call($method, $arguments)
    {
        $method = $this->serviceMethods[$method] ?? null;

        if (is_null($method)){
            throw new BadMethodCallException(static::class.". Method [{$method}] is missing.");
        }

        return $this->{$method['type']}($method['name'], ...$arguments);
    }

    /**
     * Call to services API.
     *
     * @param string $method API service method
     * @param array $params API service parameters
     * @return Result
     * @throws Exception
     */
    public function call($method, $params = array())
    {
        return $this->session->call($this->serviceName, $method, $params);
    }

    /**
     * Retrieve service name.
     *
     * @return string
     */
    public function getServiceName()
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
    public function getMethodsMeta()
    {
        return $this->serviceMethods;
    }

    /**
     * Service initialization handler.
     *
     * @param mixed ...$arguments
     * @return void
     */
    protected function initialize(...$arguments){}

    /**
     * Gets an array of identifiers from the passed source.
     *
     * @param string|string[]|integer|integer[]|ModelCommonInterface $source
     * @param string $container
     * @return array
     */
    protected function extractIds($source, $container = 'id'){
        if ($source instanceof ModelInterface){
            $keys = [$source->{$container}];
        } elseif ($source instanceof ModelCollectionInterface) {
            $keys = $source->pluck($container);
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
    protected function bind($owner, $related, $foreignKey, $ownerKey = 'id')
    {
        $keys = $this->extractIds($owner, $ownerKey);
        $elements = [];

        if (empty($keys)){
            throw new InvalidArgumentException(static::class.". Failed bind model. Missing IDs for binding");
        }

        if ($related instanceof ModelInterface){

            foreach ($keys as $key){
                $elements[] = array_merge($related->unwrap(), [$foreignKey => $key]);
            }

            if (is_null($related = $related->getCompatibleCollection())){
                throw new InvalidArgumentException(static::class.". Failed bind model. Model [".get_class($related)."] does not support this operation.");
            }

        } elseif ($related instanceof ModelCollectionInterface){

            foreach ($keys as $key){
                foreach ($related->unwrap() as $item){
                    $elements[] = array_merge($item, [$foreignKey => $key]);
                }
            }

            $related = $related::make();

        } else {
            throw new InvalidArgumentException(static::class.". Failed bind model. Invalid object type to bind. Expected [".ModelCollectionInterface::class."|".ModelInterface::class.".");
        }

        return $related
            ->setSession($this->session)
            ->insert($elements);
    }

    /**
     * Typical method for adding model data.
     *
     * @param string $methodName
     * @param ModelInterface $model
     * @return Result
     * @throws Exception
     */
    protected function addModel(string $methodName, ModelInterface $model)
    {
        $result = $this->call($methodName, $model->toArray());
        return $result->setResource(
            $model
                ->setSession($this->session)
                ->insert($result->data)
        );
    }

    /**
     * Typical method for adding collection data
     *
     * @param string $methodName
     * @param ModelCommonInterface $collection
     * @return Result
     * @throws Exception
     */
    protected function addCollection(string $methodName, ModelCommonInterface $collection)
    {
        if ($collection instanceof ModelInterface){
            if (is_null($modelCollection = $collection->getCompatibleCollection())){
                throw new InvalidArgumentException(static::class.". Failed method [{$methodName}]. Model [".get_class($collection)."] does not support this operation.");
            }

            $collection = $modelCollection::make($collection);
        }

        $result = $this->call($methodName, [$collection::getClassName() => $collection->check()->toArray()]);

        return $result->setResource(
            $collection
                ->setSession($this->session)
                ->insert($result->data->get('AddResults'))
        );
    }

    /**
     * Typical method for updating model data.
     *
     * @param string $methodName
     * @param ModelInterface $model
     * @return Result
     * @throws Exception
     */
    protected function updateModel(string $methodName, ModelInterface $model){
        $result = $this->call($methodName, $model->toArray());
        return $result->setResource(
            $model
                ->setSession($this->session)
                ->insert($result->data)
        );
    }

    /**
     * Typical method for updating collection data.
     *
     * @param string $methodName
     * @param ModelCommonInterface $collection
     * @return Result
     * @throws Exception
     */
    protected function updateCollection(string $methodName, ModelCommonInterface $collection){
        if ($collection instanceof ModelInterface){
            if (is_null($modelCollection = $collection->getCompatibleCollection())){
                throw new InvalidArgumentException(static::class.". Failed method [{$methodName}]. Model [".get_class($collection)."] does not support this operation.");
            }

            $collection = $modelCollection::make($collection);
        }

        $result = $this->call($methodName, [$collection::getClassName() => $collection->toArray()]);

        return $result->setResource(
                $collection
                    ->setSession($this->session)
                    ->insert($result->data->get('UpdateResults'))
        );
    }

    /**
     * Typical data selection method.
     *
     * @param string $methodName
     * @return QueryBuilder
     * @throws Exception
     */
    protected function selectionElements(string $methodName){
        if (is_null($this->serviceModelClass) or is_null($this->serviceModelCollectionClass)){
            throw new BadMethodCallException(static::class.". Failed method [{$methodName}]. Service does not support this operation.");
        }

        return new QueryBuilder(function (QueryBuilder $query) use ($methodName){
            $result = $this->call($methodName, $query->toArray());

            return $result->setResource(
                $this->serviceModelCollectionClass::make()
                    ->setSession($this->session)
                    ->insert($result->data->get($this->serviceModelCollectionClass::getClassName()))
            );
        });
    }

    /**
     * Typical method for action based on object property values.
     *
     * @param string $methodName
     * @param ModelCommonInterface|string[]|integer[]|string|integer $elements
     * @param string $modelProperty
     * @param string $actionProperty
     * @return Result
     * @throws Exception
     */
    protected function actionByProperty(string $methodName, $elements, $modelProperty, $actionProperty){
        if ($elements instanceof ModelCommonInterface){

            if ($elements instanceof ModelCollectionInterface){

                $elements = $elements
                    ->setSession($this->session)
                    ->pluck($modelProperty);

            } elseif ($elements instanceof ModelInterface){

                $elements = $elements
                    ->setSession($this->session)
                    ->{$modelProperty};

            } else {

                throw new InvalidArgumentException(static::class.". Failed method [{$methodName}]. Invalid object type. Expected [".ModelCollectionInterface::class."|".ModelInterface::class.".");

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
     * @param ModelCommonInterface|integer[]|integer $elements
     * @return Result
     * @throws Exception
     */
    protected function actionByIds(string $methodName, $elements){
        return $this->actionByProperty($methodName, $elements, 'id', 'Ids');
    }


}