<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\ClientSettings;
use YandexDirectSDK\Components\Model;

/** 
 * Class ClientSetting 
 * 
 * @property     string     $option
 * @property     string     $value
 *                          
 * @method       $this      setOption(string $option)
 * @method       string     getOption()
 * @method       $this      setValue(string $value)
 * @method       string     getValue()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class ClientSetting extends Model 
{
    const CORRECT_TYPOS_AUTOMATICALLY = 'CORRECT_TYPOS_AUTOMATICALLY';
    const DISPLAY_STORE_RATING = 'DISPLAY_STORE_RATING';
    const YES = 'YES';
    const NO = 'NO';

    protected static $compatibleCollection = ClientSettings::class;

    protected static $properties = [
        'option' => 'enum:' . self::CORRECT_TYPOS_AUTOMATICALLY . ',' . self::DISPLAY_STORE_RATING,
        'value' => 'enum:' . self::YES . ',' . self::NO
    ];

    /**
     * Returns the [ClientSetting] instance
     * with the [CORRECT_TYPOS_AUTOMATICALLY] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function correctTyposAutomatically($switchOn = true){
        return (new static())
            ->setOption(self::CORRECT_TYPOS_AUTOMATICALLY)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [ClientSetting] instance
     * with the [DISPLAY_STORE_RATING] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function displayStoreRating($switchOn = true){
        return (new static())
            ->setOption(self::DISPLAY_STORE_RATING)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }
}