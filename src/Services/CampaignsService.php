<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Models\Campaign;

/** 
 * Class CampaignsService 
 * 
 * @method   Result         add(ModelCommon $campaigns) 
 * @method   QueryBuilder   query() 
 * @method   Result         update(ModelCommon $campaigns) 
 * @method   Result         archive(ModelCommon|integer[]|integer $campaigns) 
 * @method   Result         delete(ModelCommon|integer[]|integer $campaigns) 
 * @method   Result         resume(ModelCommon|integer[]|integer $campaigns) 
 * @method   Result         suspend(ModelCommon|integer[]|integer $campaigns) 
 * @method   Result         unarchive(ModelCommon|integer[]|integer $campaigns) 
 * 
 * @package YandexDirectSDK\Services 
 */
class CampaignsService extends Service
{
    protected $serviceName = 'campaigns';

    protected $serviceModelClass = Campaign::class;

    protected $serviceModelCollectionClass = Campaigns::class;

    protected $serviceMethods = [
        'add' => 'add:addCollection',
        'query' => 'get:selectionElements',
        'update' => 'update:updateCollection',
        'archive' => 'archive:actionByIds',
        'delete' => 'delete:actionByIds',
        'resume' => 'resume:actionByIds',
        'suspend' => 'suspend:actionByIds',
        'unarchive' => 'unarchive:actionByIds'
    ];
}