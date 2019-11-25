<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\BidModifierToggle;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\Webpage;

/** 
 * Class AdGroupsService 
 * 
 * @method static     Result                    add(AdGroup|AdGroups|ModelCommonInterface $adGroups)
 * @method static     Result                    update(AdGroup|AdGroups|ModelCommonInterface $adGroups)
 * @method static     QueryBuilder              query()
 * @method static     AdGroup|AdGroups|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method static     Result                    delete(integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups)
 * 
 * @package YandexDirectSDK\Services 
 */
class AdGroupsService extends Service
{
    protected static $name = 'adgroups';

    protected static $modelClass = AdGroup::class;

    protected static $modelCollectionClass = AdGroups::class;

    protected static $methods = [
        'add' => 'add:addCollection',
        'update' => 'update:updateCollection',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'delete' => 'delete:actionByIds'
    ];

    /**
     * Add ads for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param Ad|Ads|ModelCommonInterface $ads
     * @return Result
     */
    public static function addRelatedAds($adGroups, ModelCommonInterface $ads): Result
    {
        return AdsService::add(static::bind($adGroups, $ads, 'AdGroupId'));
    }

    /**
     * Gets ads for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Ads|ModelCommonInterface
     */
    public static function getRelatedAds($adGroups, array $fields = []): Ads
    {
        return AdsService::query()
            ->select('Id','AdGroupId', ...$fields)
            ->whereIn('AdGroupIds', static::extractIds($adGroups))
            ->get();
    }

    /**
     * Add audience targets for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets
     * @return Result
     */
    public static function addRelatedAudienceTargets($adGroups, ModelCommonInterface $audienceTargets): Result
    {
        return AudienceTargetsService::add(static::bind($adGroups, $audienceTargets, 'AdGroupId'));
    }

    /**
     * Gets audience targets for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return AudienceTargets|ModelCommonInterface
     */
    public static function getRelatedAudienceTargets($adGroups, array $fields = []): AudienceTargets
    {
        return AudienceTargetsService::query()
            ->select('Id','AdGroupId', ...$fields)
            ->whereIn('AdGroupIds', static::extractIds($adGroups))
            ->get();
    }

    /**
     * Sets bids for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param integer $bid
     * @param integer|null $contextBid
     * @return Result
     */
    public static function setRelatedBids($adGroups, $bid, $contextBid = null):Result
    {
        $adGroupIds = static::extractIds($adGroups);
        $bids = new Bids();

        if (func_num_args() > 2){
            foreach ($adGroupIds as $id){
                $bids->push(
                    Bid::make()
                        ->setAdGroupId($id)
                        ->setBid($bid)
                        ->setContextBid( $contextBid)
                );
            }
        } else {
            foreach ($adGroupIds as $id){
                $bids->push(
                    Bid::make()
                        ->setAdGroupId($id)
                        ->setBid($bid)
                );
            }
        }

        return BidsService::set($bids);
    }

    /**
     * Sets context bids for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param integer $contextBid
     * @return Result
     */
    public static function setRelatedContextBids($adGroups, $contextBid):Result
    {
        $adGroupIds = static::extractIds($adGroups);
        $bids = new Bids();

        foreach ($adGroupIds as $id){
            $bids->push(
                Bid::make()
                    ->setAdGroupId($id)
                    ->setContextBid($contextBid)
            );
        }

        return BidsService::set($bids);
    }

    /**
     * Sets strategy priority for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param string $strategyPriority
     * @return Result
     */
    public static function setRelatedStrategyPriority($adGroups, string $strategyPriority):Result
    {
        $adGroupIds = static::extractIds($adGroups);
        $bids = new Bids();

        foreach ($adGroupIds as $id){
            $bids->push(
                Bid::make()
                    ->setAdGroupId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return BidsService::set($bids);
    }

    /**
     * Sets bid designer options for all keywords in given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param BidAuto|BidsAuto|ModelCommonInterface $bidsAuto
     * @return Result
     */
    public static function setRelatedBidsAuto($adGroups, ModelCommonInterface $bidsAuto): Result
    {
        return BidsService::setAuto(static::bind($adGroups, $bidsAuto, 'AdGroupId'));
    }

    /**
     * Gets bids for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Bids|ModelCommonInterface
     */
    public static function getRelatedBids($adGroups, array $fields = []): Bids
    {
        return BidsService::query()
            ->select('AdGroupId', ...$fields)
            ->whereIn('AdGroupIds', static::extractIds($adGroups))
            ->get();
    }

    /**
     * Add bid modifiers for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param BidModifier|BidModifiers|ModelCommonInterface $bidModifiers
     * @return Result
     */
    public static function addRelatedBidModifiers($adGroups, ModelCommonInterface $bidModifiers): Result
    {
        return BidModifiersService::add(static::bind($adGroups, $bidModifiers, 'AdGroupId'));
    }

    /**
     * Enable bid modifiers for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param string $bidModifierType
     * @return Result
     */
    public static function enableBidModifiers($adGroups, string $bidModifierType): Result
    {
        $collection = new BidModifierToggles();

        foreach (static::extractIds($adGroups) as $id){
            $collection->push(
                BidModifierToggle::make([
                    'AdGroupId' => $id,
                    'Type' => $bidModifierType,
                    'Enabled' => BidModifierToggle::YES
                ])
            );
        }

        return BidModifiersService::toggle($collection);
    }

    /**
     * Disable bid modifiers for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param string $bidModifierType
     * @return Result
     */
    public static function disableBidModifiers($adGroups, string $bidModifierType): Result
    {
        $collection = new BidModifierToggles();

        foreach (static::extractIds($adGroups) as $id){
            $collection->push(
                BidModifierToggle::make([
                    'AdGroupId' => $id,
                    'Type' => $bidModifierType,
                    'Enabled' => BidModifierToggle::NO
                ])
            );
        }

        return BidModifiersService::toggle($collection);
    }

    /**
     * Get bid modifiers for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return BidModifiers|ModelCommonInterface
     */
    public static function getRelatedBidModifiers($adGroups, array $fields = []): BidModifiers
    {
        return BidModifiersService::query()
            ->select('Id','AdGroupId', ...$fields)
            ->whereIn('AdGroupIds', static::extractIds($adGroups))
            ->whereIn('Levels', ['CAMPAIGN','AD_GROUP'])
            ->get();
    }

    /**
     * Add keywords for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param Keyword|Keywords|ModelCommonInterface $keywords
     * @return Result
     */
    public static function addRelatedKeywords($adGroups, ModelCommonInterface $keywords): Result
    {
        return KeywordsService::add(static::bind($adGroups, $keywords, 'AdGroupId'));
    }

    /**
     * Gets keywords for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Keywords|ModelCommonInterface
     */
    public static function getRelatedKeywords($adGroups, array $fields = []): Keywords
    {
        return KeywordsService::query()
            ->select('Id','AdGroupId', ...$fields)
            ->whereIn('AdGroupIds', static::extractIds($adGroups))
            ->get();
    }

    /**
     * Add the targeting conditions for dynamic ads for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param Webpage|Webpages|ModelCommonInterface $webpages
     * @return Result
     */
    public static function addRelatedWebpages($adGroups, ModelCommonInterface $webpages): Result
    {
        return DynamicTextAdTargetsService::add(static::bind($adGroups, $webpages, 'AdGroupId'));
    }

    /**
     * Get the targeting conditions for dynamic ads for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Webpages|ModelCommonInterface
     */
    public static function getRelatedWebpages($adGroups, array $fields = []): Webpages
    {
        return DynamicTextAdTargetsService::query()
            ->select('Id','AdGroupId', ...$fields)
            ->whereIn('AdGroupIds', static::extractIds($adGroups))
            ->get();
    }
}