<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Services\CampaignsService;
use YandexDirectSDK\Components\Model;

/** 
 * Class Campaign 
 * 
 * @property        integer               $id 
 * @property        string                $clientInfo 
 * @property        Notification          $notification 
 * @property        string                $timeZone 
 * @property        string                $name 
 * @property        string                $startDate 
 * @property        string                $endDate 
 * @property        DailyBudget           $dailyBudget 
 * @property        string[]              $negativeKeywords 
 * @property        string[]              $blockedIps 
 * @property        string[]              $excludedSites 
 * @property        TextCampaign          $textCampaign 
 * @property        MobileAppCampaign     $mobileAppCampaign 
 * @property        DynamicTextCampaign   $dynamicTextCampaign 
 * @property        CpmBannerCampaign     $cpmBannerCampaign 
 * @property        TimeTargeting         $timeTargeting 
 * @property-read   string                $type 
 * @property-read   string                $status 
 * @property-read   string                $state 
 * @property-read   string                $statusPayment 
 * @property-read   string                $statusClarification 
 * @property-read   integer               $sourceId 
 * @property-read   Statistics            $statistics 
 * @property-read   string                $currency 
 * @property-read   FundsParam            $funds 
 * @property-read   CampaignAssistant     $representedBy 
 * 
 * @method          $this                 setId(integer $id) 
 * @method          $this                 setClientInfo(string $clientInfo) 
 * @method          $this                 setNotification(Notification $notification) 
 * @method          $this                 setTimeZone(string $timeZone) 
 * @method          $this                 setName(string $name) 
 * @method          $this                 setStartDate(string $startDate) 
 * @method          $this                 setEndDate(string $endDate) 
 * @method          $this                 setDailyBudget(DailyBudget $dailyBudget) 
 * @method          $this                 setNegativeKeywords(string[] $negativeKeywords) 
 * @method          $this                 setBlockedIps(string[] $blockedIps) 
 * @method          $this                 setExcludedSites(string[] $excludedSites) 
 * @method          $this                 setTextCampaign(TextCampaign $textCampaign) 
 * @method          $this                 setMobileAppCampaign(MobileAppCampaign $mobileAppCampaign) 
 * @method          $this                 setDynamicTextCampaign(DynamicTextCampaign $dynamicTextCampaign) 
 * @method          $this                 setCpmBannerCampaign(CpmBannerCampaign $cpmBannerCampaign) 
 * @method          $this                 setTimeTargeting(TimeTargeting $timeTargeting) 
 * 
 * @method          integer               getId() 
 * @method          string                getClientInfo() 
 * @method          Notification          getNotification() 
 * @method          string                getTimeZone() 
 * @method          string                getName() 
 * @method          string                getStartDate() 
 * @method          string                getEndDate() 
 * @method          DailyBudget           getDailyBudget() 
 * @method          string[]              getNegativeKeywords() 
 * @method          string[]              getBlockedIps() 
 * @method          string[]              getExcludedSites() 
 * @method          TextCampaign          getTextCampaign() 
 * @method          MobileAppCampaign     getMobileAppCampaign() 
 * @method          DynamicTextCampaign   getDynamicTextCampaign() 
 * @method          CpmBannerCampaign     getCpmBannerCampaign() 
 * @method          TimeTargeting         getTimeTargeting() 
 * @method          string                getType() 
 * @method          string                getStatus() 
 * @method          string                getState() 
 * @method          string                getStatusPayment() 
 * @method          string                getStatusClarification() 
 * @method          integer               getSourceId() 
 * @method          Statistics            getStatistics() 
 * @method          string                getCurrency() 
 * @method          FundsParam            getFunds() 
 * @method          CampaignAssistant     getRepresentedBy() 
 * 
 * @method          QueryBuilder          query() 
 * @method          Result                add() 
 * @method          Result                update() 
 * @method          Result                delete() 
 * @method          Result                suspend() 
 * @method          Result                resume() 
 * @method          Result                archive() 
 * @method          Result                unarchive() 
 * 
 * @package YandexDirectSDK\Models 
 */
class Campaign extends Model
{
    protected $compatibleCollection = Campaigns::class;

    protected $serviceProvidersMethods = [
        'query' => CampaignsService::class,
        'add' => CampaignsService::class,
        'update' => CampaignsService::class,
        'delete' => CampaignsService::class,
        'suspend' => CampaignsService::class,
        'resume' => CampaignsService::class,
        'archive' => CampaignsService::class,
        'unarchive' => CampaignsService::class
    ];

    protected $properties = [
        'id'=>'integer',
        'clientInfo' => 'string',
        'notification' => 'object:' . Notification::class,
        'timeZone' => 'string',
        'name' => 'string',
        'startDate' => 'string',
        'endDate' => 'string',
        'dailyBudget' => 'object:' . DailyBudget::class,
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

    protected $nonWritableProperties = [
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

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'name',
        'startDate',
        'textCampaign|mobileAppCampaign|dynamicTextCampaign|cpmBannerCampaign'
    ];
}