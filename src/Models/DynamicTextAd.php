<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdExtensionsAd;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class DynamicTextAd 
 * 
 * @property          string                  $text
 * @property          integer                 $vCardId
 * @property-read     ExtensionModeration     $vCardModeration
 * @property          string                  $adImageHash
 * @property-read     ExtensionModeration     $adImageModeration
 * @property          integer                 $sitelinkSetId
 * @property-read     ExtensionModeration     $sitelinksModeration
 * @property          AdExtensionSetting      $calloutSetting
 * @property          integer[]               $adExtensionIds
 * @property-read     AdExtensionsAd          $adExtensions
 *                                            
 * @method            $this                   setText(string $text)
 * @method            string                  getText()
 * @method            $this                   setVCardId(integer $vCardId)
 * @method            integer                 getVCardId()
 * @method            ExtensionModeration     getVCardModeration()
 * @method            $this                   setAdImageHash(string $adImageHash)
 * @method            string                  getAdImageHash()
 * @method            ExtensionModeration     getAdImageModeration()
 * @method            $this                   setSitelinkSetId(integer $sitelinkSetId)
 * @method            integer                 getSitelinkSetId()
 * @method            ExtensionModeration     getSitelinksModeration()
 * @method            $this                   setCalloutSetting(AdExtensionSetting|array $calloutSetting)
 * @method            AdExtensionSetting      getCalloutSetting()
 * @method            $this                   setAdExtensionIds(integer[] $adExtensionIds)
 * @method            integer[]               getAdExtensionIds()
 * @method            AdExtensionsAd          getAdExtensions()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextAd extends Model 
{ 
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