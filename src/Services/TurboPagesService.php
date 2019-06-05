<?php 
namespace YandexDirectSDK\Services; 

use YandexDirectSDK\Collections\TurboPages;
use YandexDirectSDK\Components\Service; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\TurboPage;

/** 
 * Class TurboPagesService 
 * 
 * @method   QueryBuilder   query()
 * 
 * @package YandexDirectSDK\Services 
 */ 
class TurboPagesService extends Service 
{ 
    protected $serviceName = 'turbopages';

    protected $serviceModelClass = TurboPage::class;

    protected $serviceModelCollectionClass = TurboPages::class;

    protected $serviceMethods = [
        'query' => 'get:selectionElements'
    ];
}