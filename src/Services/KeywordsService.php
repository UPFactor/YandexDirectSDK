<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelCollectionException;
use YandexDirectSDK\Exceptions\ModelException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\Keyword;

/** 
 * Class KeywordsService 
 * 
 * @method   Result                  add(Keyword|Keywords|ModelCommonInterface $keywords)
 * @method   Result                  delete(integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords)
 * @method   QueryBuilder            query()
 * @method   Keyword|Keywords|null   find(integer|integer[]|Keyword|Keywords|ModelCommonInterface $ids, string[] $fields)
 * @method   Result                  resume(integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords)
 * @method   Result                  suspend(integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords)
 * @method   Result                  update(Keyword|Keywords|ModelCommonInterface $keywords)
 * 
 * @package YandexDirectSDK\Services 
 */
class KeywordsService extends Service
{
    protected static $name = 'keywords';

    protected static $modelClass = Keyword::class;

    protected static $modelCollectionClass = Keywords::class;

    protected static $methods = [
        'add' => 'add:addCollection',
        'delete' => 'delete:actionByIds',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds',
        'update' => 'update:updateCollection',
    ];

    /**
     * Sets bids for given keywords.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param integer $bid
     * @param integer|null $contextBid
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelCollectionException
     * @throws ModelException
     */
    public function setRelatedBids($keywords, $bid, $contextBid = null):Result
    {
        $keywordIds = $this->extractIds($keywords);
        $bids = new Bids();

        if (func_num_args() > 2){
            foreach ($keywordIds as $id){
                $bids->push(
                    Bid::make()
                        ->setKeywordId($id)
                        ->setBid($bid)
                        ->setContextBid( $contextBid)
                );
            }
        } else {
            foreach ($keywordIds as $id){
                $bids->push(
                    Bid::make()
                        ->setKeywordId($id)
                        ->setBid($bid)
                );
            }
        }

        return $this->session->getBidsService()->set($bids);
    }

    /**
     * Sets context bids for given keywords.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param integer $contextBid
     * @return Result
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function setRelatedContextBids($keywords, $contextBid):Result
    {
        $keywordIds = $this->extractIds($keywords);
        $bids = new Bids();

        foreach ($keywordIds as $id){
            $bids->push(
                Bid::make()
                    ->setKeywordId($id)
                    ->setContextBid($contextBid)
            );
        }

        return $this->session->getBidsService()->set($bids);
    }

    /**
     * Sets strategy priority for given keywords.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param string $strategyPriority
     * @return Result
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function setRelatedStrategyPriority($keywords, string $strategyPriority):Result
    {
        $keywordIds = $this->extractIds($keywords);
        $bids = new Bids();

        foreach ($keywordIds as $id){
            $bids->push(
                Bid::make()
                    ->setKeywordId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return $this->session->getBidsService()->set($bids);
    }

    /**
     * Sets bid designer options for given keywords.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param BidAuto|BidsAuto|ModelCommonInterface $bidsAuto
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ModelException
     */
    public function setRelatedBidsAuto($keywords, ModelCommonInterface $bidsAuto): Result
    {
        return $this->session->getBidsService()->setAuto(
            $this->bind($keywords, $bidsAuto, 'KeywordId')
        );
    }

    /**
     * Gets bids for given keywords.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function getRelatedBids($keywords, array $fields): Result
    {
        return $this->session->getBidsService()->query()
            ->select($fields)
            ->whereIn('KeywordIds', $this->extractIds($keywords))
            ->get();
    }
}