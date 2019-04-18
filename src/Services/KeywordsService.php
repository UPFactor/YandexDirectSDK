<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\KeywordBids;
use YandexDirectSDK\Collections\KeywordBidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\KeywordBid;
use YandexDirectSDK\Models\KeywordBidAuto;

/** 
 * Class KeywordsService 
 * 
 * @method   Result         add(ModelCommonInterface $keywords)
 * @method   Result         delete(ModelCommonInterface|integer[]|integer $keywords)
 * @method   QueryBuilder   query() 
 * @method   Result         resume(ModelCommonInterface|integer[]|integer $keywords)
 * @method   Result         suspend(ModelCommonInterface|integer[]|integer $keywords)
 * @method   Result         update(ModelCommonInterface $keywords)
 * 
 * @package YandexDirectSDK\Services 
 */
class KeywordsService extends Service
{
    protected $serviceName = 'keywords';

    protected $serviceModelClass = Keyword::class;

    protected $serviceModelCollectionClass = Keywords::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'delete' => 'delete:actionByIds',
        'query' => 'get:selectionElements',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds',
        'update' => 'update:updateCollection',
    ];

    /**
     * Sets fixed bids and priorities for keyword and auto-targeting.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param Bid|Bids|ModelCommonInterface $bids
     * @return Result
     * @throws ServiceException
     */
    public function setRelatedBids($keywords, ModelCommonInterface $bids): Result
    {
        return $this->session->getBidsService()->set(
            $this->bind($keywords, $bids, 'KeywordId')
        );
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
     */
    public function getRelatedBids($keywords, array $fields): Result
    {
        return $this->session->getBidsService()->query()
            ->select($fields)
            ->whereIn('KeywordIds', $this->extractIds($keywords))
            ->get();
    }

    /**
     * Sets fixed bids and priorities for keyword and auto-targeting.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param KeywordBid|KeywordBids|ModelCommonInterface $keywordBids
     * @return Result
     * @throws ServiceException
     */
    public function setRelatedKeywordBids($keywords, ModelCommonInterface $keywordBids): Result
    {
        return $this->session->getKeywordBidsService()->set(
            $this->bind($keywords, $keywordBids, 'KeywordId')
        );
    }

    /**
     * Set keyword bid designer options.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param KeywordBidAuto|KeywordBidsAuto|ModelCommonInterface $keywordsBidsAuto
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function setRelatedKeywordBidsAuto($keywords, ModelCommonInterface $keywordsBidsAuto): Result
    {
        return $this->session->getKeywordBidsService()->setAuto(
            $this->bind($keywords, $keywordsBidsAuto, 'KeywordId')
        );
    }

    /**
     * Gets keyword bids.
     *
     * @param integer|integer[]|Keyword|Keywords|ModelCommonInterface $keywords
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedKeywordBids($keywords, array $fields): Result
    {
        return $this->session->getKeywordBidsService()->query()
            ->select($fields)
            ->whereIn('KeywordIds', $this->extractIds($keywords))
            ->get();
    }
}