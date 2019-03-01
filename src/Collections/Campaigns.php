<?php

namespace YandexDirectSDK\Collections;

use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\ModelCollection;
use YandexDirectSDK\Models\Campaign;
use YandexDirectSDK\Services\CampaignsService;

/** 
 * Class Campaigns 
 * 
 * @method   QueryBuilder   query() 
 * @method   Result         add() 
 * @method   Result         update() 
 * @method   Result         delete() 
 * @method   Result         suspend() 
 * @method   Result         resume() 
 * @method   Result         archive() 
 * @method   Result         unarchive() 
 * 
 * @package YandexDirectSDK\Collections 
 */
class Campaigns extends ModelCollection
{
    /**
     * @var Campaign[]
     */
    protected $items = [];

    protected $compatibleModel = Campaign::class;

    protected $serviceProvidersMethods = [
        'query' => CampaignsService::class,
        'add' => CampaignsService::class,
        'update' => CampaignsService::class,
        'delete' => CampaignsService::class,
        'suspend' => CampaignsService::class,
        'resume' => CampaignsService::class,
        'archive' => CampaignsService::class,
        'unarchive' => CampaignsService::class
    ];
}