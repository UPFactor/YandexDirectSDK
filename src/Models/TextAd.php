<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdExtensionsAd;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class TextAd 
 * 
 * @property        string                $title 
 * @property        string                $title2 
 * @property        string                $text 
 * @property        string                $mobile 
 * @property        string                $href 
 * @property        integer               $vCardId 
 * @property        string                $adImageHash 
 * @property        integer               $sitelinkSetId 
 * @property        string                $displayUrlPath 
 * @property        integer[]             $adExtensionIds 
 * @property        VideoExtension        $videoExtension 
 * @property-read   string                $displayDomain 
 * @property-read   string                $displayUrlPathModeration 
 * @property-read   ExtensionModeration   $vCardModeration 
 * @property-read   ExtensionModeration   $sitelinksModeration 
 * @property-read   ExtensionModeration   $adImageModeration 
 * @property-read   AdExtensionsAd        $adExtensions 
 * 
 * @method          $this                 setTitle(string $title) 
 * @method          $this                 setTitle2(string $title2) 
 * @method          $this                 setText(string $text) 
 * @method          $this                 setMobile(string $mobile) 
 * @method          $this                 setHref(string $href) 
 * @method          $this                 setVCardId(integer $vCardId) 
 * @method          $this                 setAdImageHash(string $adImageHash) 
 * @method          $this                 setSitelinkSetId(integer $sitelinkSetId) 
 * @method          $this                 setDisplayUrlPath(string $displayUrlPath) 
 * @method          $this                 setAdExtensionIds(integer[] $adExtensionIds) 
 * @method          $this                 setVideoExtension(VideoExtension $videoExtension) 
 * 
 * @method          string                getTitle() 
 * @method          string                getTitle2() 
 * @method          string                getText() 
 * @method          string                getMobile() 
 * @method          string                getHref() 
 * @method          integer               getVCardId() 
 * @method          string                getAdImageHash() 
 * @method          integer               getSitelinkSetId() 
 * @method          string                getDisplayUrlPath() 
 * @method          integer[]             getAdExtensionIds() 
 * @method          VideoExtension        getVideoExtension() 
 * @method          string                getDisplayDomain() 
 * @method          string                getDisplayUrlPathModeration() 
 * @method          ExtensionModeration   getVCardModeration() 
 * @method          ExtensionModeration   getSitelinksModeration() 
 * @method          ExtensionModeration   getAdImageModeration() 
 * @method          AdExtensionsAd        getAdExtensions() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TextAd extends Model 
{ 
    const YES = 'YES';
    const NO = 'NO';

    const AGE_0 = 'AGE_0';
    const AGE_6 = 'AGE_6';
    const AGE_12 = 'AGE_12';
    const AGE_16 = 'AGE_16';
    const AGE_18 = 'AGE_18';
    const MONTHS_0 = 'MONTHS_0';
    const MONTHS_1 = 'MONTHS_1';
    const MONTHS_2 = 'MONTHS_2';
    const MONTHS_3 = 'MONTHS_3';
    const MONTHS_4 = 'MONTHS_4';
    const MONTHS_5 = 'MONTHS_5';
    const MONTHS_6 = 'MONTHS_6';
    const MONTHS_7 = 'MONTHS_7';
    const MONTHS_8 = 'MONTHS_8';
    const MONTHS_9 = 'MONTHS_9';
    const MONTHS_10 = 'MONTHS_10';
    const MONTHS_11 = 'MONTHS_11';
    const MONTHS_12 = 'MONTHS_12';

    protected $serviceProvidersMethods = [];

    protected $properties = [
        'title' => 'string',
        'title2' => 'string',
        'text' => 'string',
        'mobile' => 'enum:' . self::YES . ',' . self::NO,
        'href' => 'string',
        'displayDomain' => 'string',
        'ageLabel' => 'enum:' . self::AGE_0 . ',' . self::AGE_6 . ',' . self::AGE_12 . ',' . self::AGE_16 . ',' . self::AGE_18 . ',' . self::MONTHS_0 . ',' . self::MONTHS_1 . ',' . self::MONTHS_2 . ',' . self::MONTHS_3 . ',' . self::MONTHS_4 . ',' . self::MONTHS_5 . ',' . self::MONTHS_6 . ',' . self::MONTHS_7 . ',' . self::MONTHS_8 . ',' . self::MONTHS_9 . ',' . self::MONTHS_10 . ',' . self::MONTHS_11 . ',' . self::MONTHS_12,
        'vCardId' => 'integer',
        'vCardModeration' => 'object:' . ExtensionModeration::class,
        'adImageHash' => 'string',
        'adImageModeration' => 'object:' . ExtensionModeration::class,
        'sitelinkSetId' => 'integer',
        'sitelinksModeration' => 'object:' . ExtensionModeration::class,
        'calloutSetting' => 'object:' . AdExtensionSetting::class,
        'displayUrlPath' => 'string',
        'displayUrlPathModeration' => 'object:' . ExtensionModeration::class,
        'adExtensionIds' => 'stack:integer',
        'adExtensions' => 'object:' . AdExtensionsAd::class,
        'videoExtension' => 'object:' . VideoExtension::class
    ];

    protected $nonAddableProperties = [
        'ageLabel',
        'calloutSetting'
    ];

    protected $nonUpdatableProperties = [
        'mobile',
        'adExtensionIds'
    ];

    protected $nonWritableProperties = [
        'displayDomain',
        'vCardModeration',
        'adImageModeration',
        'sitelinksModeration',
        'displayUrlPathModeration',
        'adExtensions'
    ];
}