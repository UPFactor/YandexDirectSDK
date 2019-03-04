<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Models\BidModifier;

/** 
 * Class BidModifiersService 
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