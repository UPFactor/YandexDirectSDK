<?php 
namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Services\AdGroupsService;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/** 
 * Class AdGroups 
 * 
 * @method   QueryBuilder   query()
 * @method   Result         add()
 * @method   Result         update()
 * @method   Result         delete()
 * @method   Result         addRelatedAds(ModelCommonInterface $ads)
 * @method   Result         getRelatedAds(array $fields)
 * @method   Result         addRelatedAudienceTargets(ModelCommonInterface $audienceTargets)
 * @method   Result         getRelatedAudienceTargets(array $fields)
 * @method   Result         setRelatedBids($bid, $contextBid = null)
 * @method   Result         setRelatedContextBids($contextBid)
 * @method   Result         setRelatedStrategyPriority(string $strategyPriority)
 * @method   Result         setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method   Result         getRelatedBids(array $fields)
 * @method   Result         addRelatedBidModifiers(ModelCommonInterface $bidModifiers)
 * @method   Result         enableBidModifiers(string $bidModifierType)
 * @method   Result         disableBidModifiers(string $bidModifierType)
 * @method   Result         getRelatedBidModifiers(array $fields)
 * @method   Result         addRelatedKeywords(ModelCommonInterface $keywords)
 * @method   Result         getRelatedKeywords(array $fields)
 * @method   Result         addRelatedWebpages(ModelCommonInterface $webpages)
 * @method   Result         getRelatedWebpages(array $fields)
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class AdGroups extends ModelCollection 
{ 
    /** 
     * @var AdGroup[] 
     */ 
    protected $items = []; 

    protected $compatibleModel = AdGroup::class;

    protected $serviceProvidersMethods = [
        'query' => AdGroupsService::class,
        'add' => AdGroupsService::class,
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