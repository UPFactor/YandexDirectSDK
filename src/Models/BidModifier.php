<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\DemographicsAdjustments;
use YandexDirectSDK\Collections\RegionalAdjustments;
use YandexDirectSDK\Collections\RetargetingAdjustments;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\BidModifiersService;

/** 
 * Class BidModifier 
 * 
 * @property            integer                   $id 
 * @property            integer                   $campaignId 
 * @property            integer                   $adGroupId 
 * @property            MobileAdjustment          $mobileAdjustment 
 * @property            DesktopAdjustment         $desktopAdjustment 
 * @property            DemographicsAdjustments   $demographicsAdjustments 
 * @property            RetargetingAdjustments    $retargetingAdjustments 
 * @property            RegionalAdjustments       $regionalAdjustments 
 * @property            VideoAdjustment           $videoAdjustment 
 * @property-readable   string                    $level 
 * @property-readable   string                    $type 
 * 
 * @method              $this                     setId(integer $id) 
 * @method              $this                     setCampaignId(integer $campaignId) 
 * @method              $this                     setAdGroupId(integer $adGroupId) 
 * @method              $this                     setMobileAdjustment(MobileAdjustment $mobileAdjustment) 
 * @method              $this                     setDesktopAdjustment(DesktopAdjustment $desktopAdjustment) 
 * @method              $this                     setDemographicsAdjustments(DemographicsAdjustments $demographicsAdjustments) 
 * @method              $this                     setRetargetingAdjustments(RetargetingAdjustments $retargetingAdjustments) 
 * @method              $this                     setRegionalAdjustments(RegionalAdjustments $regionalAdjustments) 
 * @method              $this                     setVideoAdjustment(VideoAdjustment $videoAdjustment) 
 * 
 * @method              integer                   getId() 
 * @method              integer                   getCampaignId() 
 * @method              integer                   getAdGroupId() 
 * @method              MobileAdjustment          getMobileAdjustment() 
 * @method              DesktopAdjustment         getDesktopAdjustment() 
 * @method              DemographicsAdjustments   getDemographicsAdjustments() 
 * @method              RetargetingAdjustments    getRetargetingAdjustments() 
 * @method              RegionalAdjustments       getRegionalAdjustments() 
 * @method              VideoAdjustment           getVideoAdjustment() 
 * @method              string                    getLevel() 
 * @method              string                    getType() 
 * 
 * @method              Result                    add() 
 * @method              Result                    delete() 
 * @method              QueryBuilder              query() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class BidModifier extends Model 
{ 
    protected $compatibleCollection = BidModifiers::class;

    protected $serviceProvidersMethods = [
        'add' => BidModifiersService::class,
        'delete' => BidModifiersService::class,
        'query' => BidModifiersService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'mobileAdjustment' => 'object:' . MobileAdjustment::class,
        'desktopAdjustment' => 'object:' . DesktopAdjustment::class,
        'demographicsAdjustments' => 'object:' . DemographicsAdjustments::class,
        'retargetingAdjustments' => 'object:' . RetargetingAdjustments::class,
        'regionalAdjustments' => 'object:' . RegionalAdjustments::class,
        'videoAdjustment' => 'object:' . VideoAdjustment::class,
        'level' => 'string',
        'type' => 'string'
    ];

    protected $nonWritableProperties = [
        'level',
        'type'
    ];

    protected $nonAddableProperties = [
        'id'
    ];
}