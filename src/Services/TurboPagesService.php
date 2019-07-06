<?php 
namespace YandexDirectSDK\Services; 

use YandexDirectSDK\Collections\TurboPages;
use YandexDirectSDK\Components\Service; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\TurboPage;

/** 
 * Class TurboPagesService 
 * 
 * @method   TurboPage|TurboPages|null   find(integer|integer[]|TurboPage|TurboPages|ModelCommonInterface $ids, string[] $fields)
 * 
 * @package YandexDirectSDK\Services 
 */ 
class TurboPagesService extends Service 
{ 
    protected static $name = 'turbopages';

    protected static $modelClass = TurboPage::class;

    protected static $modelCollectionClass = TurboPages::class;

    protected static $methods = [
        'find' => 'get:selectionByIds'
    ];

    /**
     * @return QueryBuilder
     */
    public function query() : QueryBuilder
    {
        return $this->selectionElements('get', function($query){
            if (empty($query['SelectionCriteria'])){
                unset($query['SelectionCriteria']);
            }
            return $query;
        });
    }
}