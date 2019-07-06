<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class DynamicTextFeedAdGroup 
 * 
 * @property-readable   string   $source
 * @property-readable   string   $sourceType
 * @property-readable   string   $sourceProcessingStatus
 * 
 * @method              string   getSource()
 * @method              string   getSourceType()
 * @method              string   getSourceProcessingStatus()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DynamicTextFeedAdGroup extends Model 
{ 
    protected static $properties = [
        'source' => 'string',
        'sourceType' => 'string',
        'sourceProcessingStatus' => 'string'
    ];

    protected static $nonWritableProperties = [
        'source',
        'sourceType',
        'sourceProcessingStatus'
    ];
}