<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdExtensionsAd;
use YandexDirectSDK\Components\Model as Model;
use YandexDirectSDK\Models\Traits\SetAdImage;

/** 
 * Class TextAd 
 * 
 * @property          string                  $title
 * @property          string                  $title2
 * @property          string                  $text
 * @property          string                  $mobile
 * @property          integer                 $turboPageId
 * @property-read     TurboPageModeration     $turboPageModeration
 * @property          string                  $href
 * @property-read     string                  $displayDomain
 * @property          string                  $ageLabel
 * @property          integer                 $vCardId
 * @property-read     ExtensionModeration     $vCardModeration
 * @property          string                  $adImageHash
 * @property-read     ExtensionModeration     $adImageModeration
 * @property          integer                 $sitelinkSetId
 * @property-read     ExtensionModeration     $sitelinksModeration
 * @property          AdExtensionSetting      $calloutSetting
 * @property          string                  $displayUrlPath
 * @property-read     ExtensionModeration     $displayUrlPathModeration
 * @property          integer[]               $adExtensionIds
 * @property-read     AdExtensionsAd          $adExtensions
 * @property          VideoExtension          $videoExtension
 * @property          PriceExtension          $priceExtension
 *                                            
 * @method            $this                   setTitle(string $title)
 * @method            string                  getTitle()
 * @method            $this                   setTitle2(string $title2)
 * @method            string                  getTitle2()
 * @method            $this                   setText(string $text)
 * @method            string                  getText()
 * @method            $this                   setMobile(string $mobile)
 * @method            string                  getMobile()
 * @method            $this                   setTurboPageId(integer $turboPageId)
 * @method            integer                 getTurboPageId()
 * @method            TurboPageModeration     getTurboPageModeration()
 * @method            $this                   setHref(string $href)
 * @method            string                  getHref()
 * @method            string                  getDisplayDomain()
 * @method            $this                   setAgeLabel(string $ageLabel)
 * @method            string                  getAgeLabel()
 * @method            $this                   setVCardId(integer $vCardId)
 * @method            integer                 getVCardId()
 * @method            ExtensionModeration     getVCardModeration()
 * @method            $this                   setAdImageHash(string $adImageHash)
 * @method            string                  getAdImageHash()
 * @method            ExtensionModeration     getAdImageModeration()
 * @method            $this                   setSitelinkSetId(integer $sitelinkSetId)
 * @method            integer                 getSitelinkSetId()
 * @method            ExtensionModeration     getSitelinksModeration()
 * @method            $this                   setCalloutSetting(AdExtensionSetting $calloutSetting)
 * @method            AdExtensionSetting      getCalloutSetting()
 * @method            $this                   setDisplayUrlPath(string $displayUrlPath)
 * @method            string                  getDisplayUrlPath()
 * @method            ExtensionModeration     getDisplayUrlPathModeration()
 * @method            $this                   setAdExtensionIds(integer[] $adExtensionIds)
 * @method            integer[]               getAdExtensionIds()
 * @method            AdExtensionsAd          getAdExtensions()
 * @method            $this                   setVideoExtension(VideoExtension $videoExtension)
 * @method            VideoExtension          getVideoExtension()
 * @method            $this                   setPriceExtension(PriceExtension $priceExtension)
 * @method            PriceExtension          getPriceExtension()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TextAd extends Model 
{
    use SetAdImage;

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

    protected static $properties = [
        'title' => 'string',
        'title2' => 'string',
        'text' => 'string',
        'mobile' => 'enum:' . self::YES . ',' . self::NO,
        'turboPageId' => 'integer',
        'turboPageModeration' => 'object:' . TurboPageModeration::class,
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
        'videoExtension' => 'object:' . VideoExtension::class,
        'priceExtension' => 'object:' . PriceExtension::class
    ];

    protected static $nonAddableProperties = [
        'ageLabel',
        'calloutSetting'
    ];

    protected static $nonUpdatableProperties = [
        'mobile',
        'adExtensionIds'
    ];

    protected static $nonWritableProperties = [
        'turboPageModeration',
        'displayDomain',
        'vCardModeration',
        'adImageModeration',
        'sitelinksModeration',
        'displayUrlPathModeration',
        'adExtensions'
    ];
}