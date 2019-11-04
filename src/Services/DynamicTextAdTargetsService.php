<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\WebpageBids;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageBid;

/** 
 * Class DynamicTextAdTargetsService 
 * 
 * @method static     Result                    add(Webpage|Webpages|ModelCommonInterface $webpages)
 * @method static     QueryBuilder              query()
 * @method static     Webpage|Webpages|null     find(integer|integer[]|string|string[] $ids, string[] $fields)
 * @method static     Result                    delete(integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages)
 * @method static     Result                    resume(integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages)
 * @method static     Result                    suspend(integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages)
 * 
 * @package YandexDirectSDK\Services 
 */
class DynamicTextAdTargetsService extends Service
{
    protected static $name = 'dynamictextadtargets';

    protected static $modelClass = Webpage::class;

    protected static $modelCollectionClass = Webpages::class;

    protected static $methods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'delete' => 'delete:actionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds'
    ];

    /**
     * Sets bids for targeting conditions for dynamic ads.
     *
     * @param integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages
     * @param integer $bid
     * @param integer|null $contextBid
     * @return Result
     */
    public static function setRelatedBids($webpages, $bid, $contextBid = null):Result
    {
        $webpageIds = static::extractIds($webpages);
        $webpageBids = new WebpageBids();

        if (func_num_args() > 2){
            foreach ($webpageIds as $id){
                $webpageBids->push(
                    WebpageBid::make()
                        ->setId($id)
                        ->setBid($bid)
                        ->setContextBid($contextBid)
                );
            }
        } else {
            foreach ($webpageIds as $id){
                $webpageBids->push(
                    WebpageBid::make()
                        ->setId($id)
                        ->setBid($bid)
                );
            }
        }

        return static::setBids($webpageBids);
    }

    /**
     * Sets context bids for targeting conditions for dynamic ads.
     *
     * @param integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages
     * @param integer $contextBid
     * @return Result
     */
    public static function setRelatedContextBids($webpages, $contextBid):Result
    {
        $webpageIds =  static::extractIds($webpages);
        $webpageBids = new WebpageBids();

        foreach ($webpageIds as $id){
            $webpageBids->push(
                WebpageBid::make()
                    ->setId($id)
                    ->setContextBid($contextBid)
            );
        }

        return static::setBids($webpageBids);
    }

    /**
     * Sets priorities for targeting conditions for dynamic ads.
     *
     * @param integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages
     * @param string $strategyPriority
     * @return Result
     */
    public static function setRelatedStrategyPriority($webpages, string $strategyPriority):Result
    {
        $webpageIds =  static::extractIds($webpages);
        $webpageBids = new WebpageBids();

        foreach ($webpageIds as $id){
            $webpageBids->push(
                WebpageBid::make()
                    ->setId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return static::setBids($webpageBids);
    }

    /**
     * Sets bids and priorities for targeting conditions for dynamic ads.
     *
     * @param WebpageBid|WebpageBids|ModelCommonInterface $webpageBids
     * @return Result
     */
    public static function setBids(ModelCommonInterface $webpageBids):Result
    {
        return static::updateCollection('setBids', $webpageBids, 'Bids', 'SetBidsResults');
    }
}