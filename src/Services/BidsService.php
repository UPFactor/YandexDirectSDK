<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;

/** 
 * Class BidsService 
 * 
 * @method static     QueryBuilder     query()
 * 
 * @package YandexDirectSDK\Services 
 */
class BidsService extends Service
{
    protected static $name = 'bids';

    protected static $modelClass = Bid::class;

    protected static $modelCollectionClass = Bids::class;

    protected static $methods = [
        'query' => 'get:selectionElements',
    ];

    /**
     * @param Bid|Bids|ModelCommonInterface $bids
     * @return Result
     */
    public static function set(ModelCommonInterface $bids):Result
    {
        return static::updateCollection('set', $bids, 'Bids', 'SetResults');
    }

    /**
     * @param BidAuto|BidsAuto|ModelCommonInterface $bidsAuto
     * @return Result
     */
    public static function setAuto(ModelCommonInterface $bidsAuto):Result
    {
        return static::updateCollection('setAuto', $bidsAuto, 'Bids', 'SetAutoResults');
    }
}