<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\VCards;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Services\VCardsService;

/** 
 * Class VCard 
 * 
 * @property          integer               $id
 * @property          integer               $campaignId
 * @property          string                $country
 * @property          string                $city
 * @property          string                $companyName
 * @property          string                $workTime
 * @property          Phone                 $phone
 * @property          string                $street
 * @property          string                $house
 * @property          string                $building
 * @property          string                $apartment
 * @property          InstantMessenger      $instantMessenger
 * @property          string                $extraMessage
 * @property          string                $contactEmail
 * @property          string                $ogrn
 * @property          integer               $metroStationId
 * @property          MapPoint              $pointOnMap
 * @property          string                $contactPerson
 *                                          
 * @method static     QueryBuilder          query()
 * @method static     VCard|VCards|null     find(integer|integer[]|VCard|VCards|ModelCommonInterface $ids, string[] $fields)
 * @method            Result                add()
 * @method            Result                delete()
 * @method            $this                 setId(integer $id)
 * @method            integer               getId()
 * @method            $this                 setCampaignId(integer $campaignId)
 * @method            integer               getCampaignId()
 * @method            $this                 setCountry(string $country)
 * @method            string                getCountry()
 * @method            $this                 setCity(string $city)
 * @method            string                getCity()
 * @method            $this                 setCompanyName(string $companyName)
 * @method            string                getCompanyName()
 * @method            $this                 setWorkTime(string $workTime)
 * @method            string                getWorkTime()
 * @method            $this                 setPhone(Phone $phone)
 * @method            Phone                 getPhone()
 * @method            $this                 setStreet(string $street)
 * @method            string                getStreet()
 * @method            $this                 setHouse(string $house)
 * @method            string                getHouse()
 * @method            $this                 setBuilding(string $building)
 * @method            string                getBuilding()
 * @method            $this                 setApartment(string $apartment)
 * @method            string                getApartment()
 * @method            $this                 setInstantMessenger(InstantMessenger $instantMessenger)
 * @method            InstantMessenger      getInstantMessenger()
 * @method            $this                 setExtraMessage(string $extraMessage)
 * @method            string                getExtraMessage()
 * @method            $this                 setContactEmail(string $contactEmail)
 * @method            string                getContactEmail()
 * @method            $this                 setOgrn(string $ogrn)
 * @method            string                getOgrn()
 * @method            $this                 setMetroStationId(integer $metroStationId)
 * @method            integer               getMetroStationId()
 * @method            $this                 setPointOnMap(MapPoint $pointOnMap)
 * @method            MapPoint              getPointOnMap()
 * @method            $this                 setContactPerson(string $contactPerson)
 * @method            string                getContactPerson()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class VCard extends Model 
{ 
    protected static $compatibleCollection = VCards::class;

    protected static $staticMethods = [
        'query' => VCardsService::class,
        'find' => VCardsService::class
    ];

    protected static $methods = [
        'add' => VCardsService::class,
        'delete' => VCardsService::class
    ];

    protected static $properties = [
        'id' => 'integer',
        'campaignId' => 'integer',
        'country' => 'string',
        'city' => 'string',
        'companyName' => 'string',
        'workTime' => 'string',
        'phone' => 'object:' . Phone::class,
        'street' => 'string',
        'house' => 'string',
        'building' => 'string',
        'apartment' => 'string',
        'instantMessenger' => 'object:' . InstantMessenger::class,
        'extraMessage' => 'string',
        'contactEmail' => 'string',
        'ogrn' => 'string',
        'metroStationId' => 'integer',
        'pointOnMap' => 'object:' . MapPoint::class,
        'contactPerson' => 'string'
    ];

    protected static $nonAddableProperties = [
        'id'
    ];
}