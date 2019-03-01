<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class Sitelink 
 * 
 * @property   string   $title 
 * @property   string   $href 
 * @property   string   $description 
 * 
 * @method     $this    setTitle(string $title) 
 * @method     $this    setHref(string $href) 
 * @method     $this    setDescription(string $description) 
 * 
 * @method     string   getTitle() 
 * @method     string   getHref() 
 * @method     string   getDescription() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Sitelink extends Model 
{ 
    protected $compatibleCollection; 

    protected $serviceProvidersMethods = []; 

    protected $properties = [
        'title' => 'string',
        'href' => 'string',
        'description' => 'string'
    ];

    protected $nonWritableProperties = []; 

    protected $nonReadableProperties = []; 

    protected $requiredProperties = [
        'title',
        'href'
    ];
}