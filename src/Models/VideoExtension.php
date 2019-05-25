<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class VideoExtension 
 * 
 * @property            integer   $creativeId 
 * @property-readable   string    $status 
 * @property-readable   string    $thumbnailUrl 
 * @property-readable   string    $previewUrl 
 * 
 * @method              $this     setCreativeId(integer $creativeId) 
 * 
 * @method              integer   getCreativeId() 
 * @method              string    getStatus() 
 * @method              string    getThumbnailUrl() 
 * @method              string    getPreviewUrl() 
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