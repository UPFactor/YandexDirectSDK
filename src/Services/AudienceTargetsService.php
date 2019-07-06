<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AudienceTargetBids;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Models\AudienceTargetBid;

/** 
 * Class AudienceTargetsService 
 * 
 * @method   Result                                add(AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * @method   QueryBuilder                          query()
 * @method   AudienceTarget|AudienceTargets|null   find(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $ids, string[] $fields)
 * @method   Result                                delete(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * @method   Result                                resume(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * @method   Result                                suspend(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * 
 * @package YandexDirectSDK\Services 
 */
class AudienceTargetsService extends Service
{
    protected static $name = 'audiencetargets';

    protected static $modelClass = AudienceTarget::class;

    protected static $modelCollectionClass = AudienceTargets::class;

    protected static $methods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'delete' => 'delete:actionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds'
    ];

    /**
     * Sets context bids for audience targeting conditions.
     *
     * @param integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets
     * @param integer $contextBid
     * @return Result
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ModelException
     */
    public function setRelatedContextBids($audienceTargets, $contextBid):Result
    {
        $audienceTargetIds = $this->extractIds($audienceTargets);
        $audienceTargetBids = new AudienceTargetBids();

        foreach ($audienceTargetIds as $id){
            $audienceTargetBids->push(
                AudienceTargetBid::make()
                    ->setId($id)
                    ->setContextBid($contextBid)
            );
        }

        return $this->setBids($audienceTargetBids);
    }

    /**
     * Sets priorities for audience targeting conditions.
     *
     * @param integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets
     * @param string $strategyPriority
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function setRelatedStrategyPriority($audienceTargets, $strategyPriority):Result
    {
        $audienceTargetIds = $this->extractIds($audienceTargets);
        $audienceTargetBids = new AudienceTargetBids();

        foreach ($audienceTargetIds as $id){
            $audienceTargetBids->push(
                AudienceTargetBid::make()
                    ->setId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return $this->setBids($audienceTargetBids);
    }

    /**
     * Sets bids and priorities for audience targeting conditions.
     *
     * @param AudienceTargetBid|AudienceTargetBids|ModelCommonInterface $audienceTargetBids
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