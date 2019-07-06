<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class FundsParam 
 * 
 * @property-readable   string                    $mode
 * @property-readable   CampaignFundsParam        $campaignFunds
 * @property-readable   SharedAccountFundsParam   $sharedAccountFunds
 * 
 * @method              string                    getMode()
 * @method              CampaignFundsParam        getCampaignFunds()
 * @method              SharedAccountFundsParam   getSharedAccountFunds()
 * 
 * @package YandexDirectSDK\Models 
 */
class FundsParam extends Model 
{ 
    protected static $properties = [
        'mode' => 'string',
        'campaignFunds' => 'object:' . CampaignFundsParam::class,
        'sharedAccountFunds' => 'object:' . SharedAccountFundsParam::class
    ];

    protected static $nonWritableProperties = [
        'mode',
        'campaignFunds',
        'sharedAccountFunds'
    ];
}