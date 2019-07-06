<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class Statistics 
 * 
 * @property-read   integer   $impressions
 * @property-read   integer   $clicks
 * 
 * @method          integer   getImpressions()
 * @method          integer   getClicks()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Statistics extends Model 
{ 
    protected static $properties = [
        'impressions' => 'integer',
        'clicks' => 'integer'
    ];

    protected static $nonWritableProperties = [
        'impressions',
        'clicks'
    ];
}