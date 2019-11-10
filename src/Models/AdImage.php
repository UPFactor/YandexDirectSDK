<?php 
namespace YandexDirectSDK\Models; 

use Exception;
use YandexDirectSDK\Collections\AdImages;
use UPTools\File;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Services\AdImagesService;

/** 
 * Class AdImage 
 * 
 * @property-read     string           $adImageHash
 * @property          string           $imageData
 * @property          string           $name
 * @property-read     string           $associated
 * @property-read     string           $type
 * @property-read     string           $subtype
 * @property-read     string           $originalUrl
 * @property-read     string           $previewUrl
 *                                     
 * @method static     QueryBuilder     query()
 * @method            Result           add()
 * @method            Result           delete()
 * @method            string           getAdImageHash()
 * @method            $this            setImageData(string $imageData)
 * @method            string           getImageData()
 * @method            $this            setName(string $name)
 * @method            string           getName()
 * @method            string           getAssociated()
 * @method            string           getType()
 * @method            string           getSubtype()
 * @method            string           getOriginalUrl()
 * @method            string           getPreviewUrl()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class AdImage extends Model 
{ 
    protected static $compatibleCollection = AdImages::class;

    protected static $staticMethods = [
        'query' => AdImagesService::class
    ];

    protected static $methods = [
        'add' => AdImagesService::class,
        'delete' => AdImagesService::class
    ];

    protected static $properties = [
        'adImageHash' => 'string',
        'imageData' => 'string',
        'name' => 'string',
        'associated' => 'string',
        'type' => 'string',
        'subtype' => 'string',
        'originalUrl' => 'string',
        'previewUrl' => 'string'
    ];

    protected static $nonUpdatableProperties = [
        'imageData',
        'name'
    ];

    protected static $nonWritableProperties = [
        'adImageHash',
        'associated',
        'type',
        'subtype',
        'originalUrl',
        'previewUrl'
    ];

    /**
     * @var string|null
     */
    public $imageFile;

    /**
     * @param string $filePath
     * @return $this
     */
    public function setImageFile(string $filePath)
    {
        try {
            $this->data['imageData'] = File::bind($filePath)->base64();
            $this->imageFile = $filePath;
        } catch (Exception $error){
            throw ModelException::make($error->getMessage(), $error->getCode());
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }
}