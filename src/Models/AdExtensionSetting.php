<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdExtensionsAd;
use YandexDirectSDK\Components\Model;

/** 
 * Class AdExtensionSetting 
 * 
 * @property       AdExtensionsAd   $adExtensions
 * 
 * @method         $this            setAdExtensions(AdExtensionsAd $adExtensions)
 * 
 * @method         AdExtensionsAd   getAdExtensions()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdExtensionSetting extends Model 
{ 
    protected static $serviceMethods = [];

    protected static $properties = [
        'adExtensions' => 'object:' . AdExtensionsAd::class
    ];

    protected static $nonAddableProperties = [
        'adExtensions'
    ];
}