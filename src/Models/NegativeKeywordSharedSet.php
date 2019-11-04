<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\NegativeKeywordSharedSets;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\NegativeKeywordSharedSetsService;

/** 
 * Class NegativeKeywordSharedSet 
 * 
 * @property          integer                                                     $id
 * @property          string                                                      $name
 * @property          array                                                       $negativeKeywords
 * @property-read     string                                                      $associated
 *                                                                                
 * @method static     NegativeKeywordSharedSet|NegativeKeywordSharedSets|null     find(integer|integer[]|string|string[] $ids, string[] $fields)
 * @method            Result                                                      add()
 * @method            QueryBuilder                                                query()
 * @method            Result                                                      update()
 * @method            Result                                                      delete()
 * @method            $this                                                       setId(integer $id)
 * @method            integer                                                     getId()
 * @method            $this                                                       setName(string $name)
 * @method            string                                                      getName()
 * @method            $this                                                       setNegativeKeywords(array $negativeKeywords)
 * @method            array                                                       getNegativeKeywords()
 * @method            string                                                      getAssociated()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class NegativeKeywordSharedSet extends Model 
{ 
    protected static $compatibleCollection = NegativeKeywordSharedSets::class;

    protected static $methods = [
        'add' => NegativeKeywordSharedSetsService::class,
        'query' => NegativeKeywordSharedSetsService::class,
        'update' => NegativeKeywordSharedSetsService::class,
        'delete' => NegativeKeywordSharedSetsService::class
    ];

    protected static $staticMethods = [
        'find' => NegativeKeywordSharedSetsService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'name' => 'string',
        'negativeKeywords' => 'stack',
        'associated' => 'string'
    ];

    protected static $nonWritableProperties = [
        'associated'
    ];

    protected static $nonReadableProperties = []; 

    protected static $nonUpdatableProperties = []; 

    protected static $nonAddableProperties = [
        'id'
    ];
}