<?php

namespace YandexDirectSDK\Services;

use Exception;
use DateTime;
use DateTimeZone;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Exceptions\RuntimeException;

/** 
 * Class ChangesService 
 * 
 * @package YandexDirectSDK\Services 
 */
class ChangesService extends Service
{
    protected static $name = 'changes';

    protected static $modelClass;

    protected static $modelCollectionClass;

    protected static $methods = [];

    /**
     * @param null $timestamp
     * @return string
     */
    protected static function timestampConverting($timestamp = null):string
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
     */
    public static function getTimestamp():Data
    {
        return static::call('checkDictionaries', (object)[])->data->get('Timestamp');
    }

    /**
     * Check for changes in the directories of the regions and time zones.
     *
     * @param $timestamp
     * @return Data
     */
    public static function checkDictionaries($timestamp):Data
    {
        return static::call('checkDictionaries', ['Timestamp' => static::timestampConverting($timestamp)])->data;
    }

    /**
     * Check for changes in all client campaigns.
     *
     * @param $timestamp
     * @return Data
     */
    public static function checkCampaigns($timestamp):Data
    {
        return static::call('checkCampaigns', ['Timestamp' => static::timestampConverting($timestamp)])->data;
    }

    /**
     * Check the changes in the specified client campaigns.
     *
     * @param $timestamp
     * @param integer|integer[] $campaignIds
     * @param string[]|null $fieldNames
     * @return Data
     */
    public static function checkCampaign($timestamp, $campaignIds, array $fieldNames = null):Data
    {
        return static::call('check', [
            'Timestamp' => static::timestampConverting($timestamp),
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
     */
    public static function checkAdGroup($timestamp, $adGroupIds, $fieldNames = null):Data
    {
        return static::call('check', [
            'Timestamp' => static::timestampConverting($timestamp),
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
     */
    public static function checkAd($timestamp, $adIds, $fieldNames = null):Data
    {
        return static::call('check', [
            'Timestamp' => static::timestampConverting($timestamp),
            'AdIds' => is_array($adIds) ? $adIds : [$adIds],
            'FieldNames' => is_null($fieldNames) ? ['CampaignIds','CampaignsStat','AdGroupIds','AdIds'] : $fieldNames
        ])->data;
    }
}