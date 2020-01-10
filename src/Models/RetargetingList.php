<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\RetargetingListRules;
use YandexDirectSDK\Collections\RetargetingLists;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Models\Foundation\To;
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
 * @property-read     string[]                                  $availableForTargetsInAdGroupTypes
 *                                                              
 * @method static     QueryBuilder                              query()
 * @method static     RetargetingList|RetargetingLists|null     find(integer|integer[]|string|string[] $ids, string[] $fields=null)
 * @method            Result                                    create()
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
 * @method            $this                                     setRules(RetargetingListRules|array $rules)
 * @method            RetargetingListRules                      getRules()
 * @method            string                                    getScope()
 * @method            string[]                                  getAvailableForTargetsInAdGroupTypes()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class RetargetingList extends Model 
{
    use To;

    const RETARGETING = 'RETARGETING';
    const AUDIENCE = 'AUDIENCE';

    protected static $compatibleCollection = RetargetingLists::class;

    protected static $staticMethods = [
        'query' => RetargetingListsService::class,
        'find' => RetargetingListsService::class
    ];

    protected static $methods = [
        'create' => RetargetingListsService::class,
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
        'scope' => 'string',
        'availableForTargetsInAdGroupTypes' => 'arrayOfSet:TEXT_AD_GROUP,MOBILE_APP_AD_GROUP,DYNAMIC_TEXT_AD_GROUP,CPM_BANNER_AD_GROUP,CPM_VIDEO_AD_GROUP,CONTENT_PROMOTION_AD_GROUP,SMART_AD_GROUP'
    ];

    protected static $nonUpdatableProperties = [
        'type'
    ];

    protected static $nonWritableProperties = [
        'isAvailable',
        'scope',
        'availableForTargetsInAdGroupTypes'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}