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
 * @property        integer                  $id
 * @property        string                   $name
 * @property        integer                  $campaignId
 * @property        integer[]                $regionIds
 * @property        string[]                 $negativeKeywords
 * @property        string                   $trackingParams
 * @property        MobileAppAdGroup         $mobileAppAdGroup
 * @property        DynamicTextAdGroup       $dynamicTextAdGroup
 * @property        string                   $cpmBannerKeywordsAdGroup
 * @property        string                   $cpmBannerUserProfileAdGroup
 * 
 * @property-read   integer[]                $restrictedRegionIds
 * @property-read   DynamicTextFeedAdGroup   $dynamicTextFeedAdGroup
 * @property-read   string                   $status
 * @property-read   string                   $servingStatus
 * @property-read   string                   $type
 * @property-read   string                   $subtype
 * 
 * @method          QueryBuilder             query()
 * @method          Result                   add()
 * @method          Result                   update()
 * @method          Result                   delete()
 * @method          Result                   addRelatedAds(ModelCommonInterface $ads)
 * @method          Result                   getRelatedAds(array $fields)
 * @method          Result                   addRelatedAudienceTargets(ModelCommonInterface $audienceTargets)
 * @method          Result                   getRelatedAudienceTargets(array $fields)
 * @method          Result                   setRelatedBids($bid, $contextBid = null)
 * @method          Result                   setRelatedContextBids($contextBid)
 * @method          Result                   setRelatedStrategyPriority(string $strategyPriority)
 * @method          Result                   setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method          Result                   getRelatedBids(array $fields)
 * @method          Result                   addRelatedBidModifiers(ModelCommonInterface $bidModifiers)
 * @method          Result                   enableBidModifiers(string $bidModifierType)
 * @method          Result                   disableBidModifiers(string $bidModifierType)
 * @method          Result                   getRelatedBidModifiers(array $fields)
 * @method          Result                   addRelatedKeywords(ModelCommonInterface $keywords)
 * @method          Result                   getRelatedKeywords(array $fields)
 * @method          Result                   addRelatedWebpages(ModelCommonInterface $webpages)
 * @method          Result                   getRelatedWebpages(array $fields)
 * 
 * @method          $this                    setId(integer $id)
 * @method          $this                    setName(string $name)
 * @method          $this                    setCampaignId(integer $campaignId)
 * @method          $this                    setRegionIds(integer[] $regionIds)
 * @method          $this                    setNegativeKeywords(string[] $negativeKeywords)
 * @method          $this                    setTrackingParams(string $trackingParams)
 * @method          $this                    setMobileAppAdGroup(MobileAppAdGroup $mobileAppAdGroup)
 * @method          $this                    setDynamicTextAdGroup(DynamicTextAdGroup $dynamicTextAdGroup)
 * @method          $this                    setCpmBannerKeywordsAdGroup(string $cpmBannerKeywordsAdGroup)
 * @method          $this                    setCpmBannerUserProfileAdGroup(string $cpmBannerUserProfileAdGroup)
 * 
 * @method          integer                  getId()
 * @method          string                   getName()
 * @method          integer                  getCampaignId()
 * @method          integer[]                getRegionIds()
 * @method          integer[]                getRestrictedRegionIds()
 * @method          string[]                 getNegativeKeywords()
 * @method          string                   getTrackingParams()
 * @method          MobileAppAdGroup         getMobileAppAdGroup()
 * @method          DynamicTextAdGroup       getDynamicTextAdGroup()
 * @method          DynamicTextFeedAdGroup   getDynamicTextFeedAdGroup()
 * @method          string                   getCpmBannerKeywordsAdGroup()
 * @method          string                   getCpmBannerUserProfileAdGroup()
 * @method          string                   getStatus()
 * @method          string                   getServingStatus()
 * @method          string                   getType()
 * @method          string                   getSubtype()
 * 
 * @package YandexDirectSDK\Models 
 */
class AdGroup extends Model 
{ 
    protected static $compatibleCollection = AdGroups::class;

    protected static $serviceMethods = [
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

    protected static $properties = [
        'id' => 'integer',
        'name' => 'string',
        'campaignId' => 'integer',
        'regionIds' => 'stack:integer',
        'restrictedRegionIds' => 'array:integer',
        'negativeKeywords' => 'array:string',
        'trackingParams' => 'string',
        'mobileAppAdGroup' => 'object:' . MobileAppAdGroup::class,
        'dynamicTextAdGroup' => 'object:' . DynamicTextAdGroup::class,
        'dynamicTextFeedAdGroup' => 'object:' . DynamicTextFeedAdGroup::class,
        'cpmBannerKeywordsAdGroup' => 'string',
        'cpmBannerUserProfileAdGroup' => 'string',
        'status' => 'string',
        'servingStatus' => 'string',
        'type' => 'string',
        'subtype' => 'string',

    ];

    protected static $nonUpdatableProperties = [
        'campaignId',
        'cpmBannerKeywordsAdGroup',
        'cpmBannerUserProfileAdGroup'
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