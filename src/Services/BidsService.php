<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\Bid;

/** 
 * Class BidsService 
 * 
 * @method   QueryBuilder   query() 
 * 
 * @package YandexDirectSDK\Services 
 */
class BidsService extends Service
{
    protected $serviceName = 'bids';

    protected $serviceModelClass = Bid::class;

    protected $serviceModelCollectionClass = Bids::class;

    protected $serviceMethods = [
        'query' => 'get:selectionElements',
    ];

    /**
     * @param ModelCommon $bids
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function set(ModelCommon $bids):Result
    {
        return $this->updateCollection('set', $bids, 'Bids', 'SetResults');
    }

    /**
     * @param ModelCommon $bidsAuto
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function setAuto(ModelCommon $bidsAuto):Result
    {
        return $this->updateCollection('setAuto', $bidsAuto, 'Bids', 'SetAutoResults');
    }
}