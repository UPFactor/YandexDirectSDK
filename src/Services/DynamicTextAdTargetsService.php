<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\Webpage;

/** 
 * Class DynamicTextAdTargetsService 
 * 
 * @method   Result         add(ModelCommon $webpages) 
 * @method   QueryBuilder   query() 
 * @method   Result         delete(ModelCommon|integer[]|integer $webpages) 
 * @method   Result         resume(ModelCommon|integer[]|integer $webpages) 
 * @method   Result         suspend(ModelCommon|integer[]|integer $webpages) 
 * 
 * @package YandexDirectSDK\Services 
 */
class DynamicTextAdTargetsService extends Service
{
    protected $serviceName = 'dynamictextadtargets';

    protected $serviceModelClass = Webpage::class;

    protected $serviceModelCollectionClass = Webpages::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'delete' => 'delete:actionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds'
    ];

    /**
     * @param ModelCommon $webpageBids
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function setBids(ModelCommon $webpageBids):Result
    {
        return $this->updateCollection('setBids', $webpageBids);
    }
}