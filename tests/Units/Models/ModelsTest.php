<?php

namespace YandexDirectSDKTest\Unit\Models;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDKTest\Units\Models\DataProviders\APIDataProvider;

class ModelsTest extends TestCase
{
    use APIDataProvider;

    /*
    |--------------------------------------------------------------------------
    | Data providers
    |--------------------------------------------------------------------------
    */

    /*public static function apiDataProvider(): array
    {
        return [
            'AdExtensions' => [
                'collection' => AdExtensions::class,
                'tests' => [
                    'get' => FakeApi::getAsObject('Base/adextensions/get', 'result.AdExtensions'),
                    'add' => FakeApi::getAsObject('Request/adextensions/add', 'params.AdExtensions')
                ]
            ],
            'AdGroups' => [
                'collection' => AdGroups::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/adgroups/get', 'result.AdGroups'),
                    'add' => FakeApi::getAsObject('Request/adgroups/add', 'params.AdGroups'),
                    'update' => FakeApi::getAsObject('Request/adgroups/update', 'params.AdGroups'),
                ]
            ],
            'AdImages' => [
                'collection' => AdImages::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/adimages/get', 'result.AdImages'),
                    'add' => FakeApi::getAsObject('Request/adimages/add', 'params.AdImages')
                ]
            ],
            'Ads' => [
                'collection' => Ads::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/ads/get', 'result.Ads'),
                    'add' => FakeApi::getAsObject('Request/ads/add', 'params.Ads'),
                    'update' => FakeApi::getAsObject('Request/ads/update', 'params.Ads'),
                ]
            ],
            'AgencyClients' => [
                'collection' => Clients::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/agencyclients/get', 'result.Clients'),
                    'update' => FakeApi::getAsObject('Request/agencyclients/update', 'params.Clients'),
                ]
            ],
            'AudienceTargets' => [
                'collection' => AudienceTargets::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/audiencetargets/get', 'result.AudienceTargets'),
                    'add' => FakeApi::getAsObject('Request/audiencetargets/add', 'params.AudienceTargets'),
                ]
            ],
            'AudienceTargetBids' => [
                'collection' => AudienceTargetBids::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Request/audiencetargets/setBids', 'params.Bids'),
                    'update' => FakeApi::getAsObject('Request/audiencetargets/setBids', 'params.Bids')
                ]
            ],
            'Bids' => [
                'collection' => Bids::class,
                'properties' => [
                    'get'=> FakeApi::getAsObject('Base/bids/get', 'result.Bids'),
                    'update' => FakeApi::getAsObject('Request/bids/set', 'params.Bids')
                ]
            ],
            'BidsAuto' => [
                'collection' => BidsAuto::class,
                'properties' => [
                    'get'=> FakeApi::getAsObject('Request/bids/setAuto', 'params.Bids'),
                    'update' => FakeApi::getAsObject('Request/bids/setAuto', 'params.Bids')
                ]
            ],
            'BidModifierSets' => [
                'collection' => BidModifierSets::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Request/bidmodifiers/set', 'params.BidModifiers'),
                    'update' => FakeApi::getAsObject('Request/bidmodifiers/set', 'params.BidModifiers')
                ]
            ],
            'BidModifierToggles' => [
                'collection' => BidModifierToggles::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Request/bidmodifiers/toggle', 'params.BidModifierToggleItems'),
                    'update' => FakeApi::getAsObject('Request/bidmodifiers/toggle', 'params.BidModifierToggleItems')
                ]
            ],
            'Campaigns' => [
                'collection' => Campaigns::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/campaigns/get', 'result.Campaigns'),
                    'add' => FakeApi::getAsObject('Request/campaigns/add', 'params.Campaigns'),
                    'update' => FakeApi::getAsObject('Request/campaigns/update', 'params.Campaigns')
                ]
            ],
            'Clients' => [
                'collection' => Clients::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/clients/get', 'result.Clients'),
                ]
            ],
            'Creatives' => [
                'collection' => Creatives::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/creatives/get', 'result.Creatives')
                ]
            ],
            'Webpages' => [
                'collection' => Webpages::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/dynamictextadtargets/get', 'result.Webpages'),
                    'add' => FakeApi::getAsObject('Request/dynamictextadtargets/add', 'params.Webpages'),
                ]
            ],
            'WebpageBids' => [
                'collection' => WebpageBids::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Request/dynamictextadtargets/setBids', 'params.Bids'),
                    'update' => FakeApi::getAsObject('Request/dynamictextadtargets/setBids', 'params.Bids')
                ]
            ],
            'KeywordBids' => [
                'collection' => KeywordBids::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/keywordbids/get', 'result.KeywordBids'),
                    'update' => FakeApi::getAsObject('Request/keywordbids/set', 'params.KeywordBids')
                ]
            ],
            'KeywordBidsAuto' => [
                'collection' => KeywordBidsAuto::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Request/keywordbids/setAuto', 'params.KeywordBids'),
                    'update' => FakeApi::getAsObject('Request/keywordbids/setAuto', 'params.KeywordBids')
                ]
            ],
            'Keywords' => [
                'collection' => Keywords::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/keywords/get', 'result.Keywords'),
                    'add' => FakeApi::getAsObject('Request/keywords/add', 'params.Keywords'),
                    'update' => FakeApi::getAsObject('Request/keywords/update', 'params.Keywords')
                ]
            ],
            'Leads' => [
                'collection' => Leads::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/leads/get', 'result.Leads')
                ]
            ],
            'RetargetingLists' => [
                'collection' => RetargetingLists::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/retargetinglists/get', 'result.RetargetingLists'),
                    'add' => FakeApi::getAsObject('Request/retargetinglists/add', 'params.RetargetingLists'),
                    'update' => FakeApi::getAsObject('Request/retargetinglists/update', 'params.RetargetingLists')
                ]
            ],
            'SitelinksSets' => [
                'collection' => SitelinksSets::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/sitelinks/get', 'result.SitelinksSets'),
                    'add' => FakeApi::getAsObject('Request/sitelinks/add', 'params.SitelinksSets')
                ]
            ],
            'TurboPages' => [
                'collection' => TurboPages::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/turbopages/get', 'result.TurboPages')
                ]
            ],
            'VCards' => [
                'collection' => VCards::class,
                'properties' => [
                    'get' => FakeApi::getAsObject('Base/vcards/get', 'result.VCards'),
                    'add' => FakeApi::getAsObject('Request/vcards/add', 'params.VCards')
                ]
            ]
        ];
    }*/

    /*public static function apiResponseDataProvider(): array
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
    }*/


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /*public static function arrayTyping($array)
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
    }*/

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


    /*
     |-------------------------------------------------------------------------------
     |
     | Парсинг результатов запроса на выборку данных
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function apiResponseDataProvider(): array
    {
        return $this->apiDataProvider('get');
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider apiResponseDataProvider
     * @param ModelCollectionInterface $collection
     * @param array $insert
     * @param string $expected
     */
    public static function testResponseParsing($collection, array $insert, string $expected):void
    {
        static::assertSame(
            $expected,
            $collection::wrap($insert)->toJson()
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Создание запроса на добавление данных
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function apiAddRequestDataProvider(): array
    {
        return $this->apiDataProvider('add');
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider apiAddRequestDataProvider
     * @param ModelCollectionInterface $collection
     * @param array $insert
     * @param string $expected
     */
    public static function testCreatingAddRequest($collection, array $insert, string $expected):void
    {
        static::assertSame(
            $expected,
            $collection::wrap($insert)->toJson(Model::IS_ADDABLE)
        );
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Создание запроса на обновление данных
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Data providers
     |-------------------------------------------------------------------------------
    */

    public function apiUpdateRequestDataProvider(): array
    {
        return $this->apiDataProvider('update');
    }

    /*
     | Tests
     |-------------------------------------------------------------------------------
    */

    /**
     * @dataProvider apiUpdateRequestDataProvider
     * @param ModelCollectionInterface $collection
     * @param array $insert
     * @param string $expected
     */
    public static function testCreatingUpdateRequest($collection, array $insert, string $expected):void
    {
        static::assertSame(
            $expected,
            $collection::wrap($insert)->toJson(Model::IS_UPDATABLE)
        );
    }



    /**
     * @test
     * @dataProvider apiAddRequestDataProvider
     *
     * @param ModelCollectionInterface $collection
     * @param array $properties
     */
    /*public static function creatingAddRequest($collection, array $properties):void
    {
        static::assertEquals(
            $properties['add'],
            $collection::wrap($properties['get'])
                ->insert($properties['add'])
                ->toArray(Model::IS_ADDABLE)
        );

//        static::assertEquals(
//            static::arrayTyping(
//                $properties['add']
//            ),
//            static::arrayTyping(
//                $collection::make()
//                    ->insert(static::arrayMerge($properties['get'], $properties['add']))
//                    ->toArray(Model::IS_ADDABLE)
//            )
//        );
    }*/

    /**
     * @test
     * @dataProvider apiUpdateRequestDataProvider
     *
     * @param ModelCollectionInterface $collection
     * @param array $properties
     */
    /*public static function creatingUpdateRequest($collection, array $properties)
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
    }*/
}