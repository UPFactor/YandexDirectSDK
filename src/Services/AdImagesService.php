<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AdImages;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\AdImage;

/** 
 * Class AdImagesService 
 * 
 * @method   Result         add(AdImage|AdImages|ModelCommonInterface $adImages)
 * @method   QueryBuilder   query()
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
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
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