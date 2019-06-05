<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\VCards;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\VCard;

/** 
 * Class VCardsService 
 * 
 * @method   Result         add(VCard|VCards|ModelCommonInterface $vCards)
 * @method   QueryBuilder   query()
 * @method   Result         delete(integer|integer[]|VCard|VCards|ModelCommonInterface $vCards)
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