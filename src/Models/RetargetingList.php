<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\RetargetingListRules;
use YandexDirectSDK\Collections\RetargetingLists;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\RetargetingListsService;

/** 
 * Class RetargetingList 
 * 
 * @property            integer                $id
 * @property            string                 $type
 * @property            string                 $name
 * @property            string                 $description
 * @property            RetargetingListRules   $rules
 * 
 * @property-readable   string                 $isAvailable
 * @property-readable   string                 $scope
 * 
 * @method              Result                 add()
 * @method              Result                 delete()
 * @method              QueryBuilder           query()
 * @method              Result                 update()
 * 
 * @method              $this                  setId(integer $id)
 * @method              $this                  setType(string $type)
 * @method              $this                  setName(string $name)
 * @method              $this                  setDescription(string $description)
 * @method              $this                  setRules(RetargetingListRules $rules)
 * 
 * @method              integer                getId()
 * @method              string                 getType()
 * @method              string                 getName()
 * @method              string                 getDescription()
 * @method              string                 getIsAvailable()
 * @method              RetargetingListRules   getRules()
 * @method              string                 getScope()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class RetargetingList extends Model 
{
    const RETARGETING = 'RETARGETING';
    const AUDIENCE = 'AUDIENCE';

    protected $compatibleCollection = RetargetingLists::class;

    protected $serviceProvidersMethods = [
        'add' => RetargetingListsService::class,
        'delete' => RetargetingListsService::class,
        'query' => RetargetingListsService::class,
        'update' => RetargetingListsService::class
    ];

    protected $properties = [
        'id' => 'integer',
        'type' => 'enum:' . self::RETARGETING . ',' . self::AUDIENCE,
        'name' => 'string',
        'description' => 'string',
        'isAvailable' => 'string',
        'rules' => 'object:' .  RetargetingListRules::class,
        'scope' => 'string'
    ];

    protected $nonUpdatableProperties = [
        'type'
    ];

    protected $nonWritableProperties = [
        'isAvailable',
        'scope'
    ];

    protected $nonAddableProperties = [
        'id'
    ];
}