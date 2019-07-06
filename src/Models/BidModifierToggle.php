<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Components\Model;

/** 
 * Class BidModifierToggle 
 * 
 * @property          integer   $campaignId
 * @property          integer   $adGroupId
 * @property          string    $type
 * @property          string    $enabled
 * 
 * @method            $this     setCampaignId(integer $campaignId)
 * @method            $this     setAdGroupId(integer $adGroupId)
 * @method            $this     setType(string $type)
 * @method            $this     setEnabled(string $enabled)
 * 
 * @method            integer   getCampaignId()
 * @method            integer   getAdGroupId()
 * @method            string    getType()
 * @method            string    getEnabled()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class BidModifierToggle extends Model 
{ 
    const DEMOGRAPHICS_ADJUSTMENT = 'DEMOGRAPHICS_ADJUSTMENT';
    const RETARGETING_ADJUSTMENT = 'RETARGETING_ADJUSTMENT';
    const REGIONAL_ADJUSTMENT = 'REGIONAL_ADJUSTMENT';
    const YES = 'YES';
    const NO = 'NO';

    protected static $compatibleCollection = BidModifierToggles::class;

    protected static $properties = [
        'campaignId' => 'integer',
        'adGroupId' => 'integer',
        'type' => 'enum:' . self::DEMOGRAPHICS_ADJUSTMENT . ',' . self::RETARGETING_ADJUSTMENT . ',' . self::REGIONAL_ADJUSTMENT,
        'enabled' => 'enum:' . self::YES . ',' . self::NO
    ];
}