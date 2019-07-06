<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\LeadData;
use YandexDirectSDK\Components\Model;

/** 
 * Class LeadDataItem 
 * 
 * @property-readable   string   $name
 * @property-readable   string   $value
 * 
 * @method              string   getName()
 * @method              string   getValue()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class LeadDataItem extends Model 
{ 
    protected static $compatibleCollection = LeadData::class;

    protected static $properties = [
        'name' => 'string',
        'value' => 'string'
    ];

    protected static $nonWritableProperties = [
        'name',
        'value'
    ];
}