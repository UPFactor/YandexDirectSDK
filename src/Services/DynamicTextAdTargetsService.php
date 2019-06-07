<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\WebpageBids;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\Webpage;
use YandexDirectSDK\Models\WebpageBid;

/** 
 * Class DynamicTextAdTargetsService 
 * 
 * @method   Result         add(Webpage|Webpages|ModelCommonInterface $webpages)
 * @method   QueryBuilder   query()
 * @method   Result         delete(integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages)
 * @method   Result         resume(integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages)
 * @method   Result         suspend(integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages)
 * 
 * @package YandexDirectSDK\Services 
 */
class DynamicTextAdTargetsService extends Service
{
    protected $serviceName = 'dynamictextadtargets';

    protected $serviceModelClass = Webpage::class;

    protected $serviceModelCollectionClass = Webpages::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'delete' => 'delete:actionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds'
    ];

    /**
     * Sets bids for targeting conditions for dynamic ads.
     *
     * @param integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages
     * @param integer $bid
     * @param integer|null $contextBid
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ModelCollectionException
     */
    public function setRelatedBids($webpages, $bid, $contextBid = null):Result
    {
        $webpageIds = $this->extractIds($webpages);
        $webpageBids = new WebpageBids();

        if (func_num_args() > 2){
            foreach ($webpageIds as $id){
                $webpageBids->push(
                    WebpageBid::make()
                        ->setId($id)
                        ->setBid($bid)
                        ->setContextBid($contextBid)
                );
            }
        } else {
            foreach ($webpageIds as $id){
                $webpageBids->push(
                    WebpageBid::make()
                        ->setId($id)
                        ->setBid($bid)
                );
            }
        }

        return $this->setBids($webpageBids);
    }

    /**
     * Sets context bids for targeting conditions for dynamic ads.
     *
     * @param integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages
     * @param integer $contextBid
     * @return Result
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function setRelatedContextBids($webpages, $contextBid):Result
    {
        $webpageIds = $this->extractIds($webpages);
        $webpageBids = new WebpageBids();

        foreach ($webpageIds as $id){
            $webpageBids->push(
                WebpageBid::make()
                    ->setId($id)
                    ->setContextBid($contextBid)
            );
        }

        return $this->setBids($webpageBids);
    }

    /**
     * Sets priorities for targeting conditions for dynamic ads.
     *
     * @param integer|integer[]|Webpage|Webpages|ModelCommonInterface $webpages
     * @param string $strategyPriority
     * @return Result
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function setRelatedStrategyPriority($webpages, string $strategyPriority):Result
    {
        $webpageIds = $this->extractIds($webpages);
        $webpageBids = new WebpageBids();

        foreach ($webpageIds as $id){
            $webpageBids->push(
                WebpageBid::make()
                    ->setId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return $this->setBids($webpageBids);
    }

    /**
     * Sets bids and priorities for targeting conditions for dynamic ads.
     *
     * @param WebpageBid|WebpageBids|ModelCommonInterface $webpageBids
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function setBids(ModelCommonInterface $webpageBids):Result
    {
        return $this->updateCollection('setBids', $webpageBids, 'Bids', 'SetBidsResults');
    }
}