<?php

namespace YandexDirectSDK\Services;

use ReflectionException;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Collections\AdGroups;
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
use YandexDirectSDK\Models\Ad;
use YandexDirectSDK\Models\AdGroup;
use YandexDirectSDK\Models\AudienceTarget;
use YandexDirectSDK\Models\Bid;
use YandexDirectSDK\Models\BidAuto;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\BidModifierToggle;
use YandexDirectSDK\Models\Keyword;
use YandexDirectSDK\Models\Webpage;

/** 
 * Class AdGroupsService 
 * 
 * @method   Result                  add(AdGroup|AdGroups|ModelCommonInterface $adGroups)
 * @method   Result                  update(AdGroup|AdGroups|ModelCommonInterface $adGroups)
 * @method   QueryBuilder            query()
 * @method   AdGroup|AdGroups|null   find(integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $ids, string[] $fields)
 * @method   Result                  delete(integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups)
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
        'find' => 'get:selectionByIds',
        'delete' => 'delete:actionByIds'
    ];

    /**
     * Add ads for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param Ad|Ads|ModelCommonInterface $ads
     * @return Result
     * @throws ServiceException
     * @throws ModelException
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
     * @throws ModelException
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
     * @throws ModelException
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
     * @throws ModelException
     */
    public function getRelatedAudienceTargets($adGroups, array $fields): Result
    {
        return $this->session->getAudienceTargetsService()->query()
            ->select($fields)
            ->whereIn('AdGroupIds', $this->extractIds($adGroups))
            ->get();
    }

    /**
     * Sets bids for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param integer $bid
     * @param integer|null $contextBid
     * @return Result
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function setRelatedBids($adGroups, $bid, $contextBid = null):Result
    {
        $adGroupIds = $this->extractIds($adGroups);
        $bids = new Bids();

        if (func_num_args() > 2){
            foreach ($adGroupIds as $id){
                $bids->push(
                    Bid::make()
                        ->setAdGroupId($id)
                        ->setBid($bid)
                        ->setContextBid( $contextBid)
                );
            }
        } else {
            foreach ($adGroupIds as $id){
                $bids->push(
                    Bid::make()
                        ->setAdGroupId($id)
                        ->setBid($bid)
                );
            }
        }

        return $this->session->getBidsService()->set($bids);
    }

    /**
     * Sets context bids for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param integer $contextBid
     * @return Result
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function setRelatedContextBids($adGroups, $contextBid):Result
    {
        $adGroupIds = $this->extractIds($adGroups);
        $bids = new Bids();

        foreach ($adGroupIds as $id){
            $bids->push(
                Bid::make()
                    ->setAdGroupId($id)
                    ->setContextBid($contextBid)
            );
        }

        return $this->session->getBidsService()->set($bids);
    }

    /**
     * Sets strategy priority for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param string $strategyPriority
     * @return Result
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelException
     */
    public function setRelatedStrategyPriority($adGroups, string $strategyPriority):Result
    {
        $adGroupIds = $this->extractIds($adGroups);
        $bids = new Bids();

        foreach ($adGroupIds as $id){
            $bids->push(
                Bid::make()
                    ->setAdGroupId($id)
                    ->setStrategyPriority($strategyPriority)
            );
        }

        return $this->session->getBidsService()->set($bids);
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
     * @throws ModelException
     */
    public function setRelatedBidsAuto($adGroups, ModelCommonInterface $bidsAuto): Result
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
     * @throws ModelException
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
     * @throws InvalidArgumentException
     * @throws ModelCollectionException
     * @throws RequestException
     * @throws RuntimeException
     * @throws ServiceException
     * @throws ReflectionException
     * @throws ModelException
     */
    public function addRelatedBidModifiers($adGroups, ModelCommonInterface $bidModifiers): Result
    {
        return $this->session->getBidModifiersService()->add(
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
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelCollectionException
     * @throws ModelException
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
     * @throws RequestException
     * @throws RuntimeException
     * @throws ModelCollectionException
     * @throws ModelException
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
     * @throws ModelException
     */
    public function getRelatedBidModifiers($adGroups, array $fields): Result
    {
        return $this->session->getBidModifiersService()->query()
            ->select($fields)
            ->whereIn('AdGroupIds', $this->extractIds($adGroups))
            ->whereIn('Levels', ['CAMPAIGN','AD_GROUP'])
            ->get();
    }

    /**
     * Add keywords for given ad groups.
     *
     * @param integer|integer[]|AdGroup|AdGroups|ModelCommonInterface $adGroups
     * @param Keyword|Keywords|ModelCommonInterface $keywords
     * @return Result
     * @throws ServiceException
     * @throws ModelException
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
     * @throws ModelException
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
     * @throws ModelException
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
     * @throws ModelException
     */
    public function getRelatedWebpages($adGroups, array $fields): Result
    {
        return $this->session->getDynamicTextAdTargetsService()->query()
            ->select($fields)
            ->whereIn('AdGroupIds', $this->extractIds($adGroups))
            ->get();
    }
}