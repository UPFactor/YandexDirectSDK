<?php 
namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Services\AdGroupsService;

/** 
 * Class AdGroup 
 * 
 * @property        integer                  $id 
 * @property-read   integer[]                $restrictedRegionIds 
 * @property-read   string                   $status 
 * @property-read   string                   $servingStatus 
 * @property-read   string                   $type 
 * @property-read   string                   $subtype 
 * @property        string                   $name 
 * @property        integer                  $campaignId 
 * @property        integer[]                $regionIds 
 * @property        string[]                 $negativeKeywords 
 * @property        string                   $trackingParams 
 * @property        MobileAppAdGroup         $mobileAppAdGroup 
 * @property        DynamicTextAdGroup       $dynamicTextAdGroup 
 * @property-read   DynamicTextFeedAdGroup   $dynamicTextFeedAdGroup 
 * @property        string                   $cpmBannerKeywordsAdGroup 
 * @property        string                   $cpmBannerUserProfileAdGroup 
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
 * @method          integer[]                getRestrictedRegionIds() 
 * @method          string                   getStatus() 
 * @method          string                   getServingStatus() 
 * @method          string                   getType() 
 * @method          string                   getSubtype() 
 * @method          string                   getName() 
 * @method          integer                  getCampaignId() 
 * @method          integer[]                getRegionIds() 
 * @method          string[]                 getNegativeKeywords() 
 * @method          string                   getTrackingParams() 
 * @method          MobileAppAdGroup         getMobileAppAdGroup() 
 * @method          DynamicTextAdGroup       getDynamicTextAdGroup() 
 * @method          DynamicTextFeedAdGroup   getDynamicTextFeedAdGroup() 
 * @method          string                   getCpmBannerKeywordsAdGroup() 
 * @method          string                   getCpmBannerUserProfileAdGroup() 
 * 
 * @method          QueryBuilder             query() 
 * @method          Result                   add() 
 * @method          Result                   update() 
 * @method          Result                   delete() 
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
        'delete' => AdGroupsService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'restrictedRegionIds' => 'array:integer',
        'status' => 'string',
        'servingStatus' => 'string',
        'type' => 'string',
        'subtype' => 'string',
        'name' => 'string',
        'campaignId' => 'integer',
        'regionIds' => 'stack:integer',
        'negativeKeywords' => 'array:string',
        'trackingParams' => 'string',
        'mobileAppAdGroup' => 'object:' . MobileAppAdGroup::class,
        'dynamicTextAdGroup' => 'object:' . DynamicTextAdGroup::class,
        'dynamicTextFeedAdGroup' => 'object:' . DynamicTextFeedAdGroup::class,
        'cpmBannerKeywordsAdGroup' => 'string', //todo: Чтобы создать такую группу, укажите пустую структуру
        'cpmBannerUserProfileAdGroup' => 'string' //todo: Чтобы создать такую группу, укажите пустую структуру
    ];

    protected $nonWritableProperties = [
        'restrictedRegionIds',
        'status',
        'servingStatus',
        'type',
        'subtype',
        'dynamicTextFeedAdGroup'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'name',
        'campaignId',
        'regionIds'
    ];
}