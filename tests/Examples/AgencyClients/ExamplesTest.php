<?php

namespace YandexDirectSDKTest\Examples\AgencyClients;

use PHPUnit\Framework\TestCase;
use YandexDirectSDK\Collections\AgencyClients;
use YandexDirectSDK\Collections\ClientSettings;
use YandexDirectSDK\Collections\EmailSubscriptions;
use YandexDirectSDK\Collections\Grands;
use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;
use YandexDirectSDK\Models\AgencyClient;
use YandexDirectSDK\Models\Client;
use YandexDirectSDK\Models\ClientNotification;
use YandexDirectSDK\Models\ClientSetting;
use YandexDirectSDK\Models\EmailSubscription;
use YandexDirectSDK\Models\Grand;
use YandexDirectSDK\Session;
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

    public static function setUpBeforeClass(): void
    {
        Env::setUpSession();
        Session::setClient(null);
    }

    protected function setUp(): void
    {
        $client = Client::query()->select('Type')->first();
        if ($client->type !== 'AGENCY'){
            $this->markTestSkipped('Yandex.Direct account is not an agent');
        }
    }

    /*
     |-------------------------------------------------------------------------------
     |
     | Examples
     |
     |-------------------------------------------------------------------------------
    */

    /*
     | Create
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return AgencyClient|ModelCommonInterface
     */
    public function create(): AgencyClient
    {
        $login = 'login-'.time();

        // [ Example ]

        $client = AgencyClient::make()
            ->setLogin($login)
            ->setFirstName('Alex')
            ->setLastName('Simpson')
            ->setCurrency('RUB')
            ->setGrants(
                Grands::make(
                    Grand::editCampaigns(true),
                    Grand::importXls(true),
                    Grand::transferMoney(true)
                )
            )
            ->setNotification(
                ClientNotification::make()
                    ->setLang('RU')
                    ->setEmail('ydsdk@mail.com')
                    ->setEmailSubscriptions(
                        EmailSubscriptions::make(
                            EmailSubscription::receiveRecommendations(true),
                            EmailSubscription::trackManagedCampaigns(true),
                            EmailSubscription::trackPositionChanges(true)
                        )
                    )
            )
            ->setSettings(
                ClientSettings::make(
                    ClientSetting::correctTyposAutomatically(true),
                    ClientSetting::displayStoreRating(true)
                )
            )
            ->create();

        // [ Post processing ]

        Checklists::checkResource($client, AgencyClient::class, [
            'ClientId' => 'required|integer',
            'Login' => 'required|string',
            'Password' => 'required|string',
            'Email' => 'required|string',
            'FirstName' => 'required|string',
            'LastName' => 'required|string',
            'Currency' => 'required|string:RUB,BYN,CHF,EUR,KZT,TRY,UAH,USD',
            'Grants.*.Privilege' => 'required|string:EDIT_CAMPAIGNS,IMPORT_XLS,TRANSFER_MONEY',
            'Grants.*.Value' => 'required|string:YES,NO',
            'Notification.Lang' => 'required|string:RU,UK,EN,TR',
            'Notification.SmsPhoneNumber' => 'string',
            'Notification.Email' => 'required|string',
            'Notification.EmailSubscriptions' => 'required|array',
            'Notification.EmailSubscriptions.*.Option' => 'required|string:RECEIVE_RECOMMENDATIONS,TRACK_MANAGED_CAMPAIGNS,TRACK_POSITION_CHANGES',
            'Notification.EmailSubscriptions.*.Value' => 'required|string:YES,NO',
            'Settings' => 'required|array',
            'Settings.*.Option' => 'required|string:CORRECT_TYPOS_AUTOMATICALLY,DISPLAY_STORE_RATING,SHARED_ACCOUNT_ENABLED',
            'Settings.*.Value' => 'required|string:YES,NO'
        ]);

        return $client->getResource();
    }

    /*
     | Selection
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @return AgencyClients|ModelCollectionInterface
     */
    public function query(): AgencyClients
    {
        // [ Example ]

        $clients = AgencyClient::query()
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
            ->where('Archived', 'NO')
            ->limit(5)
            ->get();

        // [ Post processing ]

        Checklists::checkModelCollection($clients, AgencyClients::class, [
            'AccountQuality' => 'float',
            'Archived' => 'required|string:YES,NO',
            'ClientId' => 'required|integer',
            'ClientInfo' => 'required|string',
            'CountryId' => 'integer',
            'CreatedAt' => 'required|date',
            'Login' => 'required|string',
            'Currency' => 'required|string:RUB,BYN,CHF,EUR,KZT,TRY,UAH,USD',
            'Grants.*.Privilege' => 'required|string:EDIT_CAMPAIGNS,IMPORT_XLS,TRANSFER_MONEY',
            'Grants.*.Value' => 'required|string:YES,NO',
            'Grants.*.Agency' => 'required|string',
            'Notification.Lang' => 'required|string:RU,UK,EN,TR',
            'Notification.SmsPhoneNumber' => 'string',
            'Notification.Email' => 'required|string',
            'Notification.EmailSubscriptions' => 'required|array',
            'Notification.EmailSubscriptions.*.Option' => 'required|string:RECEIVE_RECOMMENDATIONS,TRACK_MANAGED_CAMPAIGNS,TRACK_POSITION_CHANGES',
            'Notification.EmailSubscriptions.*.Value' => 'required|string:YES,NO',
            'Phone' => 'string',
            'OverdraftSumAvailable' => 'integer',
            'Representatives' => 'required|array',
            'Representatives.*.Email' => 'required|string',
            'Representatives.*.Login' => 'required|string',
            'Representatives.*.Role' => 'required|string:CHIEF,DELEGATE,UNKNOWN',
            'Restrictions' => 'required|array',
            'Restrictions.*.Element' => 'required|string:CAMPAIGNS_TOTAL_PER_CLIENT,CAMPAIGNS_UNARCHIVED_PER_CLIENT,ADGROUPS_TOTAL_PER_CAMPAIGN,ADS_TOTAL_PER_ADGROUP,KEYWORDS_TOTAL_PER_ADGROUP,AD_EXTENSIONS_TOTAL,STAT_REPORTS_TOTAL_IN_QUEUE,FORECAST_REPORTS_TOTAL_IN_QUEUE,WORDSTAT_REPORTS_TOTAL_IN_QUEUE,API_POINTS',
            'Restrictions.*.Value' => 'required|integer',
            'Settings' => 'required|array',
            'Settings.*.Option' => 'required|string:CORRECT_TYPOS_AUTOMATICALLY,DISPLAY_STORE_RATING,SHARED_ACCOUNT_ENABLED',
            'Settings.*.Value' => 'required|string:YES,NO',
            'Type' => 'required|string',
            'VatRate' => 'required|float'
        ]);

        return $clients;
    }

    /**
     * @test
     * @return AgencyClient|ModelInterface
     */
    public function first(): AgencyClient
    {
        // [ Example ]

        $client = AgencyClient::query()
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

        Checklists::checkModel($client, AgencyClient::class, [
            'AccountQuality' => 'float',
            'Archived' => 'required|string:YES,NO',
            'ClientId' => 'required|integer',
            'ClientInfo' => 'required|string',
            'CountryId' => 'integer',
            'CreatedAt' => 'required|date',
            'Login' => 'required|string',
            'Currency' => 'required|string:RUB,BYN,CHF,EUR,KZT,TRY,UAH,USD',
            'Grants.*.Privilege' => 'required|string:EDIT_CAMPAIGNS,IMPORT_XLS,TRANSFER_MONEY',
            'Grants.*.Value' => 'required|string:YES,NO',
            'Grants.*.Agency' => 'required|string',
            'Notification.Lang' => 'required|string:RU,UK,EN,TR',
            'Notification.SmsPhoneNumber' => 'string',
            'Notification.Email' => 'required|string',
            'Notification.EmailSubscriptions' => 'required|array',
            'Notification.EmailSubscriptions.*.Option' => 'required|string:RECEIVE_RECOMMENDATIONS,TRACK_MANAGED_CAMPAIGNS,TRACK_POSITION_CHANGES',
            'Notification.EmailSubscriptions.*.Value' => 'required|string:YES,NO',
            'Phone' => 'string',
            'OverdraftSumAvailable' => 'integer',
            'Representatives' => 'required|array',
            'Representatives.*.Email' => 'required|string',
            'Representatives.*.Login' => 'required|string',
            'Representatives.*.Role' => 'required|string:CHIEF,DELEGATE,UNKNOWN',
            'Restrictions' => 'required|array',
            'Restrictions.*.Element' => 'required|string:CAMPAIGNS_TOTAL_PER_CLIENT,CAMPAIGNS_UNARCHIVED_PER_CLIENT,ADGROUPS_TOTAL_PER_CAMPAIGN,ADS_TOTAL_PER_ADGROUP,KEYWORDS_TOTAL_PER_ADGROUP,AD_EXTENSIONS_TOTAL,STAT_REPORTS_TOTAL_IN_QUEUE,FORECAST_REPORTS_TOTAL_IN_QUEUE,WORDSTAT_REPORTS_TOTAL_IN_QUEUE,API_POINTS',
            'Restrictions.*.Value' => 'required|integer',
            'Settings' => 'required|array',
            'Settings.*.Option' => 'required|string:CORRECT_TYPOS_AUTOMATICALLY,DISPLAY_STORE_RATING,SHARED_ACCOUNT_ENABLED',
            'Settings.*.Value' => 'required|string:YES,NO',
            'Type' => 'required|string',
            'VatRate' => 'required|float'
        ]);
        return $client;
    }

    /**
     * @test
     * @depends first
     * @param AgencyClient $client
     * @return void
     */
    public function findModel(AgencyClient $client):void
    {
        $login = $client->getLogin();

        // [ Example ]

        $client = AgencyClient::find($login, ["ClientId", "ClientInfo"]);

        // [ Post processing ]

        Checklists::checkModel($client, AgencyClient::class, [
            'ClientId' => 'required|integer',
            'Login' => 'required|string',
            'ClientInfo' => 'required|string'
        ]);
    }

    /**
     * @test
     * @depends query
     * @param AgencyClients $clients
     * @return void
     */
    public function findModels(AgencyClients $clients):void
    {
        $logins = $clients->extract('login');

        // [ Example ]

        $client = AgencyClient::find($logins, ["ClientId", "ClientInfo"]);

        // [ Post processing ]

        Checklists::checkModelCollection($client, AgencyClients::class, [
            'ClientId' => 'required|integer',
            'Login' => 'required|string',
            'ClientInfo' => 'required|string'
        ]);
    }

    /*
     | Update
     | -------------------------------------------------------------------------------
     */

    /**
     * @test
     * @depends create
     * @param AgencyClient $client
     * @return void
     */
    public function update(AgencyClient $client)
    {
        // [ Example ]

        $result = $client
            ->setClientInfo('Maxim')
            ->setPhone('79001234567')
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

        Checklists::checkResource($result, AgencyClients::class, [
            'ClientInfo' => 'string:Maxim',
            'Phone' => 'string:79001234567',
            'Notification.Lang' => 'required|string:EN',
            'Notification.Email' => 'required|string:client@mail.com',
            'Notification.EmailSubscriptions.*.Option' => 'required|string:RECEIVE_RECOMMENDATIONS,TRACK_MANAGED_CAMPAIGNS,TRACK_POSITION_CHANGES',
            'Notification.EmailSubscriptions.*.Value' => 'required|string:NO',
            'Settings.*.Option' => 'required|string:CORRECT_TYPOS_AUTOMATICALLY,DISPLAY_STORE_RATING,SHARED_ACCOUNT_ENABLED',
            'Settings.*.Value' => 'required|string:NO',
        ]);
    }
}