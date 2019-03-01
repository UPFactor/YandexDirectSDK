<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AdImages;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\AdImage;

/** 
 * Class AdImagesService 
 * 
 * @method   Result         add(ModelCommon $adImages) 
 * @method   QueryBuilder   query() 
 * 
 * @package YandexDirectSDK\Services 
 */
class AdImagesService extends Service
{
    protected $serviceName = 'adimages';

    protected $serviceModelClass = AdImage::class;

    protected $serviceModelCollectionClass = AdImages::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
    ];

    /**
     * @param ModelCommon|string[]|string $adImages
     * @return Result
     */
    public function delete($adImages):Result
    {
        return $this->actionByProperty(
            'delete',
            $adImages,
            'adImageHash',
            'AdImageHashes'
        );
    }
}