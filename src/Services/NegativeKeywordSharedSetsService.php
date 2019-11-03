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
 * @method static     Result                                                      add(NegativeKeywordSharedSet|NegativeKeywordSharedSets|ModelCommon $negativeKeywordSharedSets)
 * @method static     QueryBuilder                                                query()
 * @method static     NegativeKeywordSharedSet|NegativeKeywordSharedSets|null     find(integer|integer[]|NegativeKeywordSharedSet|NegativeKeywordSharedSets|ModelCommon $ids, string[] $fields)
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
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'update' => 'update:updateCollection',
        'delete' => 'delete:actionByIds'
    ];
}