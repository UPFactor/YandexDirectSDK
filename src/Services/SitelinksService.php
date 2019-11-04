<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\SitelinksSets;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\SitelinksSet;

/** 
 * Class SitelinksService 
 * 
 * @method static     Result                              add(SitelinksSet|SitelinksSets|ModelCommonInterface $sitelinksSets)
 * @method static     Result                              delete(integer|integer[]|SitelinksSet|SitelinksSets|ModelCommonInterface $sitelinksSets)
 * @method static     SitelinksSet|SitelinksSets|null     find(integer|integer[]|string|string[] $ids, string[] $fields)
 * 
 * @package YandexDirectSDK\Services 
 */
class SitelinksService extends Service
{
    protected static $name = 'sitelinks';

    protected static $modelClass = SitelinksSet::class;

    protected static $modelCollectionClass = SitelinksSets::class;

    protected static $methods = [
        'add' => 'add:addCollection',
        'delete' => 'delete:actionByIds',
        'find' => 'get:selectionByIds'
    ];

    /**
     * @return QueryBuilder
     */
    public function query() : QueryBuilder
    {
        return static::selectionElements('get', function($query){
            if (empty($query['SelectionCriteria'])){
                unset($query['SelectionCriteria']);
            }
            return $query;
        });
    }
}