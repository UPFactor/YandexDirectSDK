<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\KeywordBids;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\KeywordBid;

/** 
 * Class KeywordBidsService 
 * 
 * @method   Result         set(ModelCommon $keywordBids) 
 * @method   QueryBuilder   query() 
 * 
 * @package YandexDirectSDK\Services 
 */
class KeywordBidsService extends Service
{
    protected $serviceName = 'keywordbids';

    protected $serviceModelClass = KeywordBid::class;

    protected $serviceModelCollectionClass = KeywordBids::class;

    protected $serviceMethods = [
        'set' => 'set:updateCollection',
        'query' => 'get:selectionElements',
    ];

    /**
     * @param ModelCommon $keywordBidsAuto
     * @return Result
     */
    public function setAuto(ModelCommon $keywordBidsAuto):Result
    {
        return $this->updateCollection('setAuto', $keywordBidsAuto);
    }
}