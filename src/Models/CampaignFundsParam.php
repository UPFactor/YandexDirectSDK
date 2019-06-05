<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class CampaignFundsParam 
 * 
 * @property-readable   integer   $sum
 * @property-readable   integer   $balance
 * @property-readable   integer   $balanceBonus
 * @property-readable   integer   $sumAvailableForTransfer
 * 
 * @method              integer   getSum()
 * @method              integer   getBalance()
 * @method              integer   getBalanceBonus()
 * @method              integer   getSumAvailableForTransfer()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CampaignFundsParam extends Model 
{ 
    protected $properties = [
        'sum' => 'integer',
        'balance' => 'integer',
        'balanceBonus' => 'integer',
        'sumAvailableForTransfer' => 'integer'
    ];

    protected $nonWritableProperties = [
        'sum',
        'balance',
        'balanceBonus',
        'sumAvailableForTransfer'
    ];
}