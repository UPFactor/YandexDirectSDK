<?php 
namespace YandexDirectSDK\Services; 

use YandexDirectSDK\Collections\NegativeKeywordSharedSets;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\NegativeKeywordSharedSet;

/** 
 * Class NegativeKeywordSharedSetsService 
 * 
 * @method static     Result                                                      create(NegativeKeywordSharedSet|NegativeKeywordSharedSets|ModelCommon $negativeKeywordSharedSets)
 * @method static     QueryBuilder                                                query()
 * @method static     NegativeKeywordSharedSet|NegativeKeywordSharedSets|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method static     Result                                                      update(NegativeKeywordSharedSet|NegativeKeywordSharedSets|ModelCommon $negativeKeywordSharedSets)
 * @method static     Result                                                      delete(integer|integer[]|NegativeKeywordSharedSet|NegativeKeywordSharedSets|ModelCommon $negativeKeywordSharedSets)
 * 
 * @package YandexDirectSDK\Services 
 */ 
class NegativeKeywordSharedSetsService extends Service
{ 
    protected static $name = 'negativekeywordsharedsets';

    protected static $modelClass = NegativeKeywordSharedSet::class;

    protected static $modelCollectionClass = NegativeKeywordSharedSets::class;

    protected static $methods = [
        'create' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'update' => 'update:updateCollection',
        'delete' => 'delete:actionByIds'
    ];
}