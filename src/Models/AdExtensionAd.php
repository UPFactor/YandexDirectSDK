<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdExtensionsAd;
use YandexDirectSDK\Components\Model as Model;

/** 
 * Class AdExtensionAd 
 * 
 * @property-read   integer   $adExtensionId 
 * @property-read   string    $type 
 * 
 * @method          integer   getAdExtensionId() 
 * @method          string    getType() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdExtensionAd extends Model 
{
    const ADD = 'ADD';
    const REMOVE = 'REMOVE';
    const SET = 'SET';

    protected $compatibleCollection = AdExtensionsAd::class;

    protected $properties = [
        'adExtensionId' => 'integer',
        'type' => 'string',
        'operation' => 'enum:' . self::ADD . ',' . self::REMOVE . ',' . self::SET
    ];

    protected $nonAddableProperties = [
        'operation'
    ];

    protected $nonWritableProperties = [
        'type'
    ];
}