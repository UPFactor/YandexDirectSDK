<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\AudienceTarget;

/** 
 * Class AudienceTargetsService 
 * 
 * @method   Result         add(ModelCommon $audienceTargets) 
 * @method   QueryBuilder   query() 
 * @method   Result         delete(ModelCommon|integer[]|integer $audienceTargets) 
 * @method   Result         resume(ModelCommon|integer[]|integer $audienceTargets) 
 * @method   Result         suspend(ModelCommon|integer[]|integer $audienceTargets) 
 * 
 * @package YandexDirectSDK\Services 
 */
class AudienceTargetsService extends Service
{
    protected $serviceName = 'audiencetargets';

    protected $serviceModelClass = AudienceTarget::class;

    protected $serviceModelCollectionClass = AudienceTargets::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'delete' => 'delete:actionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds'
    ];

    /**
     * @param ModelCommon $audienceTargetBids
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function setBids(ModelCommon $audienceTargetBids):Result
    {
        return $this->updateCollection('setBids', $audienceTargetBids);
    }
}