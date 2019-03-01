<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model as Model; 

/** 
 * Class MobileAppCampaignSetting 
 * 
 * @property   string   $option 
 * @property   string   $value 
 * 
 * @method     $this    setOption(string $option) 
 * @method     $this    setValue(string $value) 
 * 
 * @method     string   getOption() 
 * @method     string   getValue() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MobileAppCampaignSetting extends Model 
{
    const ADD_TO_FAVORITES = 'ADD_TO_FAVORITES';
    const ENABLE_AREA_OF_INTEREST_TARGETING = 'ENABLE_AREA_OF_INTEREST_TARGETING';
    const MAINTAIN_NETWORK_CPC = 'MAINTAIN_NETWORK_CPC';
    const REQUIRE_SERVICING = 'REQUIRE_SERVICING';
    const YES = 'YES';
    const NO = 'NO';

    protected $properties = [];

    protected $nonWritableProperties = [];

    protected $nonReadableProperties = [];

    protected $requiredProperties = [
        'option',
        'value'
    ];

    protected function initialize(...$arguments)
    {
        $this->properties = [
            'option' => 'enum:' . implode(',',[
                    self::ADD_TO_FAVORITES,
                    self::ENABLE_AREA_OF_INTEREST_TARGETING,
                    self::MAINTAIN_NETWORK_CPC,
                    self::REQUIRE_SERVICING
                ]),
            'value' => 'enum:' . implode(',',[
                    self::YES,
                    self::NO
                ])
        ];
    }

    /**
     * Returns the [MobileAppCampaignSetting] instance
     * with the [ADD_TO_FAVORITES] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function addToFavorites($switchOn = true){
        return (new static())
            ->setOption(self::ADD_TO_FAVORITES)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [MobileAppCampaignSetting] instance
     * with the [ENABLE_AREA_OF_INTEREST_TARGETING] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function enableAreaOfInterestTargeting($switchOn = true){
        return (new static())
            ->setOption(self::ENABLE_AREA_OF_INTEREST_TARGETING)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [MobileAppCampaignSetting] instance
     * with the [MAINTAIN_NETWORK_CPC] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function maintainNetworkCpc($switchOn = true){
        return (new static())
            ->setOption(self::MAINTAIN_NETWORK_CPC)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [MobileAppCampaignSetting] instance
     * with the [REQUIRE_SERVICING] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function requireServicing($switchOn = true){
        return (new static())
            ->setOption(self::REQUIRE_SERVICING)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }
}