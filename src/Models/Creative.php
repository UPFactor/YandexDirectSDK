<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Creatives;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Services\CreativesService;

/** 
 * Class Creative 
 * 
 * @property-read     integer                     $id
 * @property-read     string                      $type
 * @property-read     string                      $name
 * @property-read     string                      $previewUrl
 * @property-read     integer                     $width
 * @property-read     integer                     $height
 * @property-read     string                      $thumbnailUrl
 * @property-read     string                      $associated
 * @property-read     VideoExtensionCreative      $videoExtensionCreative
 * @property-read     CpcVideoCreative            $cpcVideoCreative
 * @property-read     CpmVideoCreative            $cpmVideoCreative
 *                                                
 * @method static     QueryBuilder                query()
 * @method static     Creative|Creatives|null     find(integer|integer[]|Creative|Creatives|ModelCommonInterface $ids, string[] $fields)
 * @method            integer                     getId()
 * @method            string                      getType()
 * @method            string                      getName()
 * @method            string                      getPreviewUrl()
 * @method            integer                     getWidth()
 * @method            integer                     getHeight()
 * @method            string                      getThumbnailUrl()
 * @method            string                      getAssociated()
 * @method            VideoExtensionCreative      getVideoExtensionCreative()
 * @method            CpcVideoCreative            getCpcVideoCreative()
 * @method            CpmVideoCreative            getCpmVideoCreative()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Creative extends Model 
{ 
    protected static $compatibleCollection = Creatives::class;

    protected static $staticMethods = [
        'query' => CreativesService::class,
        'find' => CreativesService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'type' => 'string',
        'name' => 'string',
        'previewUrl' => 'string',
        'width' => 'integer',
        'height' => 'integer',
        'thumbnailUrl' => 'string',
        'associated' => 'string',
        'videoExtensionCreative' => 'object:' . VideoExtensionCreative::class,
        'cpcVideoCreative' => 'object:' . CpcVideoCreative::class,
        'cpmVideoCreative' => 'object:' . CpmVideoCreative::class
    ];

    protected static $nonWritableProperties = [
        'id',
        'type',
        'name',
        'previewUrl',
        'width',
        'height',
        'thumbnailUrl',
        'associated',
        'videoExtensionCreative',
        'cpcVideoCreative',
        'cpmVideoCreative'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}