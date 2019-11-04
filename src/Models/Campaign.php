<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Services\CampaignsService;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;


/** 
 * Class Campaign 
 * 
 * @property          integer                     $id
 * @property          string                      $clientInfo
 * @property          Notification                $notification
 * @property          string                      $timeZone
 * @property          string                      $name
 * @property          string                      $startDate
 * @property          DailyBudget                 $dailyBudget
 * @property          string                      $endDate
 * @property          string[]                    $negativeKeywords
 * @property          string[]                    $blockedIps
 * @property          string[]                    $excludedSites
 * @property          TextCampaign                $textCampaign
 * @property          MobileAppCampaign           $mobileAppCampaign
 * @property          DynamicTextCampaign         $dynamicTextCampaign
 * @property          CpmBannerCampaign           $cpmBannerCampaign
 * @property          TimeTargeting               $timeTargeting
 * @property-read     string                      $type
 * @property-read     string                      $status
 * @property-read     string                      $state
 * @property-read     string                      $statusPayment
 * @property-read     string                      $statusClarification
 * @property-read     integer                     $sourceId
 * @property-read     Statistics                  $statistics
 * @property-read     string                      $currency
 * @property-read     FundsParam                  $funds
 * @property-read     CampaignAssistant           $representedBy
 *                                                
 * @method static     QueryBuilder                query()
 * @method static     Campaign|Campaigns|null     find(integer|integer[]|string|string[] $ids, string[] $fields)
 * @method            Result                      add()
 * @method            Result                      update()
 * @method            Result                      delete()
 * @method            Result                      suspend()
 * @method            Result                      resume()
 * @method            Result                      archive()
 * @method            Result                      unarchive()
 * @method            Result                      addRelatedAdGroups(ModelCommonInterface $adGroups)
 * @method            Result                      getRelatedAdGroups(array $fields)
 * @method            Result                      getRelatedAds(array $fields)
 * @method            Result                      getRelatedAudienceTargets(array $fields)
 * @method            Result                      setRelatedBids($bid, $contextBid=null)
 * @method            Result                      setRelatedContextBids($contextBid)
 * @method            Result                      setRelatedStrategyPriority(string $strategyPriority)
 * @method            Result                      setRelatedBidsAuto(ModelCommonInterface $bidsAuto)
 * @method            Result                      getRelatedBids(array $fields)
 * @method            Result                      addRelatedBidModifiers(ModelCommonInterface $bidModifiers)
 * @method            Result                      enableBidModifiers(string $bidModifierType)
 * @method            Result                      disableBidModifiers(string $bidModifierType)
 * @method            Result                      getRelatedBidModifiers(array $fields)
 * @method            Result                      getRelatedKeywords(array $fields)
 * @method            Result                      getRelatedWebpages(array $fields)
 * @method            $this                       setId(integer $id)
 * @method            integer                     getId()
 * @method            $this                       setClientInfo(string $clientInfo)
 * @method            string                      getClientInfo()
 * @method            $this                       setNotification(Notification $notification)
 * @method            Notification                getNotification()
 * @method            $this                       setTimeZone(string $timeZone)
 * @method            string                      getTimeZone()
 * @method            $this                       setName(string $name)
 * @method            string                      getName()
 * @method            $this                       setStartDate(string $startDate)
 * @method            string                      getStartDate()
 * @method            $this                       setDailyBudget(DailyBudget $dailyBudget)
 * @method            DailyBudget                 getDailyBudget()
 * @method            $this                       setEndDate(string $endDate)
 * @method            string                      getEndDate()
 * @method            $this                       setNegativeKeywords(string[] $negativeKeywords)
 * @method            string[]                    getNegativeKeywords()
 * @method            $this                       setBlockedIps(string[] $blockedIps)
 * @method            string[]                    getBlockedIps()
 * @method            $this                       setExcludedSites(string[] $excludedSites)
 * @method            string[]                    getExcludedSites()
 * @method            $this                       setTextCampaign(TextCampaign $textCampaign)
 * @method            TextCampaign                getTextCampaign()
 * @method            $this                       setMobileAppCampaign(MobileAppCampaign $mobileAppCampaign)
 * @method            MobileAppCampaign           getMobileAppCampaign()
 * @method            $this                       setDynamicTextCampaign(DynamicTextCampaign $dynamicTextCampaign)
 * @method            DynamicTextCampaign         getDynamicTextCampaign()
 * @method            $this                       setCpmBannerCampaign(CpmBannerCampaign $cpmBannerCampaign)
 * @method            CpmBannerCampaign           getCpmBannerCampaign()
 * @method            $this                       setTimeTargeting(TimeTargeting $timeTargeting)
 * @method            TimeTargeting               getTimeTargeting()
 * @method            string                      getType()
 * @method            string                      getStatus()
 * @method            string                      getState()
 * @method            string                      getStatusPayment()
 * @method            string                      getStatusClarification()
 * @method            integer                     getSourceId()
 * @method            Statistics                  getStatistics()
 * @method            string                      getCurrency()
 * @method            FundsParam                  getFunds()
 * @method            CampaignAssistant           getRepresentedBy()
 * 
 * @package YandexDirectSDK\Models 
 */
class Campaign extends Model
{
    protected static $compatibleCollection = Campaigns::class;

    protected static $staticMethods = [
        'query' => CampaignsService::class,
        'find' => CampaignsService::class
    ];

    protected static $methods = [
        'add' => CampaignsService::class,
        'update' => CampaignsService::class,
        'delete' => CampaignsService::class,
        'suspend' => CampaignsService::class,
        'resume' => CampaignsService::class,
        'archive' => CampaignsService::class,
        'unarchive' => CampaignsService::class,
        'addRelatedAdGroups' => CampaignsService::class,
        'getRelatedAdGroups' => CampaignsService::class,
        'getRelatedAds' => CampaignsService::class,
        'getRelatedAudienceTargets' => CampaignsService::class,
        'setRelatedBids' => CampaignsService::class,
        'setRelatedContextBids' => CampaignsService::class,
        'setRelatedStrategyPriority' => CampaignsService::class,
        'setRelatedBidsAuto' => CampaignsService::class,
        'getRelatedBids' => CampaignsService::class,
        'addRelatedBidModifiers' => CampaignsService::class,
        'enableBidModifiers' => CampaignsService::class,
        'disableBidModifiers' => CampaignsService::class,
        'getRelatedBidModifiers' => CampaignsService::class,
        'getRelatedKeywords' => CampaignsService::class,
        'getRelatedWebpages' => CampaignsService::class
    ];

    protected static $properties = [
        'id'=>'integer',
        'clientInfo' => 'string',
        'notification' => 'object:' . Notification::class,
        'timeZone' => 'string',
        'name' => 'string',
        'startDate' => 'string',
        'dailyBudget' => 'object:' . DailyBudget::class,
        'endDate' => 'string',
        'negativeKeywords' => 'array:string',
        'blockedIps' => 'array:string',
        'excludedSites' => 'array:string',
        'textCampaign' => 'object:' . TextCampaign::class,
        'mobileAppCampaign' => 'object:' . MobileAppCampaign::class,
        'dynamicTextCampaign' => 'object:' . DynamicTextCampaign::class,
        'cpmBannerCampaign' => 'object:' . CpmBannerCampaign::class,
        'timeTargeting' => 'object:' . TimeTargeting::class,
        'type' => 'string',
        'status' => 'string',
        'state' => 'string',
        'statusPayment' => 'string',
        'statusClarification' => 'string',
        'sourceId' => 'integer',
        'statistics' => 'object:' . Statistics::class,
        'currency' => 'string',
        'funds' => 'object:' . FundsParam::class,
        'representedBy' => 'object:' . CampaignAssistant::class
    ];

    protected static $nonWritableProperties = [
        'type',
        'status',
        'state',
        'statusPayment',
        'statusClarification',
        'sourceId',
        'statistics',
        'currency',
        'funds',
        'representedBy'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}