<?php 
namespace YandexDirectSDK\Collections; 

use YandexDirectSDK\Components\ModelCollection; 
use YandexDirectSDK\Models\SearchPrice; 

/** 
 * Class SearchPrices 
 * 
 * @package YandexDirectSDK\Collections 
 */ 
class SearchPrices extends ModelCollection 
{ 
    /** 
     * @var SearchPrice[] 
     */ 
    protected $items = []; 

    /** 
     * @var SearchPrice[] 
     */ 
    protected $compatibleModel = SearchPrice::class;
}