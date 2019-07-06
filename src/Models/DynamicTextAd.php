<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdExtensionsAd;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class DynamicTextAd 
 * 
 * @property            string                $text
 * @property            integer               $vCardId
 * @property            string                $adImageHash
 * @property            integer               $sitelinkSetId
 * @property            AdExtensionSetting    $calloutSetting
 * @property            integer[]             $adExtensionIds
 * 
 * @property-readable   ExtensionModeration   $vCardModeration
 * @property-readable   ExtensionModeration   $adImageModeration
 * @property-readable   ExtensionModeration   $sitelinksModeration
 * @property-readable   AdExtensionsAd        $adExtensions
 * 
 * @method              $this                 setText(string $text)
 * @method              $this                 setVCardId(integer $vCardId)
 * @method              $this                 setAdImageHash(string $adImageHash)
 * @method              $this                 setSitelinkSetId(integer $sitelinkSetId)
 * @method              $this                 setCalloutSetting(AdExtensionSetting $calloutSetting)
 * @method              $this                 setAdExtensionIds(integer[] $adExtensionIds)
 * 
 * @method              string                getText()
 * @method              integer               getVCardId()
 * @method              ExtensionModeration   getVCardModeration()
 * @method              string                getAdImageHash()
 * @method              ExtensionModeration   getAdImageModeration()
 * @method              integer               getSitelinkSetId()
 * @method              ExtensionModeration   getSitelinksModeration()
 * @method              AdExtensionSetting    getCalloutSetting()
 * @method              integer[]             getAdExtensionIds()
 * @method              AdExtensionsAd        getAdExtensions()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextAd extends Model 
{ 
    protected static $serviceMethods = [];

    protected static $properties = [
        'text' => 'string',
        'vCardId' => 'integer',
        'vCardModeration' => 'object:' . ExtensionModeration::class,
        'adImageHash' => 'string',
        'adImageModeration' => 'object:' . ExtensionModeration::class,
        'sitelinkSetId' => 'integer',
        'sitelinksModeration' => 'object:' . ExtensionModeration::class,
        'calloutSetting' => 'object:' . AdExtensionSetting::class,
        'adExtensionIds' => 'stack:integer',
        'adExtensions' => 'object:' . AdExtensionsAd::class
    ];

    protected static $nonAddableProperties = [
        'calloutSetting'
    ];

    protected static $nonUpdatableProperties = [
        'adExtensionIds'
    ];

    protected static $nonWritableProperties = [
        'vCardModeration',
        'sitelinksModeration',
        'adImageModeration',
        'adExtensions'
    ];
}