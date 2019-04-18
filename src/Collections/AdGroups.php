<?php 
namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Services\AdGroupsService;
use YandexDirectSDK\Interfaces\ModelCommon;

/** 
 * Class AdGroups 
 * 
 * @method   QueryBuilder   query() 
 * @method   Result         add() 
 * @method   Result         update() 
 * @method   Result         delete() 
 * @method   Result         addRelatedAds(ModelCommon $ads) 
 * @method   Result         getRelatedAds(array $fields) 
 * @method   Result         addRelatedAudienceTargets(ModelCommon $audienceTargets) 
 * @method   Result         getRelatedAudienceTargets(array $fields) 
 * @method   Result         setRelatedBids(ModelCommon $bids) 
 * @method   Result         setRelatedBidsAuto(ModelCommon $bidsAuto) 
 * @method   Result         getRelatedBids(array $fields) 
 * @method   Result         addRelatedBidModifiers(ModelCommon $bidModifiers) 
 * @method   Result         enableBidModifiers(string $bidModifierType) 
 * @method   Result         disableBidModifiers(string $bidModifierType) 
 * @method   Result         getRelatedBidModifiers(array $fields) 
 * @method   Result         setRelatedKeywordBids(ModelCommon $keywordBids) 
 * @method   Result         setRelatedKeywordBidsAuto(ModelCommon $keywordsBidsAuto) 
 * @method   Result         getRelatedKeywordBids(array $fields) 
 * @method   Result         addRelatedKeywords(ModelCommon $keywords) 
 * @method   Result         getRelatedKeywords(array $fields) 
 * @method   Result         addRelatedWebpages(ModelCommon $webpages) 
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
        'setRelatedBidsAuto' => AdGroupsService::class,
        'getRelatedBids' => AdGroupsService::class,
        'addRelatedBidModifiers' => AdGroupsService::class,
        'enableBidModifiers' => AdGroupsService::class,
        'disableBidModifiers' => AdGroupsService::class,
        'getRelatedBidModifiers' => AdGroupsService::class,
        'setRelatedKeywordBids' => AdGroupsService::class,
        'setRelatedKeywordBidsAuto' => AdGroupsService::class,
        'getRelatedKeywordBids' => AdGroupsService::class,
        'addRelatedKeywords' => AdGroupsService::class,
        'getRelatedKeywords' => AdGroupsService::class,
        'addRelatedWebpages' => AdGroupsService::class,
        'getRelatedWebpages' => AdGroupsService::class
    ];
}