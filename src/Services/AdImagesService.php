<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AdImages;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\AdImage;

/** 
 * Class AdImagesService 
 * 
 * @method static     Result           add(AdImage|AdImages|ModelCommonInterface $adImages)
 * @method static     QueryBuilder     query()
 * 
 * @package YandexDirectSDK\Services 
 */
class AdImagesService extends Service
{
    protected static $name = 'adimages';

    protected static $modelClass = AdImage::class;

    protected static $modelCollectionClass = AdImages::class;

    protected static $methods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
    ];

    /**
     * @param ModelCommonInterface|string[]|string $adImages
     * @return Result
     */
    public static function delete($adImages):Result
    {
        return static::actionByProperty(
            'delete',
            $adImages,
            'adImageHash',
            'AdImageHashes'
        );
    }
}