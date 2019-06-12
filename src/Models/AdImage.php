<?php 
namespace YandexDirectSDK\Models; 

use Exception;
use YandexDirectSDK\Collections\AdImages;
use YandexDirectSDK\Common\File;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Services\AdImagesService;

/** 
 * Class AdImage 
 * 
 * @property            string         $imageData
 * @property            string         $name
 * 
 * @property-readable   string         $adImageHash
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
     * @param string $name
     * @param string $imageFile
     * @return AdImage
     * @throws ModelException
     */
    public static function image(string $name, string $imageFile)
    {
        return static::make()
            ->setName($name)
            ->setImageFile($imageFile);
    }

    /**
     * @param string $imageFile
     * @return $this
     * @throws ModelException
     */
    public function setImageFile(string $imageFile)
    {
        try {
            $this->modelData['imageData'] = File::bind($imageFile)->base64();
            $this->imageFile = $imageFile;
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