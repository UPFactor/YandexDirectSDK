<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\ClientRestrictions;
use YandexDirectSDK\Components\Model;

/** 
 * Class ClientRestriction 
 * 
 * @property-read     string      $element
 * @property-read     integer     $value
 *                                
 * @method            string      getElement()
 * @method            integer     getValue()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class ClientRestriction extends Model 
{ 
    protected static $compatibleCollection = ClientRestrictions::class;

    protected static $properties = [
        'element' => 'string',
        'value' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'element',
        'value'
    ];
}