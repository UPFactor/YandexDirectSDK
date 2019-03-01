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
    protected $serviceName = 'dictionaries';

    /**
     * @param string|string[] $names
     * @return Data
     */
    public function getDictionaries($names):Data
    {
        return $this->call('get', ['DictionaryNames' => (is_array($names) ? $names : [$names])])->data;
    }

    public function getCurrencies():Data
    {
        return $this->getDictionaries('Currencies')->get('Currencies');
    }

    public function getMetroStations():Data
    {
        return $this->getDictionaries('MetroStations')->get('MetroStations');
    }

    public function getGeoRegions():Data
    {
        return $this->getDictionaries('GeoRegions')->get('GeoRegions');
    }

    public function getTimeZones():Data
    {
        return $this->getDictionaries('TimeZones')->get('TimeZones');
    }

    public function getConstants():Data
    {
        return $this->getDictionaries('Constants')->get('Constants');
    }

    public function getAdCategories():Data
    {
        return $this->getDictionaries('AdCategories')->get('AdCategories');
    }

    public function getOperationSystemVersions():Data
    {
        return $this->getDictionaries('OperationSystemVersions')->get('OperationSystemVersions');
    }

    public function getProductivityAssertions():Data
    {
        return $this->getDictionaries('ProductivityAssertions')->get('ProductivityAssertions');
    }

    public function getSupplySidePlatforms():Data
    {
        return $this->getDictionaries('SupplySidePlatforms')->get('SupplySidePlatforms');
    }

    public function getInterests():Data
    {
        return $this->getDictionaries('Interests')->get('Interests');
    }

    public function getAudienceCriteriaTypes():Data
    {
        return $this->getDictionaries('AudienceCriteriaTypes')->get('AudienceCriteriaTypes');
    }

    public function getAudienceDemographicProfiles():Data
    {
        return $this->getDictionaries('AudienceDemographicProfiles')->get('AudienceDemographicProfiles');
    }

    public function getAudienceInterests():Data
    {
        return $this->getDictionaries('AudienceInterests')->get('AudienceInterests');
    }
}