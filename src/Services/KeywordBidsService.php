<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\KeywordBids;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\KeywordBid;

/** 
 * Class KeywordBidsService 
 * 
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
        'query' => 'get:selectionElements',
    ];

    /**
     * @param ModelCommon $keywordBids
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function set(ModelCommon $keywordBids):Result
    {
        return $this->updateCollection('set', $keywordBids, 'KeywordBids', 'SetResults');
    }

    /**
     * @param ModelCommon $keywordBidsAuto
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function setAuto(ModelCommon $keywordBidsAuto):Result
    {
        return $this->updateCollection('setAuto', $keywordBidsAuto, 'KeywordBids', 'SetAutoResults');
    }
}