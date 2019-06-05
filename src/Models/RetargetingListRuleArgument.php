<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\RetargetingListRuleArguments;
use YandexDirectSDK\Components\Model;

/** 
 * Class RetargetingListRuleArgument 
 * 
 * @property          integer   $membershipLifeSpan
 * @property          integer   $externalId
 * 
 * @method            $this     setMembershipLifeSpan(integer $membershipLifeSpan)
 * @method            $this     setExternalId(integer $externalId)
 * 
 * @method            integer   getMembershipLifeSpan()
 * @method            integer   getExternalId()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class RetargetingListRuleArgument extends Model 
{ 
    protected $compatibleCollection = RetargetingListRuleArguments::class;

    protected $properties = [
        'membershipLifeSpan' => 'integer',
        'externalId' => 'integer'
    ];
}