<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model; 
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\AdImagesService;

/** 
 * Class AdImage 
 * 
 * @property        string         $imageData 
 * @property        string         $name 
 * @property-read   string         $adImageHash 
 * @property-read   string         $associated 
 * @property-read   string         $type 
 * @property-read   string         $subtype 
 * @property-read   string         $originalUrl 
 * @property-read   string         $previewUrl 
 * 
 * @method          $this          setImageData(string $imageData) 
 * @method          $this          setName(string $name) 
 * 
 * @method          string         getImageData() 
 * @method          string         getName() 
 * @method          string         getAdImageHash() 
 * @method          string         getAssociated() 
 * @method          string         getType() 
 * @method          string         getSubtype() 
 * @method          string         getOriginalUrl() 
 * @method          string         getPreviewUrl() 
 * 
 * @method          QueryBuilder   query() 
 * @method          Result         add() 
 * @method          Result         delete() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdImage extends Model 
{ 
    protected $compatibleCollection;

    protected $serviceProvidersMethods = [
        'query' => AdImagesService::class,
        'add' => AdImagesService::class,
        'delete' => AdImagesService::class
    ];

    protected $properties = [
        'imageData' => 'string',
        'name' => 'string',
        'adImageHash' => 'string',
        'associated' => 'string',
        'type' => 'string',
        'subtype' => 'string',
        'originalUrl' => 'string',
        'previewUrl' => 'string'
    ];

    protected $nonWritableProperties = [
        'adImageHash',
        'associated',
        'type',
        'subtype',
        'originalUrl',
        'previewUrl'
    ];

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'imageData',
        'name'
    ];
}