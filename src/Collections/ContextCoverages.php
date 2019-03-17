<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\ContextCoverage; 

/** 
 * Class ContextCoverages 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class ContextCoverages extends ModelCollection 
{ 
    /** 
     * @var ContextCoverage[] 
     */ 
    protected $items = []; 

    /** 
     * @var ContextCoverage[] 
     */ 
    protected $compatibleModel = ContextCoverage::class;
}