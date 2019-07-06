<?php

namespace YandexDirectSDK\Services;

use ReflectionException;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\ModelException;
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

/** 
 * Class CampaignsService 
 * 
 * @method   Result                    add(Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method   QueryBuilder              query()
 * @method   Campaign|Campaigns|null   find(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $ids, string[] $fields)
 * @method   Result                    update(Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method   Result                    archive(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method   Result                    delete(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method   Result                    resume(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method   Result                    suspend(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns)
 * @method   Result                    unarchive(integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns)
 * 
 * @package YandexDirectSDK\Services 
 */
class CampaignsService extends Service
{
    protected static $name = 'campaigns';

    protected static $modelClass = Campaign::class;

    protected static $modelCollectionClass = Campaigns::class;

    protected static $methods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds',
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
     * @throws ModelException
     */
    public function addRelatedAdGroups($campaigns, ModelCommonInterface $adGroups): Result
    {
        return AdGroupsService::make()
            ->setSession($this->session)
            ->add($this->bind($campaigns, $adGroups, 'CampaignId'));
    }

    /**
     * Gets ad groups for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function getRelatedAdGroups($campaigns, array $fields): Result
    {
        return AdGroupsService::make()
            ->setSession($this->session)
            ->query()
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
     * @throws ModelException
     */
    public function getRelatedAds($campaigns, array $fields): Result
    {
        return AdsService::make()
            ->setSession($this->session)
            ->query()
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
     * @throws ModelException
     */
    public function getRelatedAudienceTargets($campaigns, array $fields): Result
    {
        return AudienceTargetsService::make()
            ->setSession($this->session)
            ->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->get();
    }

    /**
     * Sets bids for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param integer $bid
     * @param integer|null $contextBid
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function setRelatedBids($campaigns, $bid, $contextBid = null):Result
    {
        $campaignIds = $this->extractIds($campaigns);
        $bids = new Bids();

        if (func_num_args() > 2){
            foreach ($campaignIds as $id){
                $bids->push(
                    Bid::make()
                        ->setCampaignId($id)
                        ->setBid($bid)
                        ->setContextBid( $contextBid)
                );
            }
        } else {
            foreach ($campaignIds as $id){
                $bids->push(
                    Bid::make()
                        ->setCampaignId($id)
                        ->setBid($bid)
                );
            }
        }

        return BidsService::make()
            ->setSession($this->session)
            ->set($bids);
    }

    /**
     * Sets context bids for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param integer $contextBid
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function setRelatedContextBids($campaigns, $contextBid):Result
    {
        $campaignIds = $this->extractIds($campaigns);
        $bids = new Bids();

        foreach ($campaignIds as $id){
            $bids->push(
                Bid::make()
                    ->setCampaignId($id)
                    ->setContextBid($contextBid)
            );
        }

        return BidsService::make()
            ->setSession($this->session)
            ->set($bids);
    }

    /**
     * Sets strategy priority for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param string $strategyPriority
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function setRelatedStrategyPriority($campaigns, string $strategyPriority):Result
    {
        $campaignIds = $this->extractIds($campaigns);
        $bids = new Bids();

        foreach ($campaignIds as $id){
            $bids->push(
                Bid::make()
                    ->setCampaignId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return BidsService::make()
            ->setSession($this->session)
            ->set($bids);
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
     * @throws ModelException
     */
    public function setRelatedBidsAuto($campaigns, ModelCommonInterface $bidsAuto): Result
    {
        return BidsService::make()
            ->setSession($this->session)
            ->setAuto($this->bind($campaigns, $bidsAuto, 'CampaignId'));
    }

    /**
     * Gets bids for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function getRelatedBids($campaigns, array $fields): Result
    {
        return BidsService::make()
            ->setSession($this->session)
            ->query()
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
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ReflectionException
     * @throws ModelException
     */
    public function addRelatedBidModifiers($campaigns, ModelCommonInterface $bidModifiers): Result
    {
        return BidModifiersService::make()
            ->setSession($this->session)
            ->add($this->bind($campaigns, $bidModifiers, 'CampaignId'));
    }

    /**
     * Enable bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param string $bidModifierType
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
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

        return BidModifiersService::make()
            ->setSession($this->session)
            ->toggle($collection);
    }

    /**
     * Disable bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param string $bidModifierType
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
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

        return BidModifiersService::make()
            ->setSession($this->session)
            ->toggle($collection);
    }

    /**
     * Get bid modifiers for given campaigns.
     *
     * @param integer|integer[]|Campaign|Campaigns|ModelCommonInterface $campaigns
     * @param array $fields
     * @return Result
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function getRelatedBidModifiers($campaigns, array $fields): Result
    {
        return BidModifiersService::make()
            ->setSession($this->session)
            ->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->whereIn('Levels', ['CAMPAIGN','AD_GROUP'])
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
     * @throws ModelException
     */
    public function getRelatedKeywords($campaigns, array $fields): Result
    {
        return KeywordsService::make()
            ->setSession($this->session)
            ->query()
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
     * @throws ModelException
     */
    public function getRelatedWebpages($campaigns, array $fields): Result
    {
        return DynamicTextAdTargetsService::make()
            ->setSession($this->session)
            ->query()
            ->select($fields)
            ->whereIn('CampaignIds', $this->extractIds($campaigns))
            ->get();
    }
}