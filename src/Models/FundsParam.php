<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class FundsParam 
 * 
 * @property-read   string                    $mode 
 * @property-read   CampaignFundsParam        $campaignFunds 
 * @property-read   SharedAccountFundsParam   $sharedAccountFunds 
 * 
 * @method          string                    getMode() 
 * @method          CampaignFundsParam        getCampaignFunds() 
 * @method          SharedAccountFundsParam   getSharedAccountFunds() 
 * 
 * @package YandexDirectSDK\Models 
 */
class FundsParam extends Model 
{ 
    protected $properties = [
        'mode' => 'string',
        'campaignFunds' => 'object:' . CampaignFundsParam::class,
        'sharedAccountFunds' => 'object:' . SharedAccountFundsParam::class
    ];

    protected $nonWritableProperties = [
        'mode',
        'campaignFunds',
        'sharedAccountFunds'
    ];
}