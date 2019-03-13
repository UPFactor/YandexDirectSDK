<?php

namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Services\CampaignsService;
use YandexDirectSDK\Interfaces\ModelCommon;

/** 
 * Class Campaigns 
 * 
 * @method   QueryBuilder   query() 
 * @method   Result         add() 
 * @method   Result         update() 
 * @method   Result         delete() 
 * @method   Result         suspend() 
 * @method   Result         resume() 
 * @method   Result         archive() 
 * @method   Result         unarchive() 
 * @method   Result         addRelatedAdGroups(ModelCommon $adGroups) 
 * @method   Result         getRelatedAdGroups(array $fields) 
 * @method   Result         getRelatedAds(array $fields) 
 * @method   Result         getRelatedAudienceTargets(array $fields) 
 * @method   Result         updateBids($bid, $contextBid) 
 * @method   Result         updateStrategyPriority(string $strategyPriority) 
 * @method   Result         updateBidsAuto(ModelCommon $bidsAuto) 
 * @method   Result         getRelatedBids(array $fields) 
 * @method   Result         addRelatedBidModifiers(ModelCommon $bidModifiers) 
 * @method   Result         enableBidModifiers(string $bidModifierType) 
 * @method   Result         disableBidModifiers(string $bidModifierType) 
 * @method   Result         getRelatedBidModifiers(array $fields) 
 * @method   Result         updateKeywordBids($searchBid, $networkBid) 
 * @method   Result         updateKeywordStrategyPriority(string $strategyPriority) 
 * @method   Result         updateKeywordBidsAuto(ModelCommon $keywordsBidsAuto) 
 * @method   Result         getRelatedKeywordBids(array $fields) 
 * @method   Result         getRelatedKeywords(array $fields) 
 * @method   Result         getRelatedWebpages(array $fields) 
 * 
 * @package YandexDirectSDK\Collections 
 */
class Campaigns extends ModelCollection
{
    /**
     * @var Campaign[]
     */
    protected $items = [];

    protected $compatibleModel = Campaign::class;

    protected $serviceProvidersMethods = [
        'query' => CampaignsService::class,
        'add' => CampaignsService::class,
        'update' => CampaignsService::class,
        'delete' => CampaignsService::class,
        'suspend' => CampaignsService::class,
        'resume' => CampaignsService::class,
        'archive' => CampaignsService::class,
        'unarchive' => CampaignsService::class,
        'addRelatedAdGroups' => CampaignsService::class,
        'getRelatedAdGroups' => CampaignsService::class,
        'getRelatedAds' => CampaignsService::class,
        'getRelatedAudienceTargets' => CampaignsService::class,
        'updateBids' => CampaignsService::class,
        'updateStrategyPriority' => CampaignsService::class,
        'updateBidsAuto' => CampaignsService::class,
        'getRelatedBids' => CampaignsService::class,
        'addRelatedBidModifiers' => CampaignsService::class,
        'enableBidModifiers' => CampaignsService::class,
        'disableBidModifiers' => CampaignsService::class,
        'getRelatedBidModifiers' => CampaignsService::class,
        'updateKeywordBids' => CampaignsService::class,
        'updateKeywordStrategyPriority' => CampaignsService::class,
        'updateKeywordBidsAuto' => CampaignsService::class,
        'getRelatedKeywordBids' => CampaignsService::class,
        'getRelatedKeywords' => CampaignsService::class,
        'getRelatedWebpages' => CampaignsService::class
    ];
}