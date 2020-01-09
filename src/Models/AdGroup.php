<?php 
namespace YandexDirectSDK\Models;

use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Models\Foundation\To;
use YandexDirectSDK\Services\AdGroupsService;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/** 
 * Class AdGroup 
 * 
 * @property           integer                    $id
 * @property           string                     $name
 * @property           integer                    $campaignId
 * @property           integer[]                  $regionIds
 * @property-read      integer[]                  $restrictedRegionIds
 * @property           string[]                   $negativeKeywords
 * @property           integer[]                  $negativeKeywordSharedSetIds
 * @property           string                     $trackingParams
 * @property           MobileAppAdGroup           $mobileAppAdGroup
 * @property           DynamicTextAdGroup         $dynamicTextAdGroup
 * @property-read      DynamicTextFeedAdGroup     $dynamicTextFeedAdGroup
 * @property-write     mixed                      $cpmBannerKeywordsAdGroup
 * @property-write     mixed                      $cpmBannerUserProfileAdGroup
 * @property-write     mixed                      $cpmVideoAdGroup
 * @property-read      string                     $status
 * @property-read      string                     $servingStatus
 * @property-read      string                     $type
 * @property-read      string                     $subtype
 *                                                
 * @method static      QueryBuilder               query()
 * @method static      AdGroup|AdGroups|null      find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method             Result                     create()
 * @method             Result                     update()
 * @method             Result                     delete()
 * @method             Result                     addRelatedAds(ModelCommonInterface $ads)
 * @method             Ads                        getRelatedAds(array $fields=[])
 * @method             Result                     addRelatedAudienceTargets(ModelCommonInterface $audienceTargets)
 * @method             AudienceTargets            getRelatedAudienceTargets(array $fields=[])
 * @method             Result                     setRelatedBids($bid, $contextBid=null)
 * @method             Result                     setRelatedContextBids($contextBid)
 * @method             Result                     setRelatedStrategyPriority(string $strategyPriority)
 * @method             Result                     setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method             Bids                       getRelatedBids(array $fields=[])
 * @method             Result                     addRelatedBidModifiers(ModelCommonInterface $bidModifiers)
 * @method             Result                     enableBidModifiers(string $bidModifierType)
 * @method             Result                     disableBidModifiers(string $bidModifierType)
 * @method             BidModifiers               getRelatedBidModifiers(array $fields=[], array $levels=['AD_GROUP'])
 * @method             Result                     addRelatedKeywords($keywords)
 * @method             Keywords                   getRelatedKeywords(array $fields=[])
 * @method             Result                     addRelatedWebpages(ModelCommonInterface $webpages)
 * @method             Webpages                   getRelatedWebpages(array $fields=[])
 * @method             $this                      setId(integer $id)
 * @method             integer                    getId()
 * @method             $this                      setName(string $name)
 * @method             string                     getName()
 * @method             $this                      setCampaignId(integer $campaignId)
 * @method             integer                    getCampaignId()
 * @method             $this                      setRegionIds(integer[] $regionIds)
 * @method             integer[]                  getRegionIds()
 * @method             integer[]                  getRestrictedRegionIds()
 * @method             $this                      setNegativeKeywords(string[] $negativeKeywords)
 * @method             string[]                   getNegativeKeywords()
 * @method             $this                      setNegativeKeywordSharedSetIds(integer[] $negativeKeywordSharedSetIds)
 * @method             integer[]                  getNegativeKeywordSharedSetIds()
 * @method             $this                      setTrackingParams(string $trackingParams)
 * @method             string                     getTrackingParams()
 * @method             $this                      setMobileAppAdGroup(MobileAppAdGroup|array $mobileAppAdGroup)
 * @method             MobileAppAdGroup           getMobileAppAdGroup()
 * @method             $this                      setDynamicTextAdGroup(DynamicTextAdGroup|array $dynamicTextAdGroup)
 * @method             DynamicTextAdGroup         getDynamicTextAdGroup()
 * @method             DynamicTextFeedAdGroup     getDynamicTextFeedAdGroup()
 * @method             string                     getStatus()
 * @method             string                     getServingStatus()
 * @method             string                     getType()
 * @method             string                     getSubtype()
 * 
 * @package YandexDirectSDK\Models 
 */
class AdGroup extends Model 
{ 
    use To;

    protected static $compatibleCollection = AdGroups::class;

    protected static $staticMethods = [
        'query' => AdGroupsService::class,
        'find' => AdGroupsService::class
    ];

    protected static $methods = [
        'create' => AdGroupsService::class,
        'update' => AdGroupsService::class,
        'delete' => AdGroupsService::class,
        'addRelatedAds' => AdGroupsService::class,
        'getRelatedAds' => AdGroupsService::class,
        'addRelatedAudienceTargets' => AdGroupsService::class,
        'getRelatedAudienceTargets' => AdGroupsService::class,
        'setRelatedBids' => AdGroupsService::class,
        'setRelatedContextBids' => AdGroupsService::class,
        'setRelatedStrategyPriority' => AdGroupsService::class,
        'setRelatedBidsAuto' => AdGroupsService::class,
        'getRelatedBids' => AdGroupsService::class,
        'addRelatedBidModifiers' => AdGroupsService::class,
        'enableBidModifiers' => AdGroupsService::class,
        'disableBidModifiers' => AdGroupsService::class,
        'getRelatedBidModifiers' => AdGroupsService::class,
        'addRelatedKeywords' => AdGroupsService::class,
        'getRelatedKeywords' => AdGroupsService::class,
        'addRelatedWebpages' => AdGroupsService::class,
        'getRelatedWebpages' => AdGroupsService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'name' => 'string',
        'campaignId' => 'integer',
        'regionIds' => 'stack:integer',
        'restrictedRegionIds' => 'array:integer',
        'negativeKeywords' => 'array:string',
        'negativeKeywordSharedSetIds' => 'array:integer',
        'trackingParams' => 'string',
        'mobileAppAdGroup' => 'object:' . MobileAppAdGroup::class,
        'dynamicTextAdGroup' => 'object:' . DynamicTextAdGroup::class,
        'dynamicTextFeedAdGroup' => 'object:' . DynamicTextFeedAdGroup::class,
        'cpmBannerKeywordsAdGroup' => 'custom',
        'cpmBannerUserProfileAdGroup' => 'custom',
        'cpmVideoAdGroup' => 'custom',
        'status' => 'string',
        'servingStatus' => 'string',
        'type' => 'string',
        'subtype' => 'string',

    ];

    protected static $nonUpdatableProperties = [
        'campaignId',
        'cpmBannerKeywordsAdGroup',
        'cpmBannerUserProfileAdGroup',
        'cpmVideoAdGroup'
    ];

    protected static $nonReadableProperties = [
        'cpmBannerKeywordsAdGroup',
        'cpmBannerUserProfileAdGroup',
        'cpmVideoAdGroup'
    ];

    protected static $nonWritableProperties = [
        'restrictedRegionIds',
        'dynamicTextFeedAdGroup',
        'status',
        'servingStatus',
        'type',
        'subtype'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];

    /**
     * Reloading method to set value of [cpmBannerKeywordsAdGroup] property.
     *
     * @return $this
     */
    public function setCpmBannerKeywordsAdGroup()
    {
        $this->data['cpmBannerKeywordsAdGroup'] = $this->setterCpmBannerKeywordsAdGroup();
        return $this;
    }

    /**
     * Reloading method to set value of [cpmBannerUserProfileAdGroup] property.
     *
     * @return $this
     */
    public function setCpmBannerUserProfileAdGroup()
    {
        $this->data['cpmBannerUserProfileAdGroup'] = $this->setterCpmBannerUserProfileAdGroup();
        return $this;
    }

    /**
     * Reloading method to set value of [cpmVideoAdGroup] property.
     *
     * @return $this
     */
    public function setCpmVideoAdGroup()
    {
        $this->data['cpmVideoAdGroup'] = $this->setterCpmVideoAdGroup();
        return $this;
    }

    /**
     * Setter of [cpmBannerKeywordsAdGroup] property.
     *
     * @return CpmBannerKeywordsAdGroup
     */
    protected function setterCpmBannerKeywordsAdGroup()
    {
        return CpmBannerKeywordsAdGroup::make();
    }

    /**
     * Setter of [cpmBannerUserProfileAdGroup] property.
     *
     * @return CpmBannerUserProfileAdGroup
     */
    protected function setterCpmBannerUserProfileAdGroup()
    {
        return CpmBannerUserProfileAdGroup::make();
    }

    /**
     * Setter of [cpmVideoAdGroup] property.
     *
     * @return CpmVideoAdGroup
     */
    protected function setterCpmVideoAdGroup()
    {
        return CpmVideoAdGroup::make();
    }

    /**
     * Import handler of [cpmBannerKeywordsAdGroup] property.
     *
     * @return CpmBannerKeywordsAdGroup
     */
    protected function importCpmBannerKeywordsAdGroup()
    {
        return $this->setterCpmBannerKeywordsAdGroup();
    }

    /**
     * Import handler of [cpmBannerUserProfileAdGroup] property.
     *
     * @return CpmBannerUserProfileAdGroup
     */
    protected function importCpmBannerUserProfileAdGroup()
    {
        return $this->setterCpmBannerUserProfileAdGroup();
    }

    /**
     * Import handler of [cpmVideoAdGroup] property.
     *
     * @return CpmVideoAdGroup
     */
    protected function importCpmVideoAdGroup()
    {
        return $this->setterCpmVideoAdGroup();
    }
}