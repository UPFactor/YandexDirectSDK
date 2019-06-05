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
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\AudienceTarget;

/** 
 * Class AudienceTargetsService 
 * 
 * @method   Result         add(AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * @method   QueryBuilder   query()
 * @method   Result         delete(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * @method   Result         resume(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * @method   Result         suspend(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
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
     * @param ModelCommonInterface $audienceTargetBids
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function setBids(ModelCommonInterface $audienceTargetBids):Result
    {
        return $this->updateCollection('setBids', $audienceTargetBids, 'Bids', 'SetBidsResults');
    }
}