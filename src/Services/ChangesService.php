<?php

namespace YandexDirectSDK\Services;

use Exception;
use DateTime;
use DateTimeZone;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;

/** 
 * Class ChangesService 
 * 
 * @package YandexDirectSDK\Services 
 */
class ChangesService extends Service
{
    protected static $name = 'changes';

    /**
     * @param null $timestamp
     * @return string
     */
    protected function timestampConverting($timestamp = null):string
    {
        try {
            return (new DateTime($timestamp))
                ->setTimezone(new DateTimeZone('UTC'))
                ->format('Y-m-d\TH:i:s\Z');
        } catch (Exception $error) {
            throw RuntimeException::make(static::class."::timestampConverting. {$error->getMessage()}");
        }
    }

    /**
     * Getting the current service time.
     *
     * @return Data
     * @throws RuntimeException
     * @throws InvalidArgumentException
     * @throws RequestException
     */
    public function getTimestamp():Data
    {
        return $this->call('checkDictionaries', (object)[])->data->get('Timestamp');
    }

    /**
     * Check for changes in the directories of the regions and time zones.
     *
     * @param $timestamp
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function checkDictionaries($timestamp):Data
    {
        return $this->call('checkDictionaries', ['Timestamp' => $this->timestampConverting($timestamp)])->data;
    }

    /**
     * Check for changes in all client campaigns.
     *
     * @param $timestamp
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function checkCampaigns($timestamp):Data
    {
        return $this->call('checkCampaigns', ['Timestamp' => $this->timestampConverting($timestamp)])->data;
    }

    /**
     * Check the changes in the specified client campaigns.
     *
     * @param $timestamp
     * @param integer|integer[] $campaignIds
     * @param string[]|null $fieldNames
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
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
     * Check the changes in the specified client ad groups.
     *
     * @param $timestamp
     * @param integer|integer[] $adGroupIds
     * @param string[]|null $fieldNames
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
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
     * Check the changes in the specified client ads.
     *
     * @param $timestamp
     * @param integer|integer[] $adIds
     * @param string[]|null $fieldNames
     * @return Data
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
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