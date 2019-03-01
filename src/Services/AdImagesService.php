<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Components\Service;

/** 
 * Class AdImagesService 
 * 
 * @package YandexDirectSDK\Services 
 */
class AdImagesService extends Service
{
    protected $serviceName = 'adimages';

    protected $serviceModelClass;

    protected $serviceModelCollectionClass;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        //todo: 'delete' => 'delete:actionByIds' actionByProperty
    ];
}