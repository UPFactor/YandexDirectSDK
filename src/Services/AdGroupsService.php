<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\KeywordBids;
use YandexDirectSDK\Collections\KeywordBidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\BidModifierToggle;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\KeywordBid;
use YandexDirectSDK\Models\KeywordBidAuto;
use YandexDirectSDK\Models\Webpage;

/** 
 * Class AdGroupsService 
 * 
 * @method   Result         add(ModelCommonInterface $adGroups)
 * @method   Result         update(ModelCommonInterface $adGroups)
 * @method   QueryBuilder   query() 
 * @method   Result         delete(ModelCommonInterface|integer[]|integer $adGroups)
 * 
 * @package YandexDirectSDK\Services 
 */
class AdGroupsService extends Service
{
    protected $serviceName = 'adgroups';

    protected $serviceModelClass = AdGroup::class;

    protected $serviceModelCollectionClass = AdGroups::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'update' => 'update:updateCollection',
        'query' => 'get:selectionElements',
        'delete' => 'delete:actionByIds'
    ];

    /**
     * Add ads for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param Ad|Ads|ModelCommonInterface $ads
     * @return Result
     * @throws ServiceException
     */
    public function addRelatedAds($adGroups, ModelCommonInterface $ads): Result
    {
        return $this->session->getAdsService()->add(
            $this->bind($adGroups, $ads, 'AdGroupId')
        );
    }

    /**
     * Gets ads for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedAds($adGroups, array $fields): Result
    {
        return $this->session->getAdsService()->query()
            ->select($fields)
            ->whereIn('AdGroupIds', $this->extractIds($adGroups))
            ->get();

    }

    /**
     * Add audience targets for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param AudienceTarget|AudienceTargets|ModelCommonInterface $audienceTargets
     * @return Result
     * @throws ServiceException
     */
    public function addRelatedAudienceTargets($adGroups, ModelCommonInterface $audienceTargets): Result
    {
        return $this->session->getAudienceTargetsService()->add(
            $this->bind($adGroups, $audienceTargets, 'AdGroupId')
        );
    }

    /**
     * Gets audience targets for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedAudienceTargets($adGroups, array $fields): Result
    {
        return $this->session->getAudienceTargetsService()->query()
            ->select($fields)
            ->whereIn('AdGroupIds', $this->extractIds($adGroups))
            ->get();
    }

    /**
     * Set bids for all keywords in given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param integer $bid
     * @param integer|null $contextBid
     * @return Result
     * @throws InvalidArgumentException
     */
    public function updateBids($adGroups, $bid = null, $contextBid = null): Result
    {
        $collection = new Bids();

        foreach ($this->extractIds($adGroups) as $id){
            $model = Bid::make()->setAdGroupId($id);
            if (!is_null($contextBid)) $model->setBid((integer) $bid);
            if (!is_null($contextBid)) $model->setContextBid((integer) $contextBid);
            $collection->push($model);
        }

        return $this->session->getBidsService()->set($collection);
    }

    /**
     * Set strategy priority for all keywords in given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param string $strategyPriority
     * @return Result
     * @throws InvalidArgumentException
     */
    public function updateStrategyPriority($adGroups, string $strategyPriority): Result
    {
        $collection = new Bids();

        foreach ($this->extractIds($adGroups) as $id){
            $collection->push(
                Bid::make()
                    ->setAdGroupId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return $this->session->getBidsService()->set($collection);
    }

    /**
     * Sets bid designer options for all keywords in given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param BidAuto|BidsAuto|ModelCommonInterface $bidsAuto
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws RequestException
     */
    public function updateBidsAuto($adGroups, ModelCommonInterface $bidsAuto): Result
    {
        return $this->session->getBidsService()->setAuto(
            $this->bind($adGroups, $bidsAuto, 'AdGroupId')
        );
    }

    /**
     * Gets bids for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedBids($adGroups, array $fields): Result
    {
        return $this->session->getBidsService()->query()
            ->select($fields)
            ->whereIn('AdGroupIds', $this->extractIds($adGroups))
            ->get();
    }

    /**
     * Add bid modifiers for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param BidModifier|BidModifiers|ModelCommonInterface $bidModifiers
     * @return Result
     * @throws ServiceException
     */
    public function addRelatedBidModifiers($adGroups, ModelCommonInterface $bidModifiers): Result
    {
        return $this->session->getBidModifiersService()->set(
            $this->bind($adGroups, $bidModifiers, 'AdGroupId')
        );
    }

    /**
     * Enable bid modifiers for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param string $bidModifierType
     * @return Result
     * @throws InvalidArgumentException
     */
    public function enableBidModifiers($adGroups, string $bidModifierType): Result
    {
        $collection = new BidModifierToggles();

        foreach ($this->extractIds($adGroups) as $id){
            $collection->push(
                BidModifierToggle::make([
                    'AdGroupId' => $id,
                    'Type' => $bidModifierType,
                    'Enabled' => BidModifierToggle::YES
                ])
            );
        }

        return $this->session->getBidModifiersService()->toggle($collection);
    }

    /**
     * Disable bid modifiers for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param string $bidModifierType
     * @return Result
     * @throws InvalidArgumentException
     */
    public function disableBidModifiers($adGroups, string $bidModifierType): Result
    {
        $collection = new BidModifierToggles();

        foreach ($this->extractIds($adGroups) as $id){
            $collection->push(
                BidModifierToggle::make([
                    'AdGroupId' => $id,
                    'Type' => $bidModifierType,
                    'Enabled' => BidModifierToggle::NO
                ])
            );
        }

        return $this->session->getBidModifiersService()->toggle($collection);
    }

    /**
     * Get bid modifiers for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedBidModifiers($adGroups, array $fields): Result
    {
        return $this->session->getBidModifiersService()->query()
            ->select($fields)
            ->whereIn('AdGroupIds', $this->extractIds($adGroups))
            ->get();
    }

    /**
     * Set keyword bids for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param integer $searchBid
     * @param integer|null $networkBid
     * @return Result
     * @throws InvalidArgumentException
     */
    public function updateKeywordBids($adGroups, $searchBid = null, $networkBid = null): Result
    {
        $collection = new KeywordBids();

        foreach ($this->extractIds($adGroups) as $id){
            $model = KeywordBid::make()->setAdGroupId($id);
            if (!is_null($searchBid)) $model->setSearchBid((integer) $searchBid);
            if (!is_null($networkBid)) $model->setNetworkBid((integer) $networkBid);
            $collection->push($model);
        }

        return $this->session->getKeywordBidsService()->set($collection);
    }

    /**
     * Set keyword strategy priority for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param string $strategyPriority
     * @return Result
     * @throws InvalidArgumentException
     */
    public function updateKeywordStrategyPriority($adGroups, string $strategyPriority): Result
    {
        $collection = new KeywordBids();

        foreach ($this->extractIds($adGroups) as $id){
            $model = KeywordBid::make()
                ->setAdGroupId($id)
                ->setStrategyPriority($strategyPriority);

            $collection->push($model);
        }

        return $this->session->getKeywordBidsService()->set($collection);
    }

    /**
     * Set keyword bid designer options for in given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param KeywordBidAuto|KeywordBidsAuto|ModelCommonInterface $keywordsBidsAuto
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function updateKeywordBidsAuto($adGroups, ModelCommonInterface $keywordsBidsAuto): Result
    {
        return $this->session->getKeywordBidsService()->setAuto(
            $this->bind($adGroups, $keywordsBidsAuto, 'AdGroupId')
        );
    }

    /**
     * Gets keyword bids for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedKeywordBids($adGroups, array $fields): Result
    {
        return $this->session->getKeywordBidsService()->query()
            ->select($fields)
            ->whereIn('AdGroupIds', $this->extractIds($adGroups))
            ->get();
    }

    /**
     * Add keywords for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param Keyword|Keywords|ModelCommonInterface $keywords
     * @return Result
     * @throws ServiceException
     */
    public function addRelatedKeywords($adGroups, ModelCommonInterface $keywords): Result
    {
        return $this->session->getKeywordsService()->add(
            $this->bind($adGroups, $keywords, 'AdGroupId')
        );
    }

    /**
     * Gets keywords for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedKeywords($adGroups, array $fields): Result
    {
        return $this->session->getKeywordsService()->query()
            ->select($fields)
            ->whereIn('AdGroupIds', $this->extractIds($adGroups))
            ->get();
    }

    /**
     * Add the targeting conditions for dynamic ads for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param Webpage|Webpages|ModelCommonInterface $webpages
     * @return Result
     * @throws ServiceException
     */
    public function addRelatedWebpages($adGroups, ModelCommonInterface $webpages): Result
    {
        return $this->session->getDynamicTextAdTargetsService()->add(
            $this->bind($adGroups, $webpages, 'AdGroupId')
        );
    }

    /**
     * Get the targeting conditions for dynamic ads for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedWebpages($adGroups, array $fields): Result
    {
        return $this->session->getDynamicTextAdTargetsService()->query()
            ->select($fields)
            ->whereIn('AdGroupIds', $this->extractIds($adGroups))
            ->get();
    }
}