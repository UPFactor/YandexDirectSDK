<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\Keyword;

/** 
 * Class KeywordsService 
 * 
 * @method static     Result                    add(Keyword|Keywords|ModelCommonInterface $keywords)
 * @method static     Result                    delete(integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords)
 * @method static     QueryBuilder              query()
 * @method static     Keyword|Keywords|null     find(integer|integer[]|string|string[] $ids, string[] $fields)
 * @method static     Result                    resume(integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords)
 * @method static     Result                    suspend(integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords)
 * @method static     Result                    update(Keyword|Keywords|ModelCommonInterface $keywords)
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
     */
    public static function setRelatedBids($keywords, $bid, $contextBid = null):Result
    {
        $keywordIds = static::extractIds($keywords);
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

        return BidsService::set($bids);
    }

    /**
     * Sets context bids for given keywords.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param integer $contextBid
     * @return Result
     */
    public static function setRelatedContextBids($keywords, $contextBid):Result
    {
        $keywordIds = static::extractIds($keywords);
        $bids = new Bids();

        foreach ($keywordIds as $id){
            $bids->push(
                Bid::make()
                    ->setKeywordId($id)
                    ->setContextBid($contextBid)
            );
        }

        return BidsService::set($bids);
    }

    /**
     * Sets strategy priority for given keywords.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param string $strategyPriority
     * @return Result
     */
    public static function setRelatedStrategyPriority($keywords, string $strategyPriority):Result
    {
        $keywordIds = static::extractIds($keywords);
        $bids = new Bids();

        foreach ($keywordIds as $id){
            $bids->push(
                Bid::make()
                    ->setKeywordId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return BidsService::set($bids);
    }

    /**
     * Sets bid designer options for given keywords.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param BidAuto|BidsAuto|ModelCommonInterface $bidsAuto
     * @return Result
     */
    public static function setRelatedBidsAuto($keywords, ModelCommonInterface $bidsAuto): Result
    {
        return BidsService::setAuto(static::bind($keywords, $bidsAuto, 'KeywordId'));
    }

    /**
     * Gets bids for given keywords.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param array $fields
     * @return Result
     */
    public static function getRelatedBids($keywords, array $fields): Result
    {
        return BidsService::query()
            ->select($fields)
            ->whereIn('KeywordIds', static::extractIds($keywords))
            ->get();
    }
}