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
    protected $serviceName = 'turbopages';

    protected $serviceModelClass = TurboPage::class;

    protected $serviceModelCollectionClass = TurboPages::class;

    protected $serviceMethods = [
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