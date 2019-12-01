<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AudienceTargetBids;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Models\AudienceTargetBid;

/** 
 * Class AudienceTargetsService 
 * 
 * @method static     Result                                  create(AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * @method static     QueryBuilder                            query()
 * @method static     AudienceTarget|AudienceTargets|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method static     Result                                  delete(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * @method static     Result                                  resume(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * @method static     Result                                  suspend(integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets)
 * 
 * @package YandexDirectSDK\Services 
 */
class AudienceTargetsService extends Service
{
    protected static $name = 'audiencetargets';

    protected static $modelClass = AudienceTarget::class;

    protected static $modelCollectionClass = AudienceTargets::class;

    protected static $methods = [
        'create' => 'add:addCollection',
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
     */
    public static function setRelatedContextBids($audienceTargets, $contextBid):Result
    {
        $audienceTargetIds = static::extractIds($audienceTargets);
        $audienceTargetBids = new AudienceTargetBids();

        foreach ($audienceTargetIds as $id){
            $audienceTargetBids->push(
                AudienceTargetBid::make()
                    ->setId($id)
                    ->setContextBid($contextBid)
            );
        }

        return static::setBids($audienceTargetBids);
    }

    /**
     * Sets priorities for audience targeting conditions.
     *
     * @param integer|integer[]|AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets
     * @param string $strategyPriority
     * @return Result
     */
    public static function setRelatedStrategyPriority($audienceTargets, $strategyPriority):Result
    {
        $audienceTargetIds = static::extractIds($audienceTargets);
        $audienceTargetBids = new AudienceTargetBids();

        foreach ($audienceTargetIds as $id){
            $audienceTargetBids->push(
                AudienceTargetBid::make()
                    ->setId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return static::setBids($audienceTargetBids);
    }

    /**
     * Sets bids and priorities for audience targeting conditions.
     *
     * @param AudienceTargetBid|AudienceTargetBids|ModelCommonInterface $audienceTargetBids
     * @return Result
     */
    public static function setBids(ModelCommonInterface $audienceTargetBids):Result
    {
        return static::updateCollection('setBids', $audienceTargetBids, 'Bids', 'SetBidsResults');
    }
}