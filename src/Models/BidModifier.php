<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Services\BidModifiersService;

/** 
 * Class BidModifier 
 * 
 * @property          integer                           $id
 * @property          integer                           $campaignId
 * @property          integer                           $adGroupId
 * @property          MobileAdjustment                  $mobileAdjustment
 * @property          DesktopAdjustment                 $desktopAdjustment
 * @property          DemographicsAdjustment            $demographicsAdjustment
 * @property          RetargetingAdjustment             $retargetingAdjustment
 * @property          RegionalAdjustment                $regionalAdjustment
 * @property          VideoAdjustment                   $videoAdjustment
 * @property-read     string                            $level
 * @property-read     string                            $type
 *                                                      
 * @method static     QueryBuilder                      query()
 * @method static     BidModifier|BidModifiers|null     find(integer|integer[]|BidModifier|BidModifiers|ModelCommonInterface $ids, string[] $fields)
 * @method            Result                            add()
 * @method            Result                            set(int $value=null)
 * @method            Result                            delete()
 * @method            $this                             setId(integer $id)
 * @method            integer                           getId()
 * @method            $this                             setCampaignId(integer $campaignId)
 * @method            integer                           getCampaignId()
 * @method            $this                             setAdGroupId(integer $adGroupId)
 * @method            integer                           getAdGroupId()
 * @method            $this                             setMobileAdjustment(MobileAdjustment $mobileAdjustment)
 * @method            MobileAdjustment                  getMobileAdjustment()
 * @method            $this                             setDesktopAdjustment(DesktopAdjustment $desktopAdjustment)
 * @method            DesktopAdjustment                 getDesktopAdjustment()
 * @method            $this                             setDemographicsAdjustment(DemographicsAdjustment $demographicsAdjustment)
 * @method            DemographicsAdjustment            getDemographicsAdjustment()
 * @method            $this                             setRetargetingAdjustment(RetargetingAdjustment $retargetingAdjustment)
 * @method            RetargetingAdjustment             getRetargetingAdjustment()
 * @method            $this                             setRegionalAdjustment(RegionalAdjustment $regionalAdjustment)
 * @method            RegionalAdjustment                getRegionalAdjustment()
 * @method            $this                             setVideoAdjustment(VideoAdjustment $videoAdjustment)
 * @method            VideoAdjustment                   getVideoAdjustment()
 * @method            string                            getLevel()
 * @method            string                            getType()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class BidModifier extends Model 
{ 
    protected static $compatibleCollection = BidModifiers::class;

    protected static $staticMethods = [
        'query' => BidModifiersService::class,
        'find' => BidModifiersService::class
    ];

    protected static $methods = [
        'add' => BidModifiersService::class,
        'set' => BidModifiersService::class,
        'delete' => BidModifiersService::class
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