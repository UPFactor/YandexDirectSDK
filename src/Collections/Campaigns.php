<?php

namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Services\CampaignsService;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/** 
 * Class Campaigns 
 * 
 * @method static     QueryBuilder                query()
 * @method static     Campaign|Campaigns|null     find(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $ids, string[] $fields)
 * @method            Result                      add()
 * @method            Result                      update()
 * @method            Result                      delete()
 * @method            Result                      suspend()
 * @method            Result                      resume()
 * @method            Result                      archive()
 * @method            Result                      unarchive()
 * @method            Result                      addRelatedAdGroups(ModelCommonInterface $adGroups)
 * @method            Result                      getRelatedAdGroups(array $fields)
 * @method            Result                      getRelatedAds(array $fields)
 * @method            Result                      getRelatedAudienceTargets(array $fields)
 * @method            Result                      setRelatedBids($bid, $contextBid=null)
 * @method            Result                      setRelatedContextBids($contextBid)
 * @method            Result                      setRelatedStrategyPriority(string $strategyPriority)
 * @method            Result                      setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method            Result                      getRelatedBids(array $fields)
 * @method            Result                      addRelatedBidModifiers(ModelCommonInterface $bidModifiers)
 * @method            Result                      enableBidModifiers(string $bidModifierType)
 * @method            Result                      disableBidModifiers(string $bidModifierType)
 * @method            Result                      getRelatedBidModifiers(array $fields)
 * @method            Result                      getRelatedKeywords(array $fields)
 * @method            Result                      getRelatedWebpages(array $fields)
 * 
 * @package YandexDirectSDK\Collections 
 */
class Campaigns extends ModelCollection
{
    /**
     * @var Campaign[]
     */
    protected $items = [];

    protected static $compatibleModel = Campaign::class;

    protected static $staticMethods = [
        'query' => CampaignsService::class,
        'find' => CampaignsService::class
    ];

    protected static $methods = [
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
        'setRelatedBids' => CampaignsService::class,
        'setRelatedContextBids' => CampaignsService::class,
        'setRelatedStrategyPriority' => CampaignsService::class,
        'setRelatedBidsAuto' => CampaignsService::class,
        'getRelatedBids' => CampaignsService::class,
        'addRelatedBidModifiers' => CampaignsService::class,
        'enableBidModifiers' => CampaignsService::class,
        'disableBidModifiers' => CampaignsService::class,
        'getRelatedBidModifiers' => CampaignsService::class,
        'getRelatedKeywords' => CampaignsService::class,
        'getRelatedWebpages' => CampaignsService::class
    ];
}