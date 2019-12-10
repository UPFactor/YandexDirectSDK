<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\KeywordBids;
use YandexDirectSDK\Collections\KeywordBidsAuto;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\KeywordBid;
use YandexDirectSDK\Models\KeywordBidAuto;

/** 
 * Class KeywordBidsService 
 * 
 * @method static     QueryBuilder     query()
 * 
 * @package YandexDirectSDK\Services 
 */
class KeywordBidsService extends Service
{
    protected static $name = 'keywordbids';

    protected static $modelClass = KeywordBid::class;

    protected static $modelCollectionClass = KeywordBids::class;

    protected static $methods = [
        'query' => 'get:createQueryBuilder',
    ];

    /**
     * @param KeywordBid|KeywordBids|ModelCommonInterface $keywordBids
     * @return Result
     */
    public static function set(ModelCommonInterface $keywordBids):Result
    {
        return static::updateCollection('set', $keywordBids, 'KeywordBids', 'SetResults');
    }

    /**
     * @param KeywordBidAuto|KeywordBidsAuto|ModelCommonInterface $keywordBidsAuto
     * @return Result
     */
    public static function setAuto(ModelCommonInterface $keywordBidsAuto):Result
    {
        return static::updateCollection('setAuto', $keywordBidsAuto, 'KeywordBids', 'SetAutoResults');
    }
}