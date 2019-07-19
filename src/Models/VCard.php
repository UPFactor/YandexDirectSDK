<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\VCards;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\Result; 
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Services\VCardsService;

/** 
 * Class VCard 
 * 
 * @property       integer            $id
 * @property       integer            $campaignId
 * @property       string             $country
 * @property       string             $city
 * @property       string             $companyName
 * @property       string             $workTime
 * @property       Phone              $phone
 * @property       string             $street
 * @property       string             $house
 * @property       string             $building
 * @property       string             $apartment
 * @property       InstantMessenger   $instantMessenger
 * @property       string             $extraMessage
 * @property       string             $contactEmail
 * @property       string             $ogrn
 * @property       integer            $metroStationId
 * @property       MapPoint           $pointOnMap
 * @property       string             $contactPerson
 * 
 * @method         QueryBuilder       query()
 * @method         Result             add()
 * @method         Result             delete()
 * 
 * @method         $this              setId(integer $id)
 * @method         $this              setCampaignId(integer $campaignId)
 * @method         $this              setCountry(string $country)
 * @method         $this              setCity(string $city)
 * @method         $this              setCompanyName(string $companyName)
 * @method         $this              setWorkTime(string $workTime)
 * @method         $this              setPhone(Phone $phone)
 * @method         $this              setStreet(string $street)
 * @method         $this              setHouse(string $house)
 * @method         $this              setBuilding(string $building)
 * @method         $this              setApartment(string $apartment)
 * @method         $this              setInstantMessenger(InstantMessenger $instantMessenger)
 * @method         $this              setExtraMessage(string $extraMessage)
 * @method         $this              setContactEmail(string $contactEmail)
 * @method         $this              setOgrn(string $ogrn)
 * @method         $this              setMetroStationId(integer $metroStationId)
 * @method         $this              setPointOnMap(MapPoint $pointOnMap)
 * @method         $this              setContactPerson(string $contactPerson)
 * 
 * @method         integer            getId()
 * @method         integer            getCampaignId()
 * @method         string             getCountry()
 * @method         string             getCity()
 * @method         string             getCompanyName()
 * @method         string             getWorkTime()
 * @method         Phone              getPhone()
 * @method         string             getStreet()
 * @method         string             getHouse()
 * @method         string             getBuilding()
 * @method         string             getApartment()
 * @method         InstantMessenger   getInstantMessenger()
 * @method         string             getExtraMessage()
 * @method         string             getContactEmail()
 * @method         string             getOgrn()
 * @method         integer            getMetroStationId()
 * @method         MapPoint           getPointOnMap()
 * @method         string             getContactPerson()
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