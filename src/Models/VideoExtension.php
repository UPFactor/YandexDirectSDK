<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class VideoExtension 
 * 
 * @property        integer   $creativeId
 * 
 * @property-read   string    $status
 * @property-read   string    $thumbnailUrl
 * @property-read   string    $previewUrl
 * 
 * @method          $this     setCreativeId(integer $creativeId)
 * 
 * @method          integer   getCreativeId()
 * @method          string    getStatus()
 * @method          string    getThumbnailUrl()
 * @method          string    getPreviewUrl()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class VideoExtension extends Model 
{
    protected static $properties = [
        'creativeId' => 'integer',
        'status' => 'string',
        'thumbnailUrl' => 'string',
        'previewUrl' => 'string'
    ];

    protected static $nonWritableProperties = [
        'status',
        'thumbnailUrl',
        'previewUrl'
    ];
}