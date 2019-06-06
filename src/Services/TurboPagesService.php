<?php 
namespace YandexDirectSDK\Services; 

use YandexDirectSDK\Collections\TurboPages;
use YandexDirectSDK\Components\Service; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\TurboPage;

/** 
 * Class TurboPagesService 
 * 
 * @package YandexDirectSDK\Services 
 */ 
class TurboPagesService extends Service 
{ 
    protected $serviceName = 'turbopages';

    protected $serviceModelClass = TurboPage::class;

    protected $serviceModelCollectionClass = TurboPages::class;

    protected $serviceMethods = [];

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