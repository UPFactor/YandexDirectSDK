<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\AdImages;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\AdImagesService;

/** 
 * Class AdImage 
 * 
 * @property            string         $adImageHash
 * @property            string         $imageData
 * @property            string         $name
 * 
 * @property-readable   string         $associated
 * @property-readable   string         $type
 * @property-readable   string         $subtype
 * @property-readable   string         $originalUrl
 * @property-readable   string         $previewUrl
 * 
 * @method              QueryBuilder   query()
 * @method              Result         add()
 * @method              Result         delete()
 * 
 * @method              $this          setAdImageHash(string $adImageHash)
 * @method              $this          setImageData(string $imageData)
 * @method              $this          setName(string $name)
 * 
 * @method              string         getAdImageHash()
 * @method              string         getImageData()
 * @method              string         getName()
 * @method              string         getAssociated()
 * @method              string         getType()
 * @method              string         getSubtype()
 * @method              string         getOriginalUrl()
 * @method              string         getPreviewUrl()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdImage extends Model 
{ 
    protected $compatibleCollection = AdImages::class;

    protected $serviceProvidersMethods = [
        'query' => AdImagesService::class,
        'add' => AdImagesService::class,
        'delete' => AdImagesService::class
    ];

    protected $properties = [
        'adImageHash' => 'string',
        'imageData' => 'string',
        'name' => 'string',
        'associated' => 'string',
        'type' => 'string',
        'subtype' => 'string',
        'originalUrl' => 'string',
        'previewUrl' => 'string'
    ];

    protected $nonUpdatableProperties = [
        'imageData',
        'name'
    ];

    protected $nonWritableProperties = [
        'associated',
        'type',
        'subtype',
        'originalUrl',
        'previewUrl'
    ];

}