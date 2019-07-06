<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class AdBuilderAd 
 * 
 * @property        integer   $creativeId
 * 
 * @property-read   string    $thumbnailUrl
 * @property-read   string    $previewUrl
 * 
 * @method          $this     setCreativeId(integer $creativeId)
 * 
 * @method          integer   getCreativeId()
 * @method          string    getThumbnailUrl()
 * @method          string    getPreviewUrl()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdBuilderAd extends Model 
{ 
    protected static $properties = [
        'creativeId' => 'integer',
        'thumbnailUrl' => 'string',
        'previewUrl' => 'string'
    ];

    protected static $nonWritableProperties = [
        'thumbnailUrl',
        'previewUrl'
    ];
}