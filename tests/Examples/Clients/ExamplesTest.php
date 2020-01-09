<?php

namespace YandexDirectSDKTest\Examples\Clients;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\Clients;
use YandexDirectSDK\Collections\ClientSettings;
use YandexDirectSDK\Collections\EmailSubscriptions;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Models\Client;
use YandexDirectSDK\Models\ClientNotification;
use YandexDirectSDK\Models\ClientSetting;
use YandexDirectSDK\Models\EmailSubscription;
use YandexDirectSDKTest\Helpers\Checklists;
use YandexDirectSDKTest\Helpers\Env;

class ExamplesTest extends TestCase
{
    /*
     |-------------------------------------------------------------------------------
     |
     | Handlers
     |
     |-------------------------------------------------------------------------------
    */

    /**
     * Constructor
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Selection
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return Clients|ModelCollectionInterface
     */
    public function query():Clients
    {
        // [ Example ]

        $clients = Client::query()
            ->select([
                "AccountQuality",
                "Archived",
                "ClientId",
                "ClientInfo",
                "CountryId",
                "CreatedAt",
                "Currency",
                "Grants",
                "Login",
                "Notification",
                "OverdraftSumAvailable",
                "Phone",
                "Representatives",
                "Restrictions",
                "Settings",
                "Type",
                "VatRate"
            ])
            ->get();

        // [ Post processing ]

        Checklists::checkModelCollection($clients, Clients::class, [
            'AccountQuality' => 'float',
            'Archived' => 'required|string:YES,NO',
            'ClientId' => 'required|integer',
            'ClientInfo' => 'required|string',
            'CountryId' => 'integer',
            'CreatedAt' => 'required|date',
            'Login' => 'required|string',
            'Currency' => 'string:RUB,BYN,CHF,EUR,KZT,TRY,UAH,USD',
            'Grants.*.Privilege' => 'required|string:EDIT_CAMPAIGNS,IMPORT_XLS,TRANSFER_MONEY',
            'Grants.*.Value' => 'required|string:YES,NO',
            'Grants.*.Agency' => 'string',
            'Notification.Lang' => 'required|string:RU,UK,EN,TR',
            'Notification.SmsPhoneNumber' => 'string',
            'Notification.Email' => 'string',
            'Notification.EmailSubscriptions.*.Option' => 'required|string:RECEIVE_RECOMMENDATIONS,TRACK_MANAGED_CAMPAIGNS,TRACK_POSITION_CHANGES',
            'Notification.EmailSubscriptions.*.Value' => 'required|string:YES,NO',
            'Phone' => 'string',
            'OverdraftSumAvailable' => 'integer',
            'Representatives.*.Email' => 'required|string',
            'Representatives.*.Login' => 'required|string',
            'Representatives.*.Role' => 'required|string:CHIEF,DELEGATE,UNKNOWN',
            'Restrictions.*.Element' => 'string:CAMPAIGNS_TOTAL_PER_CLIENT,CAMPAIGNS_UNARCHIVED_PER_CLIENT,ADGROUPS_TOTAL_PER_CAMPAIGN,ADS_TOTAL_PER_ADGROUP,KEYWORDS_TOTAL_PER_ADGROUP,AD_EXTENSIONS_TOTAL,STAT_REPORTS_TOTAL_IN_QUEUE,FORECAST_REPORTS_TOTAL_IN_QUEUE,WORDSTAT_REPORTS_TOTAL_IN_QUEUE,API_POINTS',
            'Restrictions.*.Value' => 'required|integer',
            'Settings.*.Option' => 'required|string:CORRECT_TYPOS_AUTOMATICALLY,DISPLAY_STORE_RATING,SHARED_ACCOUNT_ENABLED',
            'Settings.*.Value' => 'required|string:YES,NO',
            'Type' => 'required|string',
            'VatRate' => 'float'
        ]);

        return $clients;
    }

    /**
     * @test
     * @return Client|ModelInterface
     */
    public function first(): Client
    {
        // [ Example ]

        $client = Client::query()
            ->select([
                "AccountQuality",
                "Archived",
                "ClientId",
                "ClientInfo",
                "CountryId",
                "CreatedAt",
                "Currency",
                "Grants",
                "Login",
                "Notification",
                "OverdraftSumAvailable",
                "Phone",
                "Representatives",
                "Restrictions",
                "Settings",
                "Type",
                "VatRate"
            ])
            ->first();

        // [ Post processing ]

        Checklists::checkModel($client, Client::class, [
            'AccountQuality' => 'float',
            'Archived' => 'required|string:YES,NO',
            'ClientId' => 'required|integer',
            'ClientInfo' => 'required|string',
            'CountryId' => 'integer',
            'CreatedAt' => 'required|date',
            'Login' => 'required|string',
            'Currency' => 'string:RUB,BYN,CHF,EUR,KZT,TRY,UAH,USD',
            'Grants.*.Privilege' => 'required|string:EDIT_CAMPAIGNS,IMPORT_XLS,TRANSFER_MONEY',
            'Grants.*.Value' => 'required|string:YES,NO',
            'Grants.*.Agency' => 'string',
            'Notification.Lang' => 'required|string:RU,UK,EN,TR',
            'Notification.SmsPhoneNumber' => 'string',
            'Notification.Email' => 'string',
            'Notification.EmailSubscriptions.*.Option' => 'required|string:RECEIVE_RECOMMENDATIONS,TRACK_MANAGED_CAMPAIGNS,TRACK_POSITION_CHANGES',
            'Notification.EmailSubscriptions.*.Value' => 'required|string:YES,NO',
            'Phone' => 'string',
            'OverdraftSumAvailable' => 'integer',
            'Representatives.*.Email' => 'required|string',
            'Representatives.*.Login' => 'required|string',
            'Representatives.*.Role' => 'required|string:CHIEF,DELEGATE,UNKNOWN',
            'Restrictions.*.Element' => 'string:CAMPAIGNS_TOTAL_PER_CLIENT,CAMPAIGNS_UNARCHIVED_PER_CLIENT,ADGROUPS_TOTAL_PER_CAMPAIGN,ADS_TOTAL_PER_ADGROUP,KEYWORDS_TOTAL_PER_ADGROUP,AD_EXTENSIONS_TOTAL,STAT_REPORTS_TOTAL_IN_QUEUE,FORECAST_REPORTS_TOTAL_IN_QUEUE,WORDSTAT_REPORTS_TOTAL_IN_QUEUE,API_POINTS',
            'Restrictions.*.Value' => 'required|integer',
            'Settings.*.Option' => 'required|string:CORRECT_TYPOS_AUTOMATICALLY,DISPLAY_STORE_RATING,SHARED_ACCOUNT_ENABLED',
            'Settings.*.Value' => 'required|string:YES,NO',
            'Type' => 'required|string',
            'VatRate' => 'float'
        ]);

        return $client;
    }

    /*
     | Update
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends first
     * @param Client $client
     * @return void
     */
    public function getAndUpdate(Client $client)
    {
        if ($client->type === 'AGENCY'){
            $this->markTestSkipped('Yandex.Direct account is agent');
        }

        // [ Example ]

        /** @var Client $client */
        $client = Client::query()
            ->select('ClientInfo','Notification','Phone','Settings')
            ->first();

        $result = $client
            ->setClientInfo('Maxim')
            ->setPhone('79001234567')
            ->update();

        // [ Post processing ]

        Checklists::checkResource($result, Clients::class, [
            'ClientInfo' => 'string:Maxim',
            'Phone' => 'string:79001234567'
        ]);
    }

    /**
     * @test
     * @depends first
     * @param Client $client
     * @return void
     */
    public function makeAndUpdate(Client $client)
    {
        if ($client->type === 'AGENCY'){
            $this->markTestSkipped('Yandex.Direct account is agent');
        }

        // [ Example ]
        $result = Client::make()
            ->setNotification(
                ClientNotification::make()
                    ->setLang('EN')
                    ->setEmail('client@mail.com')
                    ->setEmailSubscriptions(
                        EmailSubscriptions::make(
                            EmailSubscription::receiveRecommendations(false),
                            EmailSubscription::trackManagedCampaigns(false),
                            EmailSubscription::make()
                                ->setOption('TRACK_POSITION_CHANGES')
                                ->setValue('NO')
                        )
                    )
            )
            ->setSettings(
                ClientSettings::make(
                    ClientSetting::correctTyposAutomatically(false),
                    ClientSetting::make()
                        ->setOption('DISPLAY_STORE_RATING')
                        ->setValue('NO')

                )
            )
            ->update();

        // [ Post processing ]

        Checklists::checkResource($result, Clients::class, [
            'Notification.Lang' => 'required|string:EN',
            'Notification.Email' => 'required|string:client@mail.com',
            'Notification.EmailSubscriptions.*.Option' => 'required|string:RECEIVE_RECOMMENDATIONS,TRACK_MANAGED_CAMPAIGNS,TRACK_POSITION_CHANGES',
            'Notification.EmailSubscriptions.*.Value' => 'required|string:NO',
            'Settings.*.Option' => 'required|string:CORRECT_TYPOS_AUTOMATICALLY,DISPLAY_STORE_RATING,SHARED_ACCOUNT_ENABLED',
            'Settings.*.Value' => 'required|string:NO',
        ]);
    }

    /**
     * @test
     * @depends first
     * @param Client $client
     * @return void
     */
    public function makeByArrayAndUpdate(Client $client)
    {
        if ($client->type === 'AGENCY'){
            $this->markTestSkipped('Yandex.Direct account is agent');
        }

        // [ Example ]

        $client = Client::make([
            'ClientInfo' => 'Alex',
            'Phone' => '79007654321',
            'Notification' => [
                'Lang' => 'RU',
                'Email' => 'alex@mail.com',
                'EmailSubscriptions' => [
                    [
                        'Option' => 'RECEIVE_RECOMMENDATIONS',
                        'Value' => 'YES'
                    ],
                    [
                        'Option' => 'TRACK_MANAGED_CAMPAIGNS',
                        'Value' => 'YES'
                    ],
                    [
                        'Option' => 'TRACK_POSITION_CHANGES',
                        'Value' => 'YES'
                    ]
                ]
            ],
            'Settings' => [
                [
                    'Option' => 'CORRECT_TYPOS_AUTOMATICALLY',
                    'Value' => 'YES'
                ],
                [
                    'Option' => 'DISPLAY_STORE_RATING',
                    'Value' => 'YES'
                ]
            ]
        ]);

        $result = $client->update();

        // [ Post processing ]

        Checklists::checkResource($result, Clients::class, [
            'ClientInfo' => 'string:Alex',
            'Phone' => 'string:79007654321',
            'Notification.Lang' => 'required|string:RU',
            'Notification.Email' => 'required|string:alex@mail.com',
            'Notification.EmailSubscriptions.*.Option' => 'required|string:RECEIVE_RECOMMENDATIONS,TRACK_MANAGED_CAMPAIGNS,TRACK_POSITION_CHANGES',
            'Notification.EmailSubscriptions.*.Value' => 'required|string:YES',
            'Settings.*.Option' => 'required|string:CORRECT_TYPOS_AUTOMATICALLY,DISPLAY_STORE_RATING,SHARED_ACCOUNT_ENABLED',
            'Settings.*.Value' => 'required|string:YES',
        ]);
    }
}