<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class DemographicsAdjustment 
 * 
 * @property        string    $gender
 * @property        string    $age
 * @property        integer   $bidModifier
 * 
 * @property-read   string    $enabled
 * 
 * @method          $this     setGender(string $gender)
 * @method          $this     setAge(string $age)
 * @method          $this     setBidModifier(integer $bidModifier)
 * 
 * @method          string    getGender()
 * @method          string    getAge()
 * @method          integer   getBidModifier()
 * @method          string    getEnabled()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class DemographicsAdjustment extends Model 
{
    const GENDER_MALE = 'GENDER_MALE';
    const GENDER_FEMALE = 'GENDER_FEMALE';
    const AGE_0_17 = 'AGE_0_17';
    const AGE_18_24 = 'AGE_18_24';
    const AGE_25_34 = 'AGE_25_34';
    const AGE_35_44 = 'AGE_35_44';
    const AGE_45_54 = 'AGE_45_54';
    const AGE_55 = 'AGE_55';

    protected static $properties = [
        'gender' => 'enum:' . self::GENDER_MALE . ',' . self::GENDER_FEMALE,
        'age' => 'enum:' . self::AGE_0_17 . ',' . self::AGE_18_24 . ',' . self::AGE_25_34 . ',' . self::AGE_35_44 . ',' . self::AGE_45_54 . ',' . self::AGE_55,
        'bidModifier' => 'integer',
        'enabled' => 'string'
    ];

    protected static $nonWritableProperties = [
        'enabled'
    ];
}