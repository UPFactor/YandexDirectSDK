<?php 
namespace YandexDirectSDK\Services; 

use YandexDirectSDK\Collections\TurboPages;
use YandexDirectSDK\Components\Service; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\TurboPage;

/** 
 * Class TurboPagesService 
 * 
 * @method static     TurboPage|TurboPages|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * 
 * @package YandexDirectSDK\Services 
 */ 
class TurboPagesService extends Service 
{ 
    protected static $name = 'turbopages';

    protected static $modelClass = TurboPage::class;

    protected static $modelCollectionClass = TurboPages::class;

    protected static $methods = [
        'find' => 'get:selectById'
    ];

    /**
     * @return QueryBuilder
     */
    public static function query() : QueryBuilder
    {
        return static::createQueryBuilder('get', function($query){
            if (empty($query['SelectionCriteria'])){
                unset($query['SelectionCriteria']);
            }
            return $query;
        });
    }
}