<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class CampaignAssistant 
 * 
 * @property-read   string   $manager 
 * @property-read   string   $agency 
 * 
 * @method          string   getManager() 
 * @method          string   getAgency() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CampaignAssistant extends Model 
{ 
    protected $properties = [
        'manager' => 'string',
        'agency' => 'string'
    ];
}