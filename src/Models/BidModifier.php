<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\BidModifiersService;

/** 
 * Class BidModifier 
 * 
 * @property            integer                  $id 
 * @property            integer                  $campaignId 
 * @property            integer                  $adGroupId 
 * @property            MobileAdjustment         $mobileAdjustment 
 * @property            DesktopAdjustment        $desktopAdjustment 
 * @property            DemographicsAdjustment   $demographicsAdjustment 
 * @property            RetargetingAdjustment    $retargetingAdjustment 
 * @property            RegionalAdjustment       $regionalAdjustment 
 * @property            VideoAdjustment          $videoAdjustment 
 * @property-readable   string                   $level 
 * @property-readable   string                   $type 
 * 
 * @method              $this                    setId(integer $id) 
 * @method              $this                    setCampaignId(integer $campaignId) 
 * @method              $this                    setAdGroupId(integer $adGroupId) 
 * @method              $this                    setMobileAdjustment(MobileAdjustment $mobileAdjustment) 
 * @method              $this                    setDesktopAdjustment(DesktopAdjustment $desktopAdjustment) 
 * @method              $this                    setDemographicsAdjustment(DemographicsAdjustment $demographicsAdjustment) 
 * @method              $this                    setRetargetingAdjustment(RetargetingAdjustment $retargetingAdjustment) 
 * @method              $this                    setRegionalAdjustment(RegionalAdjustment $regionalAdjustment) 
 * @method              $this                    setVideoAdjustment(VideoAdjustment $videoAdjustment) 
 * 
 * @method              integer                  getId() 
 * @method              integer                  getCampaignId() 
 * @method              integer                  getAdGroupId() 
 * @method              MobileAdjustment         getMobileAdjustment() 
 * @method              DesktopAdjustment        getDesktopAdjustment() 
 * @method              DemographicsAdjustment   getDemographicsAdjustment() 
 * @method              RetargetingAdjustment    getRetargetingAdjustment() 
 * @method              RegionalAdjustment       getRegionalAdjustment() 
 * @method              VideoAdjustment          getVideoAdjustment() 
 * @method              string                   getLevel() 
 * @method              string                   getType() 
 * 
 * @method              Result                   add() 
 * @method              Result                   set(int $value) 
 * @method              Result                   delete() 
 * @method              QueryBuilder             query() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class BidModifier extends Model 
{ 
    protected $compatibleCollection = BidModifiers::class;

    protected $serviceProvidersMethods = [
        'add' => BidModifiersService::class,
        'set' => BidModifiersService::class,
        'delete' => BidModifiersService::class,
        'query' => BidModifiersService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'mobileAdjustment' => 'object:' . MobileAdjustment::class,
        'desktopAdjustment' => 'object:' . DesktopAdjustment::class,
        'demographicsAdjustment' => 'object:' . DemographicsAdjustment::class,
        'retargetingAdjustment' => 'object:' . RetargetingAdjustment::class,
        'regionalAdjustment' => 'object:' . RegionalAdjustment::class,
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