<?php

namespace YandexDirectSDK\Services;

use DateTime;
use DateTimeZone;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Data;

/** 
 * Class ChangesService 
 * 
 * @package YandexDirectSDK\Services 
 */
class ChangesService extends Service
{
    protected $serviceName = 'changes';

    protected function timestampConverting($timestamp = null):string
    {
        return (new DateTime($timestamp))
            ->setTimezone(new DateTimeZone('UTC'))
            ->format('Y-m-d\TH:i:s\Z');
    }

    /**
     * @return Data
     */
    public function getTimestamp():Data
    {
        return $this->call('checkDictionaries', (object)[])->data->get('Timestamp');
    }

    /**
     * @param $timestamp
     * @return Data
     */
    public function checkDictionaries($timestamp):Data
    {
        return $this->call('checkDictionaries', ['Timestamp' => $this->timestampConverting($timestamp)])->data;
    }

    /**
     * @param $timestamp
     * @return Data
     */
    public function checkCampaigns($timestamp):Data
    {
        return $this->call('checkCampaigns', ['Timestamp' => $this->timestampConverting($timestamp)])->data;
    }

    /**
     * @param $timestamp
     * @param integer|integer[] $campaignIds
     * @param string[]|null $fieldNames
     * @return Data
     */
    public function checkCampaign($timestamp, $campaignIds, array $fieldNames = null):Data
    {
        return $this->call('check', [
            'Timestamp' => $this->timestampConverting($timestamp),
            'CampaignIds' => is_array($campaignIds) ? $campaignIds : [$campaignIds],
            'FieldNames' => is_null($fieldNames) ? ['CampaignIds','CampaignsStat','AdGroupIds','AdIds'] : $fieldNames
        ])->data;
    }

    /**
     * @param $timestamp
     * @param integer|integer[] $adGroupIds
     * @param string[]|null $fieldNames
     * @return Data
     */
    public function checkAdGroup($timestamp, $adGroupIds, $fieldNames = null):Data
    {
        return $this->call('check', [
            'Timestamp' => $this->timestampConverting($timestamp),
            'AdGroupIds' => is_array($adGroupIds) ? $adGroupIds : [$adGroupIds],
            'FieldNames' => is_null($fieldNames) ? ['CampaignIds','CampaignsStat','AdGroupIds','AdIds'] : $fieldNames
        ])->data;
    }

    /**
     * @param $timestamp
     * @param integer|integer[] $adIds
     * @param string[]|null $fieldNames
     * @return Data
     */
    public function checkAd($timestamp, $adIds, $fieldNames = null):Data
    {
        return $this->call('check', [
            'Timestamp' => $this->timestampConverting($timestamp),
            'AdIds' => is_array($adIds) ? $adIds : [$adIds],
            'FieldNames' => is_null($fieldNames) ? ['CampaignIds','CampaignsStat','AdGroupIds','AdIds'] : $fieldNames
        ])->data;
    }
}