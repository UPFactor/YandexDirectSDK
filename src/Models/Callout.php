<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class Callout 
 * 
 * @property     string     $calloutText
 *                          
 * @method       $this      setCalloutText(string $calloutText)
 * @method       string     getCalloutText()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Callout extends Model 
{ 
    protected static $properties = [
        'calloutText' => 'string'
    ];

    protected static $nonUpdatableProperties = [
        'calloutText'
    ];
}