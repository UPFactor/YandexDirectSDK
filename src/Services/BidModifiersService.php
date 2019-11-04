<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\BidModifiers;
use YandexDirectSDK\Collections\BidModifierSets;
use YandexDirectSDK\Collections\BidModifierToggles;
use UPTools\Arr;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\QueryBuilder;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\BidModifier;
use YandexDirectSDK\Models\BidModifierSet;
use YandexDirectSDK\Models\BidModifierToggle;

/** 
 * Class BidModifiersService 
 * 
 * @method static     Result                            delete(integer|integer[]|BidModifier|BidModifiers|ModelCommonInterface $bidModifiers)
 * @method static     QueryBuilder                      query()
 * @method static     BidModifier|BidModifiers|null     find(integer|integer[]|string|string[] $ids, string[] $fields)
 * 
 * @package YandexDirectSDK\Services 
 */
class BidModifiersService extends Service
{
    protected static $name = 'bidmodifiers';

    protected static $modelClass = BidModifier::class;

    protected static $modelCollectionClass = BidModifiers::class;

    protected static $methods = [
        'delete' => 'delete:actionByIds',
        'query' => 'get:selectionElements',
        'find' => 'get:selectionByIds'
    ];

    /**
     * Creates bid modifiers.
     *
     * @param BidModifier|BidModifiers|ModelCommonInterface $bidModifiers
     * @return Result
     */
    public static function add(ModelCommonInterface $bidModifiers) : Result
    {
        //If the model is transferred, it must be converted to
        //the appropriate collection.

        if ($bidModifiers instanceof ModelInterface) {
            /** @var BidModifiers $class */
            $class = static::$modelCollectionClass;
            $bidModifiers = $class::make($bidModifiers);
        }

        //The final array to be sent to the API Yandex.Direct

        $arrBidModifiers = [];

        //An array indicating the positions of the original models in the final array.
        //It will be required to distribute the identifiers of the added conditions
        //to the original models after completing the request to the API, Yandex.direct.

        $assessor = [];

        //Conversion of the collection's source data into
        //Yandex.Direct format (array of BidModifierAddItem)

        foreach ($bidModifiers->toArray(Model::IS_ADDABLE) as $index => $item){

            if (empty($item)){
                $arrBidModifiers[$key = microtime()] = [];
                $assessor[$key][] = $index;
                continue;
            }

            //Generating key for grouping conditions
            $key = ($item['CampaignId'] ?? '_');
            $key.= ($item['AdGroupId'] ?? '_');
            $key.= isset($item['DemographicsAdjustment']) ? '1' : '_';
            $key.= isset($item['RetargetingAdjustment']) ? '1' : '_';
            $key.= isset($item['RegionalAdjustment']) ? '1' : '_';
            $key.= isset($item['MobileAdjustment']) ? '1' : '_';
            $key.= isset($item['DesktopAdjustment']) ? '1' : '_';
            $key.= isset($item['VideoAdjustment']) ? '1' : '_';


            if (count($item) !== 2 or (isset($item['CampaignId']) and isset($item['AdGroupId']))){
                $key .= microtime();
            }

            foreach ($item as $property => $value){

                if (in_array($property, ['CampaignId', 'AdGroupId'])){
                    $arrBidModifiers[$key][$property] = $value;
                    continue;
                }

                if (in_array($property, ['DemographicsAdjustment', 'RetargetingAdjustment', 'RegionalAdjustment'])){
                    $arrBidModifiers[$key][$property.'s'][] = $value;
                } else {
                    if (isset($arrBidModifiers[$key][$property]) and Arr::isAssoc($arrBidModifiers[$key][$property])){
                        $arrBidModifiers[$key][$property] = [
                            $arrBidModifiers[$key][$property],
                            $value
                        ];
                    } else {
                        $arrBidModifiers[$key][$property] = $value;
                    }
                }
            }

            $assessor[$key][] = $index;
        }

        $assessor = array_values($assessor);
        $arrBidModifiers = array_values($arrBidModifiers);

        //Request to API Yandex.Direct
        $result = static::call('add', [$bidModifiers::getClassName() => $arrBidModifiers]);
        $resultData = $result->data->all();
        $modelData = [];

        //The distribution of the identifiers of the received conditions by position.
        //This will be used to import identifiers into a collection of models.

        foreach ($assessor as $resultIndex => $modelsIndex){
            $ids = $resultData['AddResults'][$resultIndex]['Ids'] ?? [];

            if (!empty($ids)){
                foreach ($ids as $n => $value){
                    $modelData[$modelsIndex[$n]] = ['id' => $value];
                }
            }
        }

        return $result->setResource(
            $bidModifiers->insert($modelData)
        );
    }

    /**
     * Changes the values of coefficients in rate adjustments.
     *
     * @param int|int[]|string|string[]|BidModifier|BidModifiers|BidModifierSet|BidModifierSets|ModelCommonInterface $bidModifiers
     * @param int $value
     * @return Result
     */
    public static function set($bidModifiers, int $value = null): Result
    {
        //Converting BidModifier (BidModifiers) objects into
        //corresponding BidModifierSet (BidModifierSets) objects.

        if (!($bidModifiers instanceof BidModifierSet) and !($bidModifiers instanceof BidModifierSets)){
            $bidModifiers = static::bind(
                $bidModifiers,
                BidModifierSet::make()->setBidModifier($value),
                'Id'
            );
        }

        //Request to API Yandex.Direct

        return static::updateCollection(
            'set',
            $bidModifiers,
            'BidModifiers',
            'SetResults'
        );
    }

    /**
     * Enables/disables the set of adjustments.
     *
     * @param BidModifierToggle|BidModifierToggles|ModelCommonInterface $bidModifiers
     * @return Result
     */
    public static function toggle($bidModifiers): Result
    {
        return static::updateCollection(
            'toggle',
            $bidModifiers,
            'BidModifierToggleItems',
            'ToggleResults'
        );
    }
}