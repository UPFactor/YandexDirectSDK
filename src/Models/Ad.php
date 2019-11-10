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
 * @property          integer                  $id
 * @property-read     integer                  $campaignId
 * @property          integer                  $adGroupId
 * @property          TextAd                   $textAd
 * @property          MobileAppAd              $mobileAppAd
 * @property          DynamicTextAd            $dynamicTextAd
 * @property          TextImageAd              $textImageAd
 * @property          MobileAppImageAd         $mobileAppImageAd
 * @property          TextAdBuilderAd          $textAdBuilderAd
 * @property          MobileAppAdBuilderAd     $mobileAppAdBuilderAd
 * @property          CpmBannerAdBuilderAd     $cpmBannerAdBuilderAd
 * @property          CpcVideoAdBuilderAd      $cpcVideoAdBuilderAd
 * @property          CpmVideoAdBuilderAd      $cpmVideoAdBuilderAd
 * @property-read     string                   $status
 * @property-read     string                   $statusClarification
 * @property-read     string                   $state
 * @property-read     string[]                 $adCategories
 * @property-read     string                   $ageLabel
 * @property-read     string                   $type
 * @property-read     string                   $subtype
 *                                             
 * @method static     QueryBuilder             query()
 * @method static     Ad|Ads|null              find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                   add()
 * @method            Result                   update()
 * @method            Result                   delete()
 * @method            Result                   suspend()
 * @method            Result                   resume()
 * @method            Result                   archive()
 * @method            Result                   unarchive()
 * @method            Result                   moderate()
 * @method            $this                    setId(integer $id)
 * @method            integer                  getId()
 * @method            integer                  getCampaignId()
 * @method            $this                    setAdGroupId(integer $adGroupId)
 * @method            integer                  getAdGroupId()
 * @method            $this                    setTextAd(TextAd $textAd)
 * @method            TextAd                   getTextAd()
 * @method            $this                    setMobileAppAd(MobileAppAd $mobileAppAd)
 * @method            MobileAppAd              getMobileAppAd()
 * @method            $this                    setDynamicTextAd(DynamicTextAd $dynamicTextAd)
 * @method            DynamicTextAd            getDynamicTextAd()
 * @method            $this                    setTextImageAd(TextImageAd $textImageAd)
 * @method            TextImageAd              getTextImageAd()
 * @method            $this                    setMobileAppImageAd(MobileAppImageAd $mobileAppImageAd)
 * @method            MobileAppImageAd         getMobileAppImageAd()
 * @method            $this                    setTextAdBuilderAd(TextAdBuilderAd $textAdBuilderAd)
 * @method            TextAdBuilderAd          getTextAdBuilderAd()
 * @method            $this                    setMobileAppAdBuilderAd(MobileAppAdBuilderAd $mobileAppAdBuilderAd)
 * @method            MobileAppAdBuilderAd     getMobileAppAdBuilderAd()
 * @method            $this                    setCpmBannerAdBuilderAd(CpmBannerAdBuilderAd $cpmBannerAdBuilderAd)
 * @method            CpmBannerAdBuilderAd     getCpmBannerAdBuilderAd()
 * @method            $this                    setCpcVideoAdBuilderAd(CpcVideoAdBuilderAd $cpcVideoAdBuilderAd)
 * @method            CpcVideoAdBuilderAd      getCpcVideoAdBuilderAd()
 * @method            $this                    setCpmVideoAdBuilderAd(CpmVideoAdBuilderAd $cpmVideoAdBuilderAd)
 * @method            CpmVideoAdBuilderAd      getCpmVideoAdBuilderAd()
 * @method            string                   getStatus()
 * @method            string                   getStatusClarification()
 * @method            string                   getState()
 * @method            string[]                 getAdCategories()
 * @method            string                   getAgeLabel()
 * @method            string                   getType()
 * @method            string                   getSubtype()
 * 
 * @package YandexDirectSDK\Models 
 */
class Ad extends Model 
{
    protected static $compatibleCollection = Ads::class;

    protected static $staticMethods = [
        'query' => AdsService::class,
        'find' => AdsService::class
    ];

    protected static $methods = [
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