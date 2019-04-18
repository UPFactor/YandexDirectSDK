<?php 
namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Services\AdGroupsService;
use YandexDirectSDK\Interfaces\ModelCommon;

/** 
 * Class AdGroup 
 * 
 * @property            integer                  $id 
 * @property            string                   $name 
 * @property            integer                  $campaignId 
 * @property            integer[]                $regionIds 
 * @property-readable   integer[]                $restrictedRegionIds 
 * @property            string[]                 $negativeKeywords 
 * @property            string                   $trackingParams 
 * @property            MobileAppAdGroup         $mobileAppAdGroup 
 * @property            DynamicTextAdGroup       $dynamicTextAdGroup 
 * @property-readable   DynamicTextFeedAdGroup   $dynamicTextFeedAdGroup 
 * @property            string                   $cpmBannerKeywordsAdGroup 
 * @property            string                   $cpmBannerUserProfileAdGroup 
 * @property-readable   string                   $status 
 * @property-readable   string                   $servingStatus 
 * @property-readable   string                   $type 
 * @property-readable   string                   $subtype 
 * 
 * @method              $this                    setId(integer $id) 
 * @method              $this                    setName(string $name) 
 * @method              $this                    setCampaignId(integer $campaignId) 
 * @method              $this                    setRegionIds(integer[] $regionIds) 
 * @method              $this                    setNegativeKeywords(string[] $negativeKeywords) 
 * @method              $this                    setTrackingParams(string $trackingParams) 
 * @method              $this                    setMobileAppAdGroup(MobileAppAdGroup $mobileAppAdGroup) 
 * @method              $this                    setDynamicTextAdGroup(DynamicTextAdGroup $dynamicTextAdGroup) 
 * @method              $this                    setCpmBannerKeywordsAdGroup(string $cpmBannerKeywordsAdGroup) 
 * @method              $this                    setCpmBannerUserProfileAdGroup(string $cpmBannerUserProfileAdGroup) 
 * 
 * @method              integer                  getId() 
 * @method              string                   getName() 
 * @method              integer                  getCampaignId() 
 * @method              integer[]                getRegionIds() 
 * @method              integer[]                getRestrictedRegionIds() 
 * @method              string[]                 getNegativeKeywords() 
 * @method              string                   getTrackingParams() 
 * @method              MobileAppAdGroup         getMobileAppAdGroup() 
 * @method              DynamicTextAdGroup       getDynamicTextAdGroup() 
 * @method              DynamicTextFeedAdGroup   getDynamicTextFeedAdGroup() 
 * @method              string                   getCpmBannerKeywordsAdGroup() 
 * @method              string                   getCpmBannerUserProfileAdGroup() 
 * @method              string                   getStatus() 
 * @method              string                   getServingStatus() 
 * @method              string                   getType() 
 * @method              string                   getSubtype() 
 * 
 * @method              QueryBuilder             query() 
 * @method              Result                   add() 
 * @method              Result                   update() 
 * @method              Result                   delete() 
 * @method              Result                   addRelatedAds(ModelCommon $ads) 
 * @method              Result                   getRelatedAds(array $fields) 
 * @method              Result                   addRelatedAudienceTargets(ModelCommon $audienceTargets) 
 * @method              Result                   getRelatedAudienceTargets(array $fields) 
 * @method              Result                   setRelatedBids(ModelCommon $bids) 
 * @method              Result                   setRelatedBidsAuto(ModelCommon $bidsAuto) 
 * @method              Result                   getRelatedBids(array $fields) 
 * @method              Result                   addRelatedBidModifiers(ModelCommon $bidModifiers) 
 * @method              Result                   enableBidModifiers(string $bidModifierType) 
 * @method              Result                   disableBidModifiers(string $bidModifierType) 
 * @method              Result                   getRelatedBidModifiers(array $fields) 
 * @method              Result                   setRelatedKeywordBids(ModelCommon $keywordBids) 
 * @method              Result                   setRelatedKeywordBidsAuto(ModelCommon $keywordsBidsAuto) 
 * @method              Result                   getRelatedKeywordBids(array $fields) 
 * @method              Result                   addRelatedKeywords(ModelCommon $keywords) 
 * @method              Result                   getRelatedKeywords(array $fields) 
 * @method              Result                   addRelatedWebpages(ModelCommon $webpages) 
 * @method              Result                   getRelatedWebpages(array $fields) 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdGroup extends Model 
{ 
    protected $compatibleCollection = AdGroups::class;

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

    protected $properties = [
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

    protected $nonUpdatableProperties = [
        'CampaignId',
        'cpmBannerKeywordsAdGroup',
        'cpmBannerUserProfileAdGroup'
    ];

    protected $nonWritableProperties = [
        'restrictedRegionIds',
        'dynamicTextFeedAdGroup',
        'status',
        'servingStatus',
        'type',
        'subtype'
    ];
}