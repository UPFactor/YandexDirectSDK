<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\BidModifierToggle;
use YandexDirectSDK\Models\Campaign;

/** 
 * Class CampaignsService 
 * 
 * @method static     Result                      add(Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method static     QueryBuilder                query()
 * @method static     Campaign|Campaigns|null     find(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $ids, string[] $fields)
 * @method static     Result                      update(Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method static     Result                      archive(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method static     Result                      delete(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method static     Result                      resume(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method static     Result                      suspend(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method static     Result                      unarchive(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns)
 * 
 * @package YandexDirectSDK\Services 
 */
class CampaignsService extends Service
{
    protected static $name = 'campaigns';

    protected static $modelClass = Campaign::class;

    protected static $modelCollectionClass = Campaigns::class;

    protected static $methods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'update' => 'update:updateCollection',
        'archive' => 'archive:actionByIds',
        'delete' => 'delete:actionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds',
        'unarchive' => 'unarchive:actionByIds'
    ];

    /**
     * Add ad groups for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @return Result
     */
    public static function addRelatedAdGroups($campaigns, ModelCommonInterface $adGroups): Result
    {
        return AdGroupsService::add(static::bind($campaigns, $adGroups, 'CampaignId'));
    }

    /**
     * Gets ad groups for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     */
    public static function getRelatedAdGroups($campaigns, array $fields): Result
    {
        return AdGroupsService::query()
            ->select($fields)
            ->whereIn('CampaignIds',  static::extractIds($campaigns))
            ->get();

    }

    /**
     * Gets ads for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     */
    public static function getRelatedAds($campaigns, array $fields): Result
    {
        return AdsService::query()
            ->select($fields)
            ->whereIn('CampaignIds',  static::extractIds($campaigns))
            ->get();

    }

    /**
     * Gets audience targets for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     */
    public static function getRelatedAudienceTargets($campaigns, array $fields): Result
    {
        return AudienceTargetsService::query()
            ->select($fields)
            ->whereIn('CampaignIds',  static::extractIds($campaigns))
            ->get();
    }

    /**
     * Sets bids for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param integer $bid
     * @param integer|null $contextBid
     * @return Result
     */
    public static function setRelatedBids($campaigns, $bid, $contextBid = null):Result
    {
        $campaignIds = static::extractIds($campaigns);
        $bids = new Bids();

        if (func_num_args() > 2){
            foreach ($campaignIds as $id){
                $bids->push(
                    Bid::make()
                        ->setCampaignId($id)
                        ->setBid($bid)
                        ->setContextBid( $contextBid)
                );
            }
        } else {
            foreach ($campaignIds as $id){
                $bids->push(
                    Bid::make()
                        ->setCampaignId($id)
                        ->setBid($bid)
                );
            }
        }

        return BidsService::set($bids);
    }

    /**
     * Sets context bids for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param integer $contextBid
     * @return Result
     */
    public static function setRelatedContextBids($campaigns, $contextBid):Result
    {
        $campaignIds = static::extractIds($campaigns);
        $bids = new Bids();

        foreach ($campaignIds as $id){
            $bids->push(
                Bid::make()
                    ->setCampaignId($id)
                    ->setContextBid($contextBid)
            );
        }

        return BidsService::set($bids);
    }

    /**
     * Sets strategy priority for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param string $strategyPriority
     * @return Result
     */
    public static function setRelatedStrategyPriority($campaigns, string $strategyPriority):Result
    {
        $campaignIds = static::extractIds($campaigns);
        $bids = new Bids();

        foreach ($campaignIds as $id){
            $bids->push(
                Bid::make()
                    ->setCampaignId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return BidsService::set($bids);
    }

    /**
     * Sets bid designer options for all keywords in given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param BidAuto|BidsAuto|ModelCommonInterface $bidsAuto
     * @return Result
     */
    public static function setRelatedBidsAuto($campaigns, ModelCommonInterface $bidsAuto): Result
    {
        return BidsService::setAuto(static::bind($campaigns, $bidsAuto, 'CampaignId'));
    }

    /**
     * Gets bids for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     */
    public static function getRelatedBids($campaigns, array $fields): Result
    {
        return BidsService::query()
            ->select($fields)
            ->whereIn('CampaignIds',  static::extractIds($campaigns))
            ->get();
    }

    /**
     * Add bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param BidModifier|BidModifiers|ModelCommonInterface $bidModifiers
     * @return Result
     */
    public static function addRelatedBidModifiers($campaigns, ModelCommonInterface $bidModifiers): Result
    {
        return BidModifiersService::add(static::bind($campaigns, $bidModifiers, 'CampaignId'));
    }

    /**
     * Enable bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param string $bidModifierType
     * @return Result
     */
    public static function enableBidModifiers($campaigns, string $bidModifierType): Result
    {
        $collection = new BidModifierToggles();

        foreach (static::extractIds($campaigns) as $id){
            $collection->push(
                BidModifierToggle::make([
                    'CampaignId' => $id,
                    'Type' => $bidModifierType,
                    'Enabled' => BidModifierToggle::YES
                ])
            );
        }

        return BidModifiersService::toggle($collection);
    }

    /**
     * Disable bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param string $bidModifierType
     * @return Result
     */
    public static function disableBidModifiers($campaigns, string $bidModifierType): Result
    {
        $collection = new BidModifierToggles();

        foreach (static::extractIds($campaigns) as $id){
            $collection->push(
                BidModifierToggle::make([
                    'CampaignId' => $id,
                    'Type' => $bidModifierType,
                    'Enabled' => BidModifierToggle::NO
                ])
            );
        }

        return BidModifiersService::toggle($collection);
    }

    /**
     * Get bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     */
    public static function getRelatedBidModifiers($campaigns, array $fields): Result
    {
        return BidModifiersService::query()
            ->select($fields)
            ->whereIn('CampaignIds', static::extractIds($campaigns))
            ->whereIn('Levels', ['CAMPAIGN','AD_GROUP'])
            ->get();
    }

    /**
     * Gets keywords for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     */
    public static function getRelatedKeywords($campaigns, array $fields): Result
    {
        return KeywordsService::query()
            ->select($fields)
            ->whereIn('CampaignIds', static::extractIds($campaigns))
            ->get();
    }

    /**
     * Get the targeting conditions for dynamic ads for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     */
    public static function getRelatedWebpages($campaigns, array $fields): Result
    {
        return DynamicTextAdTargetsService::query()
            ->select($fields)
            ->whereIn('CampaignIds', static::extractIds($campaigns))
            ->get();
    }
}