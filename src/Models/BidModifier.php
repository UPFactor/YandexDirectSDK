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
 * 
 * @property-readable   string                   $level
 * @property-readable   string                   $type
 * 
 * @method              Result                   add()
 * @method              Result                   set(int $value = null)
 * @method              Result                   delete()
 * @method              QueryBuilder             query()
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
 * @package YandexDirectSDK\Models 
 */ 
class BidModifier extends Model 
{ 
    protected static $compatibleCollection = BidModifiers::class;

    protected static $serviceMethods = [
        'add' => BidModifiersService::class,
        'set' => BidModifiersService::class,
        'delete' => BidModifiersService::class,
        'query' => BidModifiersService::class
    ];

    protected static $properties = [
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

    protected static $nonWritableProperties = [
        'level',
        'type'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}