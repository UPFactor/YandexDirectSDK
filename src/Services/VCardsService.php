<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\VCards;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\VCard;

/** 
 * Class VCardsService 
 * 
 * @method   Result         add(ModelCommon $vCards) 
 * @method   QueryBuilder   query() 
 * @method   Result         delete(ModelCommon|integer[]|integer $vCards) 
 * 
 * @package YandexDirectSDK\Services 
 */
class VCardsService extends Service
{
    protected $serviceName = 'vcards';

    protected $serviceModelClass = VCard::class;

    protected $serviceModelCollectionClass = VCards::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'delete' => 'delete:actionByIds'
    ];
}