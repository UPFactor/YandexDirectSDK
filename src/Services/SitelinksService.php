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
 * @method static     Result                              create(SitelinksSet|SitelinksSets|ModelCommonInterface $sitelinksSets)
 * @method static     Result                              delete(integer|integer[]|SitelinksSet|SitelinksSets|ModelCommonInterface $sitelinksSets)
 * @method static     SitelinksSet|SitelinksSets|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * 
 * @package YandexDirectSDK\Services 
 */
class SitelinksService extends Service
{
    protected static $name = 'sitelinks';

    protected static $modelClass = SitelinksSet::class;

    protected static $modelCollectionClass = SitelinksSets::class;

    protected static $methods = [
        'create' => 'add:addCollection',
        'delete' => 'delete:actionById',
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