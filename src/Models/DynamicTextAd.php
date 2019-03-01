<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdExtensionsAd;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class DynamicTextAd 
 * 
 * @property        string                $text 
 * @property        integer               $vCardId 
 * @property        string                $adImageHash 
 * @property        integer               $sitelinkSetId 
 * @property        integer[]             $adExtensionIds 
 * @property-read   ExtensionModeration   $vCardModeration 
 * @property-read   ExtensionModeration   $sitelinksModeration 
 * @property-read   ExtensionModeration   $adImageModeration 
 * @property-read   AdExtensionsAd        $adExtensions 
 * 
 * @method          $this                 setText(string $text) 
 * @method          $this                 setVCardId(integer $vCardId) 
 * @method          $this                 setAdImageHash(string $adImageHash) 
 * @method          $this                 setSitelinkSetId(integer $sitelinkSetId) 
 * @method          $this                 setAdExtensionIds(integer[] $adExtensionIds) 
 * 
 * @method          string                getText() 
 * @method          integer               getVCardId() 
 * @method          string                getAdImageHash() 
 * @method          integer               getSitelinkSetId() 
 * @method          integer[]             getAdExtensionIds() 
 * @method          ExtensionModeration   getVCardModeration() 
 * @method          ExtensionModeration   getSitelinksModeration() 
 * @method          ExtensionModeration   getAdImageModeration() 
 * @method          AdExtensionsAd        getAdExtensions() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextAd extends Model 
{ 
    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'text' => 'string',
        'vCardId' => 'integer',
        'adImageHash' => 'string',
        'sitelinkSetId' => 'integer',
        'adExtensionIds' => 'stack:integer',
        'vCardModeration' => 'object:' . ExtensionModeration::class,
        'sitelinksModeration' => 'object:' . ExtensionModeration::class,
        'adImageModeration' => 'object:' . ExtensionModeration::class,
        'adExtensions' => 'object:' . AdExtensionsAd::class
    ];

    protected $nonWritableProperties = [
        'vCardModeration',
        'sitelinksModeration',
        'adImageModeration',
        'adExtensions'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'text'
    ];
}