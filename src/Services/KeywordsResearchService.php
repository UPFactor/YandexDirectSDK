<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Collections\Keywords;
use UPTools\Arr;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Models\Keyword;

/** 
 * Class KeywordsResearchService 
 * 
 * @package YandexDirectSDK\Services 
 */
class KeywordsResearchService extends Service
{
    const MERGE_DUPLICATES = 'MERGE_DUPLICATES';
    const ELIMINATE_OVERLAPPING = 'ELIMINATE_OVERLAPPING';

    protected static $name = 'keywordsresearch';

    protected static $modelClass;

    protected static $modelCollectionClass;

    protected static $methods = [];

    /**
     * Pre-processing of keywords.
     * Available operations: MERGE_DUPLICATES, ELIMINATE_OVERLAPPING
     *
     * @param array|string[]|Keyword[]|Keywords $keywords
     * @param string ...$operation
     * @return Result
     */
    public static function deduplicate($keywords, ...$operation)
    {
        $params = [];

        if (is_array($keywords)){
            foreach ($keywords as $keyword){
                if(is_string($keyword)){
                    $params['Keywords'][] = ['Keyword' => $keyword];
                } elseif (is_array($keyword)){
                    $params['Keywords'][] = Arr::only($keyword, ['Id','Keyword','Weight']);
                } elseif ($keyword instanceof Keyword){
                    $params['Keywords'][] = Arr::only($keyword->toArray(), ['Id','Keyword']);
                } else {
                    throw InvalidArgumentException::invalidType(static::class . "::deduplicate", 1, "array|string[]|".Keyword::class."[]|".Keywords::class);
                }
            }
        } elseif ($keywords instanceof Keywords){
            foreach ($keywords->toArray() as $keyword){
                $params['Keywords'][] = Arr::only($keyword, ['Id','Keyword']);
            }
        } else {
            throw InvalidArgumentException::invalidType(static::class . "::deduplicate", 1, "array|string[]|".Keyword::class."[]|".Keywords::class);
        }

        if (empty($operation)){
            $params['Operation'] = [self::MERGE_DUPLICATES, self::ELIMINATE_OVERLAPPING];
        } else {
            $params['Operation'] = $operation;
        }

        return static::call('deduplicate', $params);
    }

    /**
     * Get a preliminary forecast of the availability of impressions
     * for given keywords by type of device.
     *
     * @param string|string[] $fields
     * @param string[]|Keyword[]|Keywords $keywords
     * @param string|string[] $regionIds
     * @return Result
     */
    public static function hasSearchVolume($fields, $keywords, $regionIds)
    {
        $params = [
            'SelectionCriteria' => [
                'Keywords' => [],
                'RegionIds' => Arr::wrap($regionIds)
            ],
            'FieldNames' => Arr::wrap($fields)
        ];

        if (is_array($keywords)){
            foreach ($keywords as $keyword){
                if(is_string($keyword)){
                    $params['SelectionCriteria']['Keywords'][] = $keyword;
                } elseif ($keyword instanceof Keyword){
                    $params['SelectionCriteria']['Keywords'][] = $keyword->getKeyword();
                } else {
                    throw InvalidArgumentException::invalidType(static::class . "::hasSearchVolume", 2, "array|string[]|".Keyword::class."[]|".Keywords::class);
                }
            }
        } elseif ($keywords instanceof Keywords){
            $params['SelectionCriteria']['Keywords'][] = array_values($keywords->extract('keyword'));
        } else {
            throw InvalidArgumentException::invalidType(static::class . "::hasSearchVolume", 2, "array|string[]|".Keyword::class."[]|".Keywords::class);
        }

        return static::call('hasSearchVolume', $params);
    }
}