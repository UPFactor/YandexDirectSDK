<?php

namespace YandexDirectSDKTest\Unit\Models;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AdExtensions;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\AdImages;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AudienceTargetBids;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifierSets;
use YandexDirectSDK\Collections\BidModifierToggles;
use YandexDirectSDK\Collections\Bids;
use YandexDirectSDK\Collections\BidsAuto;
use YandexDirectSDK\Collections\Campaigns;
use YandexDirectSDK\Collections\Clients;
use YandexDirectSDK\Collections\Creatives;
use YandexDirectSDK\Collections\KeywordBids;
use YandexDirectSDK\Collections\KeywordBidsAuto;
use YandexDirectSDK\Collections\Keywords;
use YandexDirectSDK\Collections\Leads;
use YandexDirectSDK\Collections\RetargetingLists;
use YandexDirectSDK\Collections\SitelinksSets;
use YandexDirectSDK\Collections\TurboPages;
use YandexDirectSDK\Collections\VCards;
use YandexDirectSDK\Collections\WebpageBids;
use YandexDirectSDK\Collections\Webpages;
use UPTools\Arr;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDKTest\Helpers\FakeApi;

class ModelsTest extends TestCase
{
    /*
    |--------------------------------------------------------------------------
    | Data providers
    |--------------------------------------------------------------------------
    */

    public static function apiDataProvider(): array
    {
        return [
            'AdExtensions' => [
                'collection' => AdExtensions::class,
                'properties' => [
                    'get' => FakeApi::get('Base/adextensions/get', 'result.AdExtensions'),
                    'add' => FakeApi::get('Request/adextensions/add', 'params.AdExtensions')
                ]
            ],
            'AdGroups' => [
                'collection' => AdGroups::class,
                'properties' => [
                    'get' => FakeApi::get('Base/adgroups/get', 'result.AdGroups'),
                    'add' => FakeApi::get('Request/adgroups/add', 'params.AdGroups'),
                    'update' => FakeApi::get('Request/adgroups/update', 'params.AdGroups'),
                ]
            ],
            'AdImages' => [
                'collection' => AdImages::class,
                'properties' => [
                    'get' => FakeApi::get('Base/adimages/get', 'result.AdImages'),
                    'add' => FakeApi::get('Request/adimages/add', 'params.AdImages')
                ]
            ],
            'Ads' => [
                'collection' => Ads::class,
                'properties' => [
                    'get' => FakeApi::get('Base/ads/get', 'result.Ads'),
                    'add' => FakeApi::get('Request/ads/add', 'params.Ads'),
                    'update' => FakeApi::get('Request/ads/update', 'params.Ads'),
                ]
            ],
            'AgencyClients' => [
                'collection' => Clients::class,
                'properties' => [
                    'get' => FakeApi::get('Base/agencyclients/get', 'result.Clients'),
                    'update' => FakeApi::get('Request/agencyclients/update', 'params.Clients'),
                ]
            ],
            'AudienceTargets' => [
                'collection' => AudienceTargets::class,
                'properties' => [
                    'get' => FakeApi::get('Base/audiencetargets/get', 'result.AudienceTargets'),
                    'add' => FakeApi::get('Request/audiencetargets/add', 'params.AudienceTargets'),
                ]
            ],
            'AudienceTargetBids' => [
                'collection' => AudienceTargetBids::class,
                'properties' => [
                    'get' => FakeApi::get('Request/audiencetargets/setBids', 'params.Bids'),
                    'update' => FakeApi::get('Request/audiencetargets/setBids', 'params.Bids')
                ]
            ],
            'Bids' => [
                'collection' => Bids::class,
                'properties' => [
                    'get'=> FakeApi::get('Base/bids/get', 'result.Bids'),
                    'update' => FakeApi::get('Request/bids/set', 'params.Bids')
                ]
            ],
            'BidsAuto' => [
                'collection' => BidsAuto::class,
                'properties' => [
                    'get'=> FakeApi::get('Request/bids/setAuto', 'params.Bids'),
                    'update' => FakeApi::get('Request/bids/setAuto', 'params.Bids')
                ]
            ],
            'BidModifierSets' => [
                'collection' => BidModifierSets::class,
                'properties' => [
                    'get' => FakeApi::get('Request/bidmodifiers/set', 'params.BidModifiers'),
                    'update' => FakeApi::get('Request/bidmodifiers/set', 'params.BidModifiers')
                ]
            ],
            'BidModifierToggles' => [
                'collection' => BidModifierToggles::class,
                'properties' => [
                    'get' => FakeApi::get('Request/bidmodifiers/toggle', 'params.BidModifierToggleItems'),
                    'update' => FakeApi::get('Request/bidmodifiers/toggle', 'params.BidModifierToggleItems')
                ]
            ],
            'Campaigns' => [
                'collection' => Campaigns::class,
                'properties' => [
                    'get' => FakeApi::get('Base/campaigns/get', 'result.Campaigns'),
                    'add' => FakeApi::get('Request/campaigns/add', 'params.Campaigns'),
                    'update' => FakeApi::get('Request/campaigns/update', 'params.Campaigns')
                ]
            ],
            'Clients' => [
                'collection' => Clients::class,
                'properties' => [
                    'get' => FakeApi::get('Base/clients/get', 'result.Clients'),
                ]
            ],
            'Creatives' => [
                'collection' => Creatives::class,
                'properties' => [
                    'get' => FakeApi::get('Base/creatives/get', 'result.Creatives')
                ]
            ],
            'Webpages' => [
                'collection' => Webpages::class,
                'properties' => [
                    'get' => FakeApi::get('Base/dynamictextadtargets/get', 'result.Webpages'),
                    'add' => FakeApi::get('Request/dynamictextadtargets/add', 'params.Webpages'),
                ]
            ],
            'WebpageBids' => [
                'collection' => WebpageBids::class,
                'properties' => [
                    'get' => FakeApi::get('Request/dynamictextadtargets/setBids', 'params.Bids'),
                    'update' => FakeApi::get('Request/dynamictextadtargets/setBids', 'params.Bids')
                ]
            ],
            'KeywordBids' => [
                'collection' => KeywordBids::class,
                'properties' => [
                    'get' => FakeApi::get('Base/keywordbids/get', 'result.KeywordBids'),
                    'update' => FakeApi::get('Request/keywordbids/set', 'params.KeywordBids')
                ]
            ],
            'KeywordBidsAuto' => [
                'collection' => KeywordBidsAuto::class,
                'properties' => [
                    'get' => FakeApi::get('Request/keywordbids/setAuto', 'params.KeywordBids'),
                    'update' => FakeApi::get('Request/keywordbids/setAuto', 'params.KeywordBids')
                ]
            ],
            'Keywords' => [
                'collection' => Keywords::class,
                'properties' => [
                    'get' => FakeApi::get('Base/keywords/get', 'result.Keywords'),
                    'add' => FakeApi::get('Request/keywords/add', 'params.Keywords'),
                    'update' => FakeApi::get('Request/keywords/update', 'params.Keywords')
                ]
            ],
            'Leads' => [
                'collection' => Leads::class,
                'properties' => [
                    'get' => FakeApi::get('Base/leads/get', 'result.Leads')
                ]
            ],
            'RetargetingLists' => [
                'collection' => RetargetingLists::class,
                'properties' => [
                    'get' => FakeApi::get('Base/retargetinglists/get', 'result.RetargetingLists'),
                    'add' => FakeApi::get('Request/retargetinglists/add', 'params.RetargetingLists'),
                    'update' => FakeApi::get('Request/retargetinglists/update', 'params.RetargetingLists')
                ]
            ],
            'SitelinksSets' => [
                'collection' => SitelinksSets::class,
                'properties' => [
                    'get' => FakeApi::get('Base/sitelinks/get', 'result.SitelinksSets'),
                    'add' => FakeApi::get('Request/sitelinks/add', 'params.SitelinksSets')
                ]
            ],
            'TurboPages' => [
                'collection' => TurboPages::class,
                'properties' => [
                    'get' => FakeApi::get('Base/turbopages/get', 'result.TurboPages')
                ]
            ],
            'VCards' => [
                'collection' => VCards::class,
                'properties' => [
                    'get' => FakeApi::get('Base/vcards/get', 'result.VCards'),
                    'add' => FakeApi::get('Request/vcards/add', 'params.VCards')
                ]
            ]
        ];
    }

    public static function apiResponseDataProvider(): array
    {
        return Arr::filter(static::apiDataProvider(), function($item){
            return isset($item['properties']['get']);
        });
    }

    public static function apiAddRequestDataProvider(): array
    {
        return Arr::filter(static::apiDataProvider(), function($item){
            return isset($item['properties']['get']) and isset($item['properties']['add']);
        });
    }

    public static function apiUpdateRequestDataProvider(): array
    {
        return Arr::filter(static::apiDataProvider(), function($item){
            return isset($item['properties']['get']) and isset($item['properties']['update']);
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public static function arrayTyping($array)
    {
        foreach ($array as $key => $value){
            if (!is_array($value)){
                $array[$key] = gettype($value);
                continue;
            }

            if (empty($value)){
                $array[$key] = 'object';
                continue;
            }

            if (!Arr::isAssoc($value)){
                if (!is_array($value[0]) or !Arr::isAssoc($value[0])){
                    $array[$key] = gettype($value);
                } else {
                    $array[$key][0] = static::arrayTyping($value[0]);
                }
                continue;
            }

            $array[$key] = static::arrayTyping($value);
        }

        return $array;
    }

    public static function arrayMerge($array1, $array2)
    {
        foreach ($array2 as $key => $value){
            if (!isset($array1[$key])){
                $array1[$key] = $value;
                continue;
            }

            if (is_array($array1[$key]) and is_array($value)){
                $array1[$key] = static::arrayMerge($array1[$key], $value);
                continue;
            }

            $array1[$key] = $value;
        }

        return $array1;
    }

    /*
    |--------------------------------------------------------------------------
    | Tests
    |--------------------------------------------------------------------------
    */

    //todo:
    // AgencyClients add
    // Clients, AgencyClients update
    // BidModifiers
    // AdGroup укажите пустую структуру +
    // TrackingPixels +
    // NegativeKeywordSharedSetsService

    /**
     * @test
     * @dataProvider apiResponseDataProvider
     *
     * @param ModelCollectionInterface $collection
     * @param array $properties
     */
    public static function responseParsing($collection, array $properties):void
    {
        static::assertEquals(
            $properties['get'],
            $collection::make()->insert($properties['get'])->toArray()
        );
    }

    /**
     * @test
     * @dataProvider apiAddRequestDataProvider
     *
     * @param ModelCollectionInterface $collection
     * @param array $properties
     */
    public static function creatingAddRequest($collection, array $properties):void
    {
        static::assertEquals(
            static::arrayTyping(
                $properties['add']
            ),
            static::arrayTyping(
                $collection::make()
                    ->insert(static::arrayMerge($properties['get'], $properties['add']))
                    ->toArray(Model::IS_ADDABLE)
            )
        );
    }

    /**
     * @test
     * @dataProvider apiUpdateRequestDataProvider
     *
     * @param ModelCollectionInterface $collection
     * @param array $properties
     */
    public static function creatingUpdateRequest($collection, array $properties)
    {
        static::assertEquals(
            static::arrayTyping(
                $properties['update']
            ),
            static::arrayTyping(
                $collection::make()
                    ->insert(static::arrayMerge($properties['get'], $properties['update']))
                    ->toArray(Model::IS_UPDATABLE)
            )
        );
    }
}