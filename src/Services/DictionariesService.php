<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;

/** 
 * Class DictionariesService 
 * 
 * @package YandexDirectSDK\Services 
 */
class DictionariesService extends Service
{
    protected $serviceName = 'dictionaries';

    /**
     * @param string|string[] $names
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getDictionaries($names):Data
    {
        return $this->call('get', ['DictionaryNames' => (is_array($names) ? $names : [$names])])->data;
    }

    /**
     * Retrieve a list of exchange rates, currency options and restrictions.
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getCurrencies():Data
    {
        return $this->getDictionaries('Currencies')->get('Currencies');
    }

    /**
     * Retrieve a list of metro stations.
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getMetroStations():Data
    {
        return $this->getDictionaries('MetroStations')->get('MetroStations');
    }

    /**
     * Retrieve a list of regions.
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getGeoRegions():Data
    {
        return $this->getDictionaries('GeoRegions')->get('GeoRegions');
    }

    /**
     * Retrieve a list of time zones.
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getTimeZones():Data
    {
        return $this->getDictionaries('TimeZones')->get('TimeZones');
    }

    /**
     * Retrieve a list of constance.
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getConstants():Data
    {
        return $this->getDictionaries('Constants')->get('Constants');
    }

    /**
     * Retrieve a list of specific categories of advertised goods and services.
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getAdCategories():Data
    {
        return $this->getDictionaries('AdCategories')->get('AdCategories');
    }

    /**
     * Retrieve a list of operation system versions.
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getOperationSystemVersions():Data
    {
        return $this->getDictionaries('OperationSystemVersions')->get('OperationSystemVersions');
    }

    /**
     * Retrieve a list of external networks (SSP).
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getSupplySidePlatforms():Data
    {
        return $this->getDictionaries('SupplySidePlatforms')->get('SupplySidePlatforms');
    }

    /**
     * Retrieve a list of interest to the categories of mobile applications.
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getInterests():Data
    {
        return $this->getDictionaries('Interests')->get('Interests');
    }

    /**
     * Retrieve a list of socio-demographic characteristics and behavioral signs.
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getAudienceCriteriaTypes():Data
    {
        return $this->getDictionaries('AudienceCriteriaTypes')->get('AudienceCriteriaTypes');
    }

    /**
     * Retrieve a list of segments by socio-demographic characteristics and
     * behavioral signs for targeting by user profile.
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getAudienceDemographicProfiles():Data
    {
        return $this->getDictionaries('AudienceDemographicProfiles')->get('AudienceDemographicProfiles');
    }

    /**
     * Retrieve a list of user interest segments for targeting by user profile
     *
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getAudienceInterests():Data
    {
        return $this->getDictionaries('AudienceInterests')->get('AudienceInterests');
    }
}