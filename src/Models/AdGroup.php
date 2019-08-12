<?php 
namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Services\AdGroupsService;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/** 
 * Class AdGroup 
 * 
 * @property          integer                    $id
 * @property          string                     $name
 * @property          integer                    $campaignId
 * @property          integer[]                  $regionIds
 * @property-read     integer[]                  $restrictedRegionIds
 * @property          string[]                   $negativeKeywords
 * @property          integer[]                  $negativeKeywordSharedSetIds
 * @property          string                     $trackingParams
 * @property          MobileAppAdGroup           $mobileAppAdGroup
 * @property          DynamicTextAdGroup         $dynamicTextAdGroup
 * @property-read     DynamicTextFeedAdGroup     $dynamicTextFeedAdGroup
 * @property          string                     $cpmBannerKeywordsAdGroup
 * @property          string                     $cpmBannerUserProfileAdGroup
 * @property          string                     $cpmVideoAdGroup
 * @property-read     string                     $status
 * @property-read     string                     $servingStatus
 * @property-read     string                     $type
 * @property-read     string                     $subtype
 *                                               
 * @method static     QueryBuilder               query()
 * @method static     AdGroup|AdGroups|null      find(integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $ids, string[] $fields)
 * @method            Result                     add()
 * @method            Result                     update()
 * @method            Result                     delete()
 * @method            Result                     addRelatedAds(ModelCommonInterface $ads)
 * @method            Result                     getRelatedAds(array $fields)
 * @method            Result                     addRelatedAudienceTargets(ModelCommonInterface $audienceTargets)
 * @method            Result                     getRelatedAudienceTargets(array $fields)
 * @method            Result                     setRelatedBids($bid, $contextBid=null)
 * @method            Result                     setRelatedContextBids($contextBid)
 * @method            Result                     setRelatedStrategyPriority(string $strategyPriority)
 * @method            Result                     setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method            Result                     getRelatedBids(array $fields)
 * @method            Result                     addRelatedBidModifiers(ModelCommonInterface $bidModifiers)
 * @method            Result                     enableBidModifiers(string $bidModifierType)
 * @method            Result                     disableBidModifiers(string $bidModifierType)
 * @method            Result                     getRelatedBidModifiers(array $fields)
 * @method            Result                     addRelatedKeywords(ModelCommonInterface $keywords)
 * @method            Result                     getRelatedKeywords(array $fields)
 * @method            Result                     addRelatedWebpages(ModelCommonInterface $webpages)
 * @method            Result                     getRelatedWebpages(array $fields)
 * @method            $this                      setId(integer $id)
 * @method            integer                    getId()
 * @method            $this                      setName(string $name)
 * @method            string                     getName()
 * @method            $this                      setCampaignId(integer $campaignId)
 * @method            integer                    getCampaignId()
 * @method            $this                      setRegionIds(integer[] $regionIds)
 * @method            integer[]                  getRegionIds()
 * @method            integer[]                  getRestrictedRegionIds()
 * @method            $this                      setNegativeKeywords(string[] $negativeKeywords)
 * @method            string[]                   getNegativeKeywords()
 * @method            $this                      setNegativeKeywordSharedSetIds(integer[] $negativeKeywordSharedSetIds)
 * @method            integer[]                  getNegativeKeywordSharedSetIds()
 * @method            $this                      setTrackingParams(string $trackingParams)
 * @method            string                     getTrackingParams()
 * @method            $this                      setMobileAppAdGroup(MobileAppAdGroup $mobileAppAdGroup)
 * @method            MobileAppAdGroup           getMobileAppAdGroup()
 * @method            $this                      setDynamicTextAdGroup(DynamicTextAdGroup $dynamicTextAdGroup)
 * @method            DynamicTextAdGroup         getDynamicTextAdGroup()
 * @method            DynamicTextFeedAdGroup     getDynamicTextFeedAdGroup()
 * @method            $this                      setCpmBannerKeywordsAdGroup(string $cpmBannerKeywordsAdGroup)
 * @method            string                     getCpmBannerKeywordsAdGroup()
 * @method            $this                      setCpmBannerUserProfileAdGroup(string $cpmBannerUserProfileAdGroup)
 * @method            string                     getCpmBannerUserProfileAdGroup()
 * @method            $this                      setCpmVideoAdGroup(string $cpmVideoAdGroup)
 * @method            string                     getCpmVideoAdGroup()
 * @method            string                     getStatus()
 * @method            string                     getServingStatus()
 * @method            string                     getType()
 * @method            string                     getSubtype()
 * 
 * @package YandexDirectSDK\Models 
 */
class AdGroup extends Model 
{ 
    protected static $compatibleCollection = AdGroups::class;

    protected static $staticMethods = [
        'query' => AdGroupsService::class,
        'find' => AdGroupsService::class
    ];

    protected static $methods = [
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

    protected static $properties = [
        'id' => 'integer',
        'name' => 'string',
        'campaignId' => 'integer',
        'regionIds' => 'stack:integer',
        'restrictedRegionIds' => 'array:integer',
        'negativeKeywords' => 'array:string',
        'negativeKeywordSharedSetIds' => 'array:integer',
        'trackingParams' => 'string',
        'mobileAppAdGroup' => 'object:' . MobileAppAdGroup::class,
        'dynamicTextAdGroup' => 'object:' . DynamicTextAdGroup::class,
        'dynamicTextFeedAdGroup' => 'object:' . DynamicTextFeedAdGroup::class,
        'cpmBannerKeywordsAdGroup' => 'string',
        'cpmBannerUserProfileAdGroup' => 'string',
        'cpmVideoAdGroup' => 'string',
        'status' => 'string',
        'servingStatus' => 'string',
        'type' => 'string',
        'subtype' => 'string',

    ];

    protected static $nonUpdatableProperties = [
        'campaignId',
        'cpmBannerKeywordsAdGroup',
        'cpmBannerUserProfileAdGroup',
        'cpmVideoAdGroup'
    ];

    protected static $nonWritableProperties = [
        'restrictedRegionIds',
        'dynamicTextFeedAdGroup',
        'status',
        'servingStatus',
        'type',
        'subtype'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}