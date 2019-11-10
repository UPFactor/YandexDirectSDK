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
 * @method static     Result                add(VCard|VCards|ModelCommonInterface $vCards)
 * @method static     QueryBuilder          query()
 * @method static     VCard|VCards|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method static     Result                delete(integer|integer[]|VCard|VCards|ModelCommonInterface $vCards)
 * 
 * @package YandexDirectSDK\Services 
 */
class VCardsService extends Service
{
    protected static $name = 'vcards';

    protected static $modelClass = VCard::class;

    protected static $modelCollectionClass = VCards::class;

    protected static $methods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'delete' => 'delete:actionByIds'
    ];
}