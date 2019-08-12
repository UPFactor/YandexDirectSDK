<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Data;

/** 
 * Class DictionariesService 
 * 
 * @package YandexDirectSDK\Services 
 */
class DictionariesService extends Service
{
    protected static $name = 'dictionaries';

    protected static $modelClass;

    protected static $modelCollectionClass;

    protected static $methods = [];

    /**
     * @param string|string[] $names
     * @return Data
     */
    public static function getDictionaries($names):Data
    {
        return static::call('get', ['DictionaryNames' => (is_array($names) ? $names : [$names])])->data;
    }

    /**
     * Retrieve a list of exchange rates, currency options and restrictions.
     *
     * @return Data
     */
    public static function getCurrencies():Data
    {
        return static::getDictionaries('Currencies')->get('Currencies');
    }

    /**
     * Retrieve a list of metro stations.
     *
     * @return Data
     */
    public static function getMetroStations():Data
    {
        return static::getDictionaries('MetroStations')->get('MetroStations');
    }

    /**
     * Retrieve a list of regions.
     *
     * @return Data
     */
    public static function getGeoRegions():Data
    {
        return static::getDictionaries('GeoRegions')->get('GeoRegions');
    }

    /**
     * Retrieve a list of time zones.
     *
     * @return Data
     */
    public static function getTimeZones():Data
    {
        return static::getDictionaries('TimeZones')->get('TimeZones');
    }

    /**
     * Retrieve a list of constance.
     *
     * @return Data
     */
    public static function getConstants():Data
    {
        return static::getDictionaries('Constants')->get('Constants');
    }

    /**
     * Retrieve a list of specific categories of advertised goods and services.
     *
     * @return Data
     */
    public static function getAdCategories():Data
    {
        return static::getDictionaries('AdCategories')->get('AdCategories');
    }

    /**
     * Retrieve a list of operation system versions.
     *
     * @return Data
     */
    public static function getOperationSystemVersions():Data
    {
        return static::getDictionaries('OperationSystemVersions')->get('OperationSystemVersions');
    }

    /**
     * Retrieve a list of external networks (SSP).
     *
     * @return Data
     */
    public static function getSupplySidePlatforms():Data
    {
        return static::getDictionaries('SupplySidePlatforms')->get('SupplySidePlatforms');
    }

    /**
     * Retrieve a list of interest to the categories of mobile applications.
     *
     * @return Data
     */
    public static function getInterests():Data
    {
        return static::getDictionaries('Interests')->get('Interests');
    }

    /**
     * Retrieve a list of socio-demographic characteristics and behavioral signs.
     *
     * @return Data
     */
    public static function getAudienceCriteriaTypes():Data
    {
        return static::getDictionaries('AudienceCriteriaTypes')->get('AudienceCriteriaTypes');
    }

    /**
     * Retrieve a list of segments by socio-demographic characteristics and
     * behavioral signs for targeting by user profile.
     *
     * @return Data
     */
    public static function getAudienceDemographicProfiles():Data
    {
        return static::getDictionaries('AudienceDemographicProfiles')->get('AudienceDemographicProfiles');
    }

    /**
     * Retrieve a list of user interest segments for targeting by user profile
     *
     * @return Data
     */
    public static function getAudienceInterests():Data
    {
        return static::getDictionaries('AudienceInterests')->get('AudienceInterests');
    }
}