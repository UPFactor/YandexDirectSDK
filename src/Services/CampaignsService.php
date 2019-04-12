<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\KeywordBids;
use YandexDirectSDK\Collections\KeywordBidsAuto;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
use YandexDirectSDK\Exceptions\ServiceException;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\BidModifierToggle;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Models\KeywordBid;
use YandexDirectSDK\Models\KeywordBidAuto;

/** 
 * Class CampaignsService 
 * 
 * @method   Result         add(ModelCommonInterface $campaigns)
 * @method   QueryBuilder   query() 
 * @method   Result         update(ModelCommonInterface $campaigns)
 * @method   Result         archive(ModelCommonInterface|integer[]|integer $campaigns)
 * @method   Result         delete(ModelCommonInterface|integer[]|integer $campaigns)
 * @method   Result         resume(ModelCommonInterface|integer[]|integer $campaigns)
 * @method   Result         suspend(ModelCommonInterface|integer[]|integer $campaigns)
 * @method   Result         unarchive(ModelCommonInterface|integer[]|integer $campaigns)
 * 
 * @package YandexDirectSDK\Services 
 */
class CampaignsService extends Service
{
    protected $serviceName = 'campaigns';

    protected $serviceModelClass = Campaign::class;

    protected $serviceModelCollectionClass = Campaigns::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'update' => 'update:updateCollection',
        'archive' => 'archive:actionByIds',
        'delete' => 'delete:actionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds',
        'unarchive' => 'unarchive:actionByIds'
    ];

    /**
     * Add ad groups for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @return Result
     * @throws ServiceException
     */
    public function addRelatedAdGroups($campaigns, ModelCommonInterface $adGroups): Result
    {
        return $this->session->getAdGroupsService()->add(
            $this->bind($campaigns, $adGroups, 'CampaignId')
        );
    }

    /**
     * Gets ad groups for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedAdGroups($campaigns, array $fields): Result
    {
        return $this->session->getAdGroupsService()->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->get();

    }

    /**
     * Gets ads for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedAds($campaigns, array $fields): Result
    {
        return $this->session->getAdsService()->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->get();

    }

    /**
     * Gets audience targets for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedAudienceTargets($campaigns, array $fields): Result
    {
        return $this->session->getAudienceTargetsService()->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->get();
    }

    /**
     * Set bids for all keywords in given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param integer $bid
     * @param integer|null $contextBid
     * @return Result
     * @throws InvalidArgumentException
     */
    public function updateBids($campaigns, $bid = null, $contextBid = null): Result
    {
        $collection = new Bids();

        foreach ($this->extractIds($campaigns) as $id){
            $model = Bid::make()->setCampaignId($id);
            if (!is_null($contextBid)) $model->setBid((integer) $bid);
            if (!is_null($contextBid)) $model->setContextBid((integer) $contextBid);
            $collection->push($model);
        }

        return $this->session->getBidsService()->set($collection);
    }

    /**
     * Set strategy priority for all keywords in given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param string $strategyPriority
     * @return Result
     * @throws InvalidArgumentException
     */
    public function updateStrategyPriority($campaigns, string $strategyPriority): Result
    {
        $collection = new Bids();

        foreach ($this->extractIds($campaigns) as $id){
            $collection->push(
                Bid::make()
                    ->setCampaignId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return $this->session->getBidsService()->set($collection);
    }

    /**
     * Sets bid designer options for all keywords in given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param BidAuto|BidsAuto|ModelCommonInterface $bidsAuto
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws RequestException
     */
    public function updateBidsAuto($campaigns, ModelCommonInterface $bidsAuto): Result
    {
        return $this->session->getBidsService()->setAuto(
            $this->bind($campaigns, $bidsAuto, 'CampaignId')
        );
    }

    /**
     * Gets bids for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedBids($campaigns, array $fields): Result
    {
        return $this->session->getBidsService()->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->get();
    }

    /**
     * Add bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param BidModifier|BidModifiers|ModelCommonInterface $bidModifiers
     * @return Result
     * @throws ServiceException
     */
    public function addRelatedBidModifiers($campaigns, ModelCommonInterface $bidModifiers): Result
    {
        return $this->session->getBidModifiersService()->set(
            $this->bind($campaigns, $bidModifiers, 'CampaignId')
        );
    }

    /**
     * Enable bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param string $bidModifierType
     * @return Result
     * @throws InvalidArgumentException
     */
    public function enableBidModifiers($campaigns, string $bidModifierType): Result
    {
        $collection = new BidModifierToggles();

        foreach ($this->extractIds($campaigns) as $id){
            $collection->push(
                BidModifierToggle::make([
                    'CampaignId' => $id,
                    'Type' => $bidModifierType,
                    'Enabled' => BidModifierToggle::YES
                ])
            );
        }

        return $this->session->getBidModifiersService()->toggle($collection);
    }

    /**
     * Disable bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param string $bidModifierType
     * @return Result
     * @throws InvalidArgumentException
     */
    public function disableBidModifiers($campaigns, string $bidModifierType): Result
    {
        $collection = new BidModifierToggles();

        foreach ($this->extractIds($campaigns) as $id){
            $collection->push(
                BidModifierToggle::make([
                    'CampaignId' => $id,
                    'Type' => $bidModifierType,
                    'Enabled' => BidModifierToggle::NO
                ])
            );
        }

        return $this->session->getBidModifiersService()->toggle($collection);
    }

    /**
     * Get bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedBidModifiers($campaigns, array $fields): Result
    {
        return $this->session->getBidModifiersService()->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->get();
    }

    /**
     * Set keyword bids for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param integer $searchBid
     * @param integer|null $networkBid
     * @return Result
     * @throws InvalidArgumentException
     */
    public function updateKeywordBids($campaigns, $searchBid = null, $networkBid = null): Result
    {
        $collection = new KeywordBids();

        foreach ($this->extractIds($campaigns) as $id){
            $model = KeywordBid::make()->setCampaignId($id);
            if (!is_null($searchBid)) $model->setSearchBid((integer) $searchBid);
            if (!is_null($networkBid)) $model->setNetworkBid((integer) $networkBid);
            $collection->push($model);
        }

        return $this->session->getKeywordBidsService()->set($collection);
    }

    /**
     * Set keyword strategy priority for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param string $strategyPriority
     * @return Result
     * @throws InvalidArgumentException
     */
    public function updateKeywordStrategyPriority($campaigns, string $strategyPriority): Result
    {
        $collection = new KeywordBids();

        foreach ($this->extractIds($campaigns) as $id){
            $model = KeywordBid::make()
                ->setCampaignId($id)
                ->setStrategyPriority($strategyPriority);

            $collection->push($model);
        }

        return $this->session->getKeywordBidsService()->set($collection);
    }

    /**
     * Set keyword bid designer options for in given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param KeywordBidAuto|KeywordBidsAuto|ModelCommonInterface $keywordsBidsAuto
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     */
    public function updateKeywordBidsAuto($campaigns, ModelCommonInterface $keywordsBidsAuto): Result
    {
        return $this->session->getKeywordBidsService()->setAuto(
            $this->bind($campaigns, $keywordsBidsAuto, 'CampaignId')
        );
    }

    /**
     * Gets keyword bids for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedKeywordBids($campaigns, array $fields): Result
    {
        return $this->session->getKeywordBidsService()->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->get();
    }

    /**
     * Gets keywords for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedKeywords($campaigns, array $fields): Result
    {
        return $this->session->getKeywordsService()->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->get();
    }

    /**
     * Get the targeting conditions for dynamic ads for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function getRelatedWebpages($campaigns, array $fields): Result
    {
        return $this->session->getDynamicTextAdTargetsService()->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->get();
    }
}