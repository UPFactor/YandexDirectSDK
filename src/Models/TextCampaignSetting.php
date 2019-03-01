<?php

namespace YandexDirectSDK\Models;

use YandexDirectSDK\Components\Model;

/** 
 * Class TextCampaignSetting 
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
class TextCampaignSetting extends Model
{
    const ADD_METRICA_TAG = 'ADD_METRICA_TAG';
    const ADD_OPENSTAT_TAG = 'ADD_OPENSTAT_TAG';
    const ADD_TO_FAVORITES = 'ADD_TO_FAVORITES';
    const ENABLE_AREA_OF_INTEREST_TARGETING = 'ENABLE_AREA_OF_INTEREST_TARGETING';
    const ENABLE_COMPANY_INFO = 'ENABLE_COMPANY_INFO';
    const ENABLE_EXTENDED_AD_TITLE = 'ENABLE_EXTENDED_AD_TITLE';
    const ENABLE_SITE_MONITORING = 'ENABLE_SITE_MONITORING';
    const EXCLUDE_PAUSED_COMPETING_ADS = 'EXCLUDE_PAUSED_COMPETING_ADS';
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
                    self::ADD_METRICA_TAG,
                    self::ADD_OPENSTAT_TAG,
                    self::ADD_TO_FAVORITES,
                    self::ENABLE_AREA_OF_INTEREST_TARGETING,
                    self::ENABLE_COMPANY_INFO,
                    self::ENABLE_EXTENDED_AD_TITLE,
                    self::ENABLE_SITE_MONITORING,
                    self::EXCLUDE_PAUSED_COMPETING_ADS,
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
     * Returns the [TextCampaignSetting] instance
     * with the [ADD_METRICA_TAG] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function addMetricaTag($switchOn = true){
        return (new static())
            ->setOption(self::ADD_METRICA_TAG)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [TextCampaignSetting] instance
     * with the [ADD_OPENSTAT_TAG] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function addOpenstatTag($switchOn = true){
        return (new static())
            ->setOption(self::ADD_OPENSTAT_TAG)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [TextCampaignSetting] instance
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
     * Returns the [TextCampaignSetting] instance
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
     * Returns the [TextCampaignSetting] instance
     * with the [ENABLE_COMPANY_INFO] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function enableCompanyInfo($switchOn = true){
        return (new static())
            ->setOption(self::ENABLE_COMPANY_INFO)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [TextCampaignSetting] instance
     * with the [ENABLE_EXTENDED_AD_TITLE] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function enableExtendedAdTitle($switchOn = true){
        return (new static())
            ->setOption(self::ENABLE_EXTENDED_AD_TITLE)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [TextCampaignSetting] instance
     * with the [ENABLE_SITE_MONITORING] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function enableSiteMonitoring($switchOn = true){
        return (new static())
            ->setOption(self::ENABLE_SITE_MONITORING)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [TextCampaignSetting] instance
     * with the [EXCLUDE_PAUSED_COMPETING_ADS] option set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function excludePausedCompetingAds($switchOn = true){
        return (new static())
            ->setOption(self::EXCLUDE_PAUSED_COMPETING_ADS)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [TextCampaignSetting] instance
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
     * Returns the [TextCampaignSetting] instance
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