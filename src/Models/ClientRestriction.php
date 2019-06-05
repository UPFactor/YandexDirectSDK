<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\ClientRestrictions;
use YandexDirectSDK\Components\Model;

/** 
 * Class ClientRestriction 
 * 
 * @property-readable   string   $element
 * @property-readable   string   $value
 * 
 * @method              string   getElement()
 * @method              string   getValue()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class ClientRestriction extends Model 
{ 
    protected $compatibleCollection = ClientRestrictions::class;

    protected $properties = [
        'element' => 'string',
        'value' => 'string'
    ];

    protected $nonWritableProperties = [
        'element',
        'value'
    ];
}