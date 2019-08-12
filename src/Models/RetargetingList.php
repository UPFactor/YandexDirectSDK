<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\RetargetingListRules;
use YandexDirectSDK\Collections\RetargetingLists;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Services\RetargetingListsService;

/** 
 * Class RetargetingList 
 * 
 * @property          integer                                   $id
 * @property          string                                    $type
 * @property          string                                    $name
 * @property          string                                    $description
 * @property-read     string                                    $isAvailable
 * @property          RetargetingListRules                      $rules
 * @property-read     string                                    $scope
 *                                                              
 * @method static     QueryBuilder                              query()
 * @method static     RetargetingList|RetargetingLists|null     find(integer|integer[]|RetargetingList|RetargetingLists|ModelCommonInterface $ids, string[] $fields)
 * @method            Result                                    add()
 * @method            Result                                    delete()
 * @method            Result                                    update()
 * @method            $this                                     setId(integer $id)
 * @method            integer                                   getId()
 * @method            $this                                     setType(string $type)
 * @method            string                                    getType()
 * @method            $this                                     setName(string $name)
 * @method            string                                    getName()
 * @method            $this                                     setDescription(string $description)
 * @method            string                                    getDescription()
 * @method            string                                    getIsAvailable()
 * @method            $this                                     setRules(RetargetingListRules $rules)
 * @method            RetargetingListRules                      getRules()
 * @method            string                                    getScope()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class RetargetingList extends Model 
{
    const RETARGETING = 'RETARGETING';
    const AUDIENCE = 'AUDIENCE';

    protected static $compatibleCollection = RetargetingLists::class;

    protected static $staticMethods = [
        'query' => RetargetingListsService::class,
        'find' => RetargetingListsService::class
    ];

    protected static $methods = [
        'add' => RetargetingListsService::class,
        'delete' => RetargetingListsService::class,
        'update' => RetargetingListsService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'type' => 'enum:' . self::RETARGETING . ',' . self::AUDIENCE,
        'name' => 'string',
        'description' => 'string',
        'isAvailable' => 'string',
        'rules' => 'object:' .  RetargetingListRules::class,
        'scope' => 'string'
    ];

    protected static $nonUpdatableProperties = [
        'type'
    ];

    protected static $nonWritableProperties = [
        'isAvailable',
        'scope'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}