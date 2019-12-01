<?php 
namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Collections\Foundation\On;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Services\AdGroupsService;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/** 
 * Class AdGroups 
 * 
 * @method static     QueryBuilder              query()
 * @method static     AdGroup|AdGroups|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                    create()
 * @method            Result                    update()
 * @method            Result                    delete()
 * @method            Result                    addRelatedAds(ModelCommonInterface $ads)
 * @method            Ads                       getRelatedAds(array $fields=[])
 * @method            Result                    addRelatedAudienceTargets(ModelCommonInterface $audienceTargets)
 * @method            AudienceTargets           getRelatedAudienceTargets(array $fields=[])
 * @method            Result                    setRelatedBids($bid, $contextBid=null)
 * @method            Result                    setRelatedContextBids($contextBid)
 * @method            Result                    setRelatedStrategyPriority(string $strategyPriority)
 * @method            Result                    setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method            Bids                      getRelatedBids(array $fields=[])
 * @method            Result                    addRelatedBidModifiers(ModelCommonInterface $bidModifiers)
 * @method            Result                    enableBidModifiers(string $bidModifierType)
 * @method            Result                    disableBidModifiers(string $bidModifierType)
 * @method            BidModifiers              getRelatedBidModifiers(array $fields=[], array $levels=['CAMPAIGN','AD_GROUP'])
 * @method            Result                    addRelatedKeywords(ModelCommonInterface $keywords)
 * @method            Keywords                  getRelatedKeywords(array $fields=[])
 * @method            Result                    addRelatedWebpages(ModelCommonInterface $webpages)
 * @method            Webpages                  getRelatedWebpages(array $fields=[])
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AdGroups extends ModelCollection 
{ 
    use On;

    /**
     * @var AdGroup[] 
     */ 
    protected $items = []; 

    protected static $compatibleModel = AdGroup::class;

    protected static $staticMethods = [
        'query' => AdGroupsService::class,
        'find' => AdGroupsService::class
    ];

    protected static $methods = [
        'create' => AdGroupsService::class,
        'update' => AdGroupsService::class,
        'delete' => AdGroupsService::class,
        'addRelatedAds' => AdGroupsService::class,
        'getRelatedAds' => AdGroupsService::class,
        'addRelatedAudienceTargets' => AdGroupsService::class,
        'getRelatedAudienceTargets' => AdGroupsService::class,
        'setRelatedBids' => AdGroupsService::class,
        'setRelatedContextBids' => AdGroupsService::class,
        'setRelatedStrategyPriority' => AdGroupsService::class,
        'setRelatedBidsAuto' => AdGroupsService::class,
        'getRelatedBids' => AdGroupsService::class,
        'addRelatedBidModifiers' => AdGroupsService::class,
        'enableBidModifiers' => AdGroupsService::class,
        'disableBidModifiers' => AdGroupsService::class,
        'getRelatedBidModifiers' => AdGroupsService::class,
        'addRelatedKeywords' => AdGroupsService::class,
        'getRelatedKeywords' => AdGroupsService::class,
        'addRelatedWebpages' => AdGroupsService::class,
        'getRelatedWebpages' => AdGroupsService::class
    ];
}