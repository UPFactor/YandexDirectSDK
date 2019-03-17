<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class VideoExtension 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class VideoExtension extends Model 
{
    protected $properties = [
        'creativeId' => 'integer',
        'status' => 'string',
        'thumbnailUrl' => 'string',
        'previewUrl' => 'string'
    ];

    protected $nonWritableProperties = [
        'status',
        'thumbnailUrl',
        'previewUrl'
    ];
}