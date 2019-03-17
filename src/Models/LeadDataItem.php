<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\LeadData;
use YandexDirectSDK\Components\Model;

/** 
 * Class LeadDataItem 
 * 
 * @property-read   string   $name 
 * @property-read   string   $value 
 * 
 * @method          string   getName() 
 * @method          string   getValue() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class LeadDataItem extends Model 
{ 
    protected $compatibleCollection = LeadData::class;

    protected $properties = [
        'name' => 'string',
        'value' => 'string'
    ];

    protected $nonWritableProperties = [
        'name',
        'value'
    ];
}