<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class CampaignAssistant 
 * 
 * @property       string   $manager
 * @property       string   $agency
 * 
 * @method         $this    setManager(string $manager)
 * @method         $this    setAgency(string $agency)
 * 
 * @method         string   getManager()
 * @method         string   getAgency()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class CampaignAssistant extends Model 
{ 
    protected static $properties = [
        'manager' => 'string',
        'agency' => 'string'
    ];
}