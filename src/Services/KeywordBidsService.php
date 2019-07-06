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
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
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
    protected static $name = 'keywordbids';

    protected static $modelClass = KeywordBid::class;

    protected static $modelCollectionClass = KeywordBids::class;

    protected static $methods = [
        'query' => 'get:selectionElements',
    ];

    /**
     * @param ModelCommonInterface $keywordBids
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function set(ModelCommonInterface $keywordBids):Result
    {
        return $this->updateCollection('set', $keywordBids, 'KeywordBids', 'SetResults');
    }

    /**
     * @param ModelCommonInterface $keywordBidsAuto
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function setAuto(ModelCommonInterface $keywordBidsAuto):Result
    {
        return $this->updateCollection('setAuto', $keywordBidsAuto, 'KeywordBids', 'SetAutoResults');
    }
}