<?php

namespace YandexDirectSDK\Components;

use Exception;
use BadMethodCallException;
use InvalidArgumentException;
use YandexDirectSDK\Session;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

/**
 * Class Service
 *
 * @package YandexDirectSDK\Services
 */
class Service
{
    /**
     * Session instance.
     *
     * @var Session
     */
    protected $session;

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
     */
    public function call($method, $params = array())
    {
        return $this->session->call($this->serviceName, $method, $params);
    }

    /**
     * Retrieve the session used by the service.
     *
     * @return null|Session
     */
    public function getSession()
    {
        return $this->session;
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
     * Typical method for adding model data.
     *
     * @param string $methodName
     * @param ModelInterface $model
     * @return Result
     */
    protected function addModel(string $methodName, ModelInterface $model)
    {
        return $this->call($methodName, $model->toArray())
            ->setResource(
                $model->setSession($this->session)
            );
    }

    /**
     * Typical method for adding collection data
     *
     * @param string $methodName
     * @param ModelCommonInterface $collection
     * @return Result
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
        $addResults = $result->data->get('AddResults');
        if (!is_null($addResults)){
            $models = $collection->all();
            $addResults->each(function($item, $key) use ($models){
                if (!isset($item['Id']) or !isset($models[$key])){
                    return;
                }

                try{
                    $models[$key]->{'id'} = $item['Id'];
                } catch (Exception $error) {
                    return;
                }
            });
        }

        return $result->setResource(
            $collection->setSession($this->session)
        );
    }

    /**
     * Typical method for updating model data.
     *
     * @param string $methodName
     * @param ModelInterface $model
     * @return Result
     */
    protected function updateModel(string $methodName, ModelInterface $model){
        return $this->call($methodName, $model->toArray())
            ->setResource(
                $model->setSession($this->session)
            );
    }

    /**
     * Typical method for updating collection data.
     *
     * @param string $methodName
     * @param ModelCommonInterface $collection
     * @return Result
     */
    protected function updateCollection(string $methodName, ModelCommonInterface $collection){
        if ($collection instanceof ModelInterface){
            if (is_null($modelCollection = $collection->getCompatibleCollection())){
                throw new InvalidArgumentException(static::class.". Failed method [{$methodName}]. Model [".get_class($collection)."] does not support this operation.");
            }

            $collection = $modelCollection::make($collection);
        }

        return $this->call($methodName, [$collection::getClassName() => $collection->toArray()])
            ->setResource(
                $collection->setSession($this->session)
            );
    }

    /**
     * Typical data selection method.
     *
     * @param string $methodName
     * @return QueryBuilder
     */
    protected function selectionElements(string $methodName){
        if (is_null($this->serviceModelClass) or is_null($this->serviceModelCollectionClass)){
            throw new BadMethodCallException(static::class.". Failed method [{$methodName}]. Service does not support this operation.");
        }

        return new QueryBuilder(function (QueryBuilder $query) use ($methodName){
            $result = $this->call($methodName, $query->toArray());

            $models = $result->data
                ->get($this->serviceModelCollectionClass::getClassName(), [])
                ->map(function($item){
                    return $this->serviceModelClass::make($item)
                        ->setSession($this->session);
                });

            if ($models->isNotEmpty()){
                $result->setResource(
                    $this->serviceModelCollectionClass::wrap($models->all())
                        ->setSession($this->session)
                );
            }

            return $result;
        });
    }

    /**
     * Typical method for action based on object property values.
     *
     * @param string $methodName
     * @param ModelCommonInterface|array $elements
     * @param string $modelProperty
     * @param string $actionProperty
     * @return Result
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
     */
    protected function actionByIds(string $methodName, $elements){
        return $this->actionByProperty(
            $methodName,
            $elements,
            'id',
            'Ids'
        );
    }
}