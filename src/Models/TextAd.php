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

    protected $serviceProvidersMethods = [];

    protected $properties = [
        'title' => 'string',
        'title2' => 'string',
        'text' => 'string',
        'mobile' => 'enum:' . self::YES . ',' . self::NO,
        'href' => 'string',
        'vCardId' => 'integer',
        'adImageHash' => 'string',
        'sitelinkSetId' => 'integer',
        'displayUrlPath' => 'string',
        'adExtensionIds' => 'stack:integer',
        'videoExtension' => 'object:' . VideoExtension::class,
        'displayDomain' => 'string',
        'displayUrlPathModeration' => 'string',
        'vCardModeration' => 'object:' . ExtensionModeration::class,
        'sitelinksModeration' => 'object:' . ExtensionModeration::class,
        'adImageModeration' => 'object:' . ExtensionModeration::class,
        'adExtensions' => 'object:' . AdExtensionsAd::class
    ];

    protected $nonWritableProperties = [
        'displayDomain',
        'displayUrlPathModeration',
        'vCardModeration',
        'sitelinksModeration',
        'adImageModeration',
        'adExtensions'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'title',
        'text',
        'mobile',
        'href|vCardId'
    ];
}