<?php

namespace YandexDirectSDK\Services;

use InvalidArgumentException;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Components\Service;
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

    protected $serviceName = 'keywordsresearch';

    protected $serviceModelClass;

    protected $serviceModelCollectionClass;

    protected $serviceMethods = [];

    /**
     * @param array|string[]|Keyword[]|Keywords $keywords
     * @param string ...$operation
     * @return Result
     */
    public function deduplicate($keywords, ...$operation)
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
                    throw new InvalidArgumentException(static::class.". Failed method [deduplicate]. Invalid keywords type. Expected [array|string[]|".Keyword::class."[]|".Keywords::class."].");
                }
            }
        } elseif ($keywords instanceof Keywords){
            foreach ($keywords->toArray() as $keyword){
                $params['Keywords'][] = Arr::only($keyword, ['Id','Keyword']);
            }
        } else {
            throw new InvalidArgumentException(static::class.". Failed method [deduplicate]. Invalid keywords type. Expected [array|string[]|".Keyword::class."[]|".Keywords::class."].");
        }

        if (empty($operation)){
            $params['Operation'] = [self::MERGE_DUPLICATES, self::ELIMINATE_OVERLAPPING];
        } else {
            $params['Operation'] = $operation;
        }

        return $this->call('deduplicate', $params);
    }

    /**
     * @param string|string[] $fields
     * @param string[]|Keyword[]|Keywords $keywords
     * @param string|string[] $regionIds
     * @return Result
     */
    public function hasSearchVolume($fields, $keywords, $regionIds)
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
                    throw new InvalidArgumentException(static::class.". Failed method [hasSearchVolume]. Invalid keywords type. Expected [string[]|".Keyword::class."[]|".Keywords::class."].");
                }
            }
        } elseif ($keywords instanceof Keywords){
            $params['SelectionCriteria']['Keywords'][] = $keywords->pluck('keyword');
        } else {
            throw new InvalidArgumentException(static::class.". Failed method [hasSearchVolume]. Invalid keywords type. Expected [string[]|".Keyword::class."[]|".Keywords::class."].");
        }

        return $this->call('hasSearchVolume', $params);
    }
}