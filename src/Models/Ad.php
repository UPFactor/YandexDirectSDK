<?php 
namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Services\AdsService;

/** 
 * Class Ad 
 * 
 * @property            integer                $id
 * @property            integer                $adGroupId
 * @property            TextAd                 $textAd
 * @property            MobileAppAd            $mobileAppAd
 * @property            DynamicTextAd          $dynamicTextAd
 * @property            TextImageAd            $textImageAd
 * @property            MobileAppImageAd       $mobileAppImageAd
 * @property            TextAdBuilderAd        $textAdBuilderAd
 * @property            MobileAppAdBuilderAd   $mobileAppAdBuilderAd
 * @property            CpcVideoAdBuilderAd    $cpcVideoAdBuilderAd
 * @property            CpmBannerAdBuilderAd   $cpmBannerAdBuilderAd
 * 
 * @property-readable   integer                $campaignId
 * @property-readable   string                 $status
 * @property-readable   string                 $statusClarification
 * @property-readable   string                 $state
 * @property-readable   string[]               $adCategories
 * @property-readable   string                 $ageLabel
 * @property-readable   string                 $type
 * @property-readable   string                 $subtype
 * 
 * @method              QueryBuilder           query()
 * @method              Result                 add()
 * @method              Result                 update()
 * @method              Result                 delete()
 * @method              Result                 suspend()
 * @method              Result                 resume()
 * @method              Result                 archive()
 * @method              Result                 unarchive()
 * @method              Result                 moderate()
 * 
 * @method              $this                  setId(integer $id)
 * @method              $this                  setAdGroupId(integer $adGroupId)
 * @method              $this                  setTextAd(TextAd $textAd)
 * @method              $this                  setMobileAppAd(MobileAppAd $mobileAppAd)
 * @method              $this                  setDynamicTextAd(DynamicTextAd $dynamicTextAd)
 * @method              $this                  setTextImageAd(TextImageAd $textImageAd)
 * @method              $this                  setMobileAppImageAd(MobileAppImageAd $mobileAppImageAd)
 * @method              $this                  setTextAdBuilderAd(TextAdBuilderAd $textAdBuilderAd)
 * @method              $this                  setMobileAppAdBuilderAd(MobileAppAdBuilderAd $mobileAppAdBuilderAd)
 * @method              $this                  setCpcVideoAdBuilderAd(CpcVideoAdBuilderAd $cpcVideoAdBuilderAd)
 * @method              $this                  setCpmBannerAdBuilderAd(CpmBannerAdBuilderAd $cpmBannerAdBuilderAd)
 * 
 * @method              integer                getId()
 * @method              integer                getCampaignId()
 * @method              integer                getAdGroupId()
 * @method              TextAd                 getTextAd()
 * @method              MobileAppAd            getMobileAppAd()
 * @method              DynamicTextAd          getDynamicTextAd()
 * @method              TextImageAd            getTextImageAd()
 * @method              MobileAppImageAd       getMobileAppImageAd()
 * @method              TextAdBuilderAd        getTextAdBuilderAd()
 * @method              MobileAppAdBuilderAd   getMobileAppAdBuilderAd()
 * @method              CpcVideoAdBuilderAd    getCpcVideoAdBuilderAd()
 * @method              CpmBannerAdBuilderAd   getCpmBannerAdBuilderAd()
 * @method              string                 getStatus()
 * @method              string                 getStatusClarification()
 * @method              string                 getState()
 * @method              string[]               getAdCategories()
 * @method              string                 getAgeLabel()
 * @method              string                 getType()
 * @method              string                 getSubtype()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Ad extends Model 
{
    protected static $compatibleCollection = Ads::class;

    protected static $serviceMethods = [
        'query' => AdsService::class,
        'add' => AdsService::class,
        'update' => AdsService::class,
        'delete' => AdsService::class,
        'suspend' => AdsService::class,
        'resume' => AdsService::class,
        'archive' => AdsService::class,
        'unarchive' => AdsService::class,
        'moderate' => AdsService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'textAd' => 'object:' . TextAd::class,
        'mobileAppAd' => 'object:' . MobileAppAd::class,
        'dynamicTextAd' => 'object:' . DynamicTextAd::class,
        'textImageAd' => 'object:' . TextImageAd::class,
        'mobileAppImageAd' => 'object:' . MobileAppImageAd::class,
        'textAdBuilderAd' => 'object:' . TextAdBuilderAd::class,
        'mobileAppAdBuilderAd' => 'object:' . MobileAppAdBuilderAd::class,
        'cpmBannerAdBuilderAd' => 'object:' . CpmBannerAdBuilderAd::class,
        'cpcVideoAdBuilderAd' => 'object:' . CpcVideoAdBuilderAd::class,
        'cpmVideoAdBuilderAd' => 'object:' . CpmVideoAdBuilderAd::class,
        'status' => 'string',
        'statusClarification' => 'string',
        'state' => 'string',
        'adCategories' => 'array:string',
        'ageLabel' => 'string',
        'type' => 'string',
        'subtype' => 'string'
    ];

    protected static $nonUpdatableProperties = [
        'adGroupId'
    ];

    protected static $nonWritableProperties = [
        'campaignId',
        'status',
        'statusClarification',
        'state',
        'adCategories',
        'ageLabel',
        'type',
        'subtype'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}