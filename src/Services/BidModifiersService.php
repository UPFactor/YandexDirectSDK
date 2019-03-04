<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Models\BidModifier;

/** 
 * Class BidModifiersService 
 * 
 * @method   Result         add(ModelCommon $bidModifiers) 
 * @method   Result         delete(ModelCommon|integer[]|integer $bidModifiers) 
 * @method   QueryBuilder   query() 
 * @method   Result         set(ModelCommon $bidModifiers) 
 * @method   Result         toggle(ModelCommon $bidModifiers) 
 * 
 * @package YandexDirectSDK\Services 
 */
class BidModifiersService extends Service
{
    protected $serviceName = 'bidmodifiers';

    protected $serviceModelClass = BidModifier::class;

    protected $serviceModelCollectionClass = BidModifiers::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'delete' => 'delete:actionByIds',
        'query' => 'get:selectionElements',
        'set' => 'set:updateCollection',
        'toggle' => 'toggle:updateCollection'
    ];
}