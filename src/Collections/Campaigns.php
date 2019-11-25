<?php

namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Collections\Foundation\On;
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
 * @method static     Campaign|Campaigns|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                      add()
 * @method            Result                      update()
 * @method            Result                      delete()
 * @method            Result                      suspend()
 * @method            Result                      resume()
 * @method            Result                      archive()
 * @method            Result                      unarchive()
 * @method            Result                      addRelatedAdGroups(ModelCommonInterface $adGroups)
 * @method            AdGroups                    getRelatedAdGroups(array $fields=[])
 * @method            Ads                         getRelatedAds(array $fields=[])
 * @method            AudienceTargets             getRelatedAudienceTargets(array $fields=[])
 * @method            Result                      setRelatedBids($bid, $contextBid=null)
 * @method            Result                      setRelatedContextBids($contextBid)
 * @method            Result                      setRelatedStrategyPriority(string $strategyPriority)
 * @method            Result                      setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method            Bids                        getRelatedBids(array $fields=[])
 * @method            Result                      addRelatedBidModifiers(ModelCommonInterface $bidModifiers)
 * @method            Result                      enableBidModifiers(string $bidModifierType)
 * @method            Result                      disableBidModifiers(string $bidModifierType)
 * @method            BidModifiers                getRelatedBidModifiers(array $fields=[])
 * @method            Keywords                    getRelatedKeywords(array $fields=[])
 * @method            Webpages                    getRelatedWebpages(array $fields=[])
 * 
 * @package YandexDirectSDK\Collections 
 */
class Campaigns extends ModelCollection
{
    use On;

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