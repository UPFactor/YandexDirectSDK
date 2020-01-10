<?php

namespace YandexDirectSDKTest\Units\Models\DataProviders;

use YandexDirectSDK\Collections\AdExtensions;
use YandexDirectSDK\Collections\AdGroups;
use YandexDirectSDK\Collections\AdImages;
use YandexDirectSDK\Collections\Ads;
use YandexDirectSDK\Collections\AgencyClients;
use YandexDirectSDK\Collections\AudienceTargetBids;
use YandexDirectSDK\Collections\AudienceTargets;
use YandexDirectSDK\Collections\BidModifiers;
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
use YandexDirectSDK\Collections\NegativeKeywordSharedSets;
use YandexDirectSDK\Collections\RetargetingLists;
use YandexDirectSDK\Collections\SitelinksSets;
use YandexDirectSDK\Collections\TurboPages;
use YandexDirectSDK\Collections\VCards;
use YandexDirectSDK\Collections\WebpageBids;
use YandexDirectSDK\Collections\Webpages;
use YandexDirectSDKTest\Helpers\FakeApi;

trait APIDataProvider
{
    /**
     * Цель тестирования:
     * todo: описание цели тестирования
     *
     * Методология тестирования:
     * todo: описание методологии тестирования
     *
     * Структуры данных тестирования:
     * todo: описание структуры данных для тестирования
     *
     *
     * @param string $forSet
     * @return array
     */
    public function apiDataProvider(string $forSet)
    {
        $testData = [];
        $testSets = [
            'AdExtensions' => [
                'collection' => AdExtensions::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/adextensions/get')->getAsArray('result.AdExtensions'),
                        'expected' => FakeApi::make('Base/adextensions/get')->getAsObject('result.AdExtensions')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/adextensions/get')->getAsArray('result.AdExtensions'),
                            FakeApi::make('Request/adextensions/add')->getAsArray('params.AdExtensions')
                        ),
                        'expected' => FakeApi::make('Request/adextensions/add')->getAsObject('params.AdExtensions')
                    ],
                ]
            ],
            'AdGroups' => [
                'collection' => AdGroups::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/adgroups/get')->getAsArray('result.AdGroups'),
                        'expected' => FakeApi::make('Base/adgroups/get')->getAsObject('result.AdGroups')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/adgroups/get')->getAsArray('result.AdGroups'),
                            FakeApi::make('Request/adgroups/update')->getAsArray('params.AdGroups'),
                            FakeApi::make('Request/adgroups/add')->getAsArray('params.AdGroups')
                        ),
                        'expected' => FakeApi::make('Request/adgroups/add')->getAsObject('params.AdGroups')
                    ],
                    'update' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/adgroups/get')->getAsArray('result.AdGroups'),
                            FakeApi::make('Request/adgroups/add')->getAsArray('params.AdGroups'),
                            FakeApi::make('Request/adgroups/update')->getAsArray('params.AdGroups')
                        ),
                        'expected' => FakeApi::make('Request/adgroups/update')->getAsObject('params.AdGroups')
                    ],
                ]
            ],
            'AdImages' => [
                'collection' => AdImages::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/adimages/get')->getAsArray('result.AdImages'),
                        'expected' => FakeApi::make('Base/adimages/get')->getAsObject('result.AdImages')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/adimages/get')->getAsArray('result.AdImages'),
                            FakeApi::make('Request/adimages/add')->getAsArray('params.AdImages')
                        ),
                        'expected' => FakeApi::make('Request/adimages/add')->getAsObject('params.AdImages')
                    ],
                ]
            ],
            'Ads' => [
                'collection' => Ads::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/ads/get')->getAsArray('result.Ads'),
                        'expected' => FakeApi::make('Base/ads/get')->getAsObject('result.Ads')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/ads/get')->getAsArray('result.Ads'),
                            FakeApi::make('Request/ads/update')->getAsArray('params.Ads'),
                            FakeApi::make('Request/ads/add')->getAsArray('params.Ads')
                        ),
                        'expected' => FakeApi::make('Request/ads/add')->getAsObject('params.Ads')
                    ],
                    'update' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/ads/get')->getAsArray('result.Ads'),
                            FakeApi::make('Request/ads/add')->getAsArray('params.Ads'),
                            FakeApi::make('Request/ads/update')->getAsArray('params.Ads')
                        ),
                        'expected' => FakeApi::make('Request/ads/update')->getAsObject('params.Ads')
                    ]
                ]
            ],
            'AgencyClients' => [
                'collection' => AgencyClients::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/agencyclients/get')->getAsArray('result.Clients'),
                        'expected' => FakeApi::make('Base/agencyclients/get')->getAsObject('result.Clients')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/agencyclients/get')->getAsArray('result.Clients'),
                            FakeApi::make('Request/agencyclients/update')->getAsArray('params.Clients'),
                            [FakeApi::make('Request/agencyclients/add')->getAsArray('params')]
                        ),
                        'expected' => [FakeApi::make('Request/agencyclients/add')->getAsObject('params')]
                    ],
                    'update' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/agencyclients/get')->getAsArray('result.Clients'),
                            FakeApi::make('Request/agencyclients/update')->getAsArray('params.Clients')
                        ),
                        'expected' => FakeApi::make('Request/agencyclients/update')->getAsObject('params.Clients')
                    ],
                ]
            ],
            'AudienceTargets' => [
                'collection' => AudienceTargets::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/audiencetargets/get')->getAsArray('result.AudienceTargets'),
                        'expected' => FakeApi::make('Base/audiencetargets/get')->getAsObject('result.AudienceTargets')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/audiencetargets/get')->getAsArray('result.AudienceTargets'),
                            FakeApi::make('Request/audiencetargets/add')->getAsArray('params.AudienceTargets')
                        ),
                        'expected' => FakeApi::make('Request/audiencetargets/add')->getAsObject('params.AudienceTargets')
                    ],
                ]
            ],
            'AudienceTargetBids' => [
                'collection' => AudienceTargetBids::class,
                'tests' => [
                    'update' => [
                        'insert' => FakeApi::make('Request/audiencetargets/setBids')->getAsArray('params.Bids'),
                        'expected' => FakeApi::make('Request/audiencetargets/setBids')->getAsObject('params.Bids')
                    ]
                ]
            ],
            'Bids' => [
                'collection' => Bids::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/bids/get')->getAsArray('result.Bids'),
                        'expected' => FakeApi::make('Base/bids/get')->getAsObject('result.Bids')
                    ],
                    'update' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/bids/get')->getAsArray('result.Bids'),
                            FakeApi::make('Request/bids/set')->getAsArray('params.Bids')
                        ),
                        'expected' => FakeApi::make('Request/bids/set')->getAsObject('params.Bids')
                    ],
                ]
            ],
            'BidsAuto' => [
                'collection' => BidsAuto::class,
                'tests' => [
                    'update' => [
                        'insert' => FakeApi::make('Request/bids/setAuto')->getAsArray('params.Bids'),
                        'expected' => FakeApi::make('Request/bids/setAuto')->getAsObject('params.Bids')
                    ],
                ]
            ],
            'BidModifiers' => [
                'collection' => BidModifiers::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/bidmodifiers/get')->getAsArray('result.BidModifiers'),
                        'expected' => FakeApi::make('Base/bidmodifiers/get')->getAsObject('result.BidModifiers')
                    ]
                ]
            ],
            'BidModifierSets' => [
                'collection' => BidModifierSets::class,
                'tests' => [
                    'update' => [
                        'insert' => FakeApi::make('Request/bidmodifiers/set')->getAsArray('params.BidModifiers'),
                        'expected' => FakeApi::make('Request/bidmodifiers/set')->getAsObject('params.BidModifiers')
                    ]
                ]
            ],
            'BidModifierToggles' => [
                'collection' => BidModifierToggles::class,
                'tests' => [
                    'update' => [
                        'insert' => FakeApi::make('Request/bidmodifiers/toggle')->getAsArray('params.BidModifierToggleItems'),
                        'expected' => FakeApi::make('Request/bidmodifiers/toggle')->getAsObject('params.BidModifierToggleItems')
                    ]
                ]
            ],
            'Campaigns' => [
                'collection' => Campaigns::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/campaigns/get')->getAsArray('result.Campaigns'),
                        'expected' => FakeApi::make('Base/campaigns/get')->getAsObject('result.Campaigns')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/campaigns/get')->getAsArray('result.Campaigns'),
                            FakeApi::make('Request/campaigns/update')->getAsArray('params.Campaigns'),
                            FakeApi::make('Request/campaigns/add')->getAsArray('params.Campaigns')
                        ),
                        'expected' => FakeApi::make('Request/campaigns/add')->getAsObject('params.Campaigns')
                    ],
                    'update' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/campaigns/get')->getAsArray('result.Campaigns'),
                            FakeApi::make('Request/campaigns/add')->getAsArray('params.Campaigns'),
                            FakeApi::make('Request/campaigns/update')->getAsArray('params.Campaigns')
                        ),
                        'expected' => FakeApi::make('Request/campaigns/update')->getAsObject('params.Campaigns')
                    ],
                ]
            ],
            'Clients' => [
                'collection' => Clients::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/clients/get')->getAsArray('result.Clients'),
                        'expected' => FakeApi::make('Base/clients/get')->getAsObject('result.Clients')
                    ],
                    'update' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/clients/get')->getAsArray('result.Clients'),
                            FakeApi::make('Request/clients/update')->getAsArray('params.Clients')
                        ),
                        'expected' => FakeApi::make('Request/clients/update')->getAsObject('params.Clients')
                    ],
                ]
            ],
            'Creatives' => [
                'collection' => Creatives::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/creatives/get')->getAsArray('result.Creatives'),
                        'expected' => FakeApi::make('Base/creatives/get')->getAsObject('result.Creatives')
                    ],
                ]
            ],
            'Webpages' => [
                'collection' => Webpages::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/dynamictextadtargets/get')->getAsArray('result.Webpages'),
                        'expected' => FakeApi::make('Base/dynamictextadtargets/get')->getAsObject('result.Webpages')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/dynamictextadtargets/get')->getAsArray('result.Webpages'),
                            FakeApi::make('Request/dynamictextadtargets/add')->getAsArray('params.Webpages')
                        ),
                        'expected' => FakeApi::make('Request/dynamictextadtargets/add')->getAsArray('params.Webpages')
                    ]
                ]
            ],
            'WebpageBids' => [
                'collection' => WebpageBids::class,
                'tests' => [
                    'update' => [
                        'insert' => FakeApi::make('Request/dynamictextadtargets/setBids')->getAsArray('params.Bids'),
                        'expected' => FakeApi::make('Request/dynamictextadtargets/setBids')->getAsObject('params.Bids')
                    ],
                ]
            ],
            'KeywordBids' => [
                'collection' => KeywordBids::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/keywordbids/get')->getAsArray('result.KeywordBids'),
                        'expected' => FakeApi::make('Base/keywordbids/get')->getAsObject('result.KeywordBids')
                    ],
                    'update' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/keywordbids/get')->getAsArray('result.KeywordBids'),
                            FakeApi::make('Request/keywordbids/set')->getAsArray('params.KeywordBids')
                        ),
                        'expected' => FakeApi::make('Request/keywordbids/set')->getAsArray('params.KeywordBids')
                    ]
                ]
            ],
            'KeywordBidsAuto' => [
                'collection' => KeywordBidsAuto::class,
                'tests' => [
                    'update' => [
                        'insert' => FakeApi::make('Request/keywordbids/setAuto')->getAsArray('params.KeywordBids'),
                        'expected' => FakeApi::make('Request/keywordbids/setAuto')->getAsObject('params.KeywordBids')
                    ]
                ]
            ],
            'Keywords' => [
                'collection' => Keywords::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/keywords/get')->getAsArray('result.Keywords'),
                        'expected' => FakeApi::make('Base/keywords/get')->getAsObject('result.Keywords')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/keywords/get')->getAsArray('result.Keywords'),
                            FakeApi::make('Request/keywords/update')->getAsArray('params.Keywords'),
                            FakeApi::make('Request/keywords/add')->getAsArray('params.Keywords')
                        ),
                        'expected' => FakeApi::make('Request/keywords/add')->getAsArray('params.Keywords')
                    ],
                    'update' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/keywords/get')->getAsArray('result.Keywords'),
                            FakeApi::make('Request/keywords/add')->getAsArray('params.Keywords'),
                            FakeApi::make('Request/keywords/update')->getAsArray('params.Keywords')
                        ),
                        'expected' => FakeApi::make('Request/keywords/update')->getAsArray('params.Keywords')
                    ],
                ]
            ],
            'Leads' => [
                'collection' => Leads::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/leads/get')->getAsArray('result.Leads'),
                        'expected' => FakeApi::make('Base/leads/get')->getAsObject('result.Leads')
                    ]
                ]
            ],
            'NegativeKeywordSharedSets' => [
                'collection' => NegativeKeywordSharedSets::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/negativekeywordsharedsets/get')->getAsArray('result.NegativeKeywordSharedSets'),
                        'expected' => FakeApi::make('Base/negativekeywordsharedsets/get')->getAsObject('result.NegativeKeywordSharedSets')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/negativekeywordsharedsets/get')->getAsArray('result.NegativeKeywordSharedSets'),
                            FakeApi::make('Request/negativekeywordsharedsets/update')->getAsArray('params.NegativeKeywordSharedSets'),
                            FakeApi::make('Request/negativekeywordsharedsets/add')->getAsArray('params.NegativeKeywordSharedSets')
                        ),
                        'expected' => FakeApi::make('Request/negativekeywordsharedsets/add')->getAsObject('params.NegativeKeywordSharedSets')
                    ],
                    'update' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/negativekeywordsharedsets/get')->getAsArray('result.NegativeKeywordSharedSets'),
                            FakeApi::make('Request/negativekeywordsharedsets/add')->getAsArray('params.NegativeKeywordSharedSets'),
                            FakeApi::make('Request/negativekeywordsharedsets/update')->getAsArray('params.NegativeKeywordSharedSets')
                        ),
                        'expected' => FakeApi::make('Request/negativekeywordsharedsets/update')->getAsObject('params.NegativeKeywordSharedSets')
                    ],
                ]
            ],
            'RetargetingLists' => [
                'collection' => RetargetingLists::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/retargetinglists/get')->getAsArray('result.RetargetingLists'),
                        'expected' => FakeApi::make('Base/retargetinglists/get')->getAsObject('result.RetargetingLists')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/retargetinglists/get')->getAsArray('result.RetargetingLists'),
                            FakeApi::make('Request/retargetinglists/update')->getAsArray('params.RetargetingLists'),
                            FakeApi::make('Request/retargetinglists/add')->getAsArray('params.RetargetingLists')
                        ),
                        'expected' => FakeApi::make('Request/retargetinglists/add')->getAsObject('params.RetargetingLists')
                    ],
                    'update' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/retargetinglists/get')->getAsArray('result.RetargetingLists'),
                            FakeApi::make('Request/retargetinglists/add')->getAsArray('params.RetargetingLists'),
                            FakeApi::make('Request/retargetinglists/update')->getAsArray('params.RetargetingLists')
                        ),
                        'expected' => FakeApi::make('Request/retargetinglists/update')->getAsObject('params.RetargetingLists')
                    ],
                ]
            ],
            'SitelinksSets' => [
                'collection' => SitelinksSets::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/sitelinks/get')->getAsArray('result.SitelinksSets'),
                        'expected' => FakeApi::make('Base/sitelinks/get')->getAsObject('result.SitelinksSets')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/sitelinks/get')->getAsArray('result.SitelinksSets'),
                            FakeApi::make('Request/sitelinks/add')->getAsArray('params.SitelinksSets')
                        ),
                        'expected' => FakeApi::make('Request/sitelinks/add')->getAsObject('params.SitelinksSets')
                    ]
                ]
            ],
            'TurboPages' => [
                'collection' => TurboPages::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/turbopages/get')->getAsArray('result.TurboPages'),
                        'expected' => FakeApi::make('Base/turbopages/get')->getAsObject('result.TurboPages')
                    ]
                ]
            ],
            'VCards' => [
                'collection' => VCards::class,
                'tests' => [
                    'get' => [
                        'insert' => FakeApi::make('Base/vcards/get')->getAsArray('result.VCards'),
                        'expected' => FakeApi::make('Base/vcards/get')->getAsObject('result.VCards')
                    ],
                    'add' => [
                        'insert' => $this->apiMerge(
                            FakeApi::make('Base/vcards/get')->getAsArray('result.VCards'),
                            FakeApi::make('Request/vcards/add')->getAsArray('params.VCards')
                        ),
                        'expected' => FakeApi::make('Request/vcards/add')->getAsObject('params.VCards')
                    ]
                ]
            ]
        ];

        foreach ($testSets as $testSetName => $testSet){
            foreach ($testSet['tests'] as $testName => $test){
                if ($testName !== $forSet){
                    continue;
                }

                $testData["{$testSetName}.{$testName}"] = [
                    $testSet['collection'],
                    $this->apiSorting($test['insert']),
                    json_encode($this->apiSorting($test['expected']))
                ];
            }
        }

        return $testData;
    }

    /**
     * @param array $array1
     * @param array ...$arrays
     * @return array
     */
    protected function apiMerge($array1, ...$arrays)
    {
        foreach ($arrays as $array2){
            foreach ($array2 as $key => $value){
                if (!isset($array1[$key])){
                    $array1[$key] = $value;
                    continue;
                }
                if (is_array($array1[$key]) and is_array($value)){
                    $array1[$key] = $this->apiMerge($array1[$key], $value);
                    continue;
                }
                $array1[$key] = $value;
            }
        }
        return $array1;
    }

    /**
     * @param $value
     * @return array|object
     */
    protected function apiSorting($value)
    {
        if (is_object($value)){
            $value = (array) $value;
            if (!empty($value)){
                ksort($value);
                foreach ($value as $k => $item){
                    $value[$k] = $this->apiSorting($item);
                }
            }
            return (object) $value;
        }

        if (is_array($value) and !empty($value)){
            ksort($value);
            foreach ($value as $k => $item){
                $value[$k] = $this->apiSorting($item);
            }
        }

        return $value;
    }
}