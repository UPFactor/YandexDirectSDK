<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\SitelinksSets;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\SitelinksSet;

/** 
 * Class SitelinksService 
 * 
 * @method   Result         add(ModelCommon $sitelinksSets) 
 * @method   Result         delete(ModelCommon|integer[]|integer $sitelinksSets)
 * 
 * @package YandexDirectSDK\Services 
 */
class SitelinksService extends Service
{
    protected $serviceName = 'sitelinks';

    protected $serviceModelClass = SitelinksSet::class;

    protected $serviceModelCollectionClass = SitelinksSets::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'delete' => 'delete:actionByIds'
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