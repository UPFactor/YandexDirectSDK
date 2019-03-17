<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class Callout 
 * 
 * @property   string   $calloutText 
 * 
 * @method     $this    setCalloutText(string $calloutText) 
 * 
 * @method     string   getCalloutText() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Callout extends Model 
{ 
    protected $properties = [
        'calloutText' => 'string'
    ];

    protected $nonUpdatableProperties = [
        'calloutText'
    ];
}