<?php

namespace YandexDirectSDK;

use YandexDirectSDK\Components\Result;

/**
 * Class Session
 *
 * @property-read \YandexDirectSDK\Services\CampaignsService             campaignsService
 * @property-read \YandexDirectSDK\Services\AdGroupsService              adGroupsService
 * @property-read \YandexDirectSDK\Services\AdsService                   adsService
 * @property-read \YandexDirectSDK\Services\AdsService                   keywordsService
 * @property-read \YandexDirectSDK\Services\BidsService                  bidsService
 * @property-read \YandexDirectSDK\Services\KeywordBidsService           keywordBidsService
 * @property-read \YandexDirectSDK\Services\BidModifiersService          bidModifiersService
 * @property-read \YandexDirectSDK\Services\AudienceTargetsService       audienceTargetsService
 * @property-read \YandexDirectSDK\Services\RetargetingListsService      retargetingListsService
 * @property-read \YandexDirectSDK\Services\VCardsService                vCardsService
 * @property-read \YandexDirectSDK\Services\SitelinksService             siteLinksService
 * @property-read \YandexDirectSDK\Services\AdImagesService              adImagesService
 * @property-read \YandexDirectSDK\Services\AdExtensionsService          adExtensionsService
 * @property-read \YandexDirectSDK\Services\DynamicTextAdTargetsService  dynamicTextAdTargetsService
 * @property-read \YandexDirectSDK\Services\ChangesService               changesService
 * @property-read \YandexDirectSDK\Services\DictionariesService          dictionariesService
 * @property-read \YandexDirectSDK\Services\ClientsService               clientsService
 * @property-read \YandexDirectSDK\Services\AgencyClientsService         agencyClientsService
 * @property-read \YandexDirectSDK\Services\KeywordsResearchService      keywordsResearchService
 * @property-read \YandexDirectSDK\Services\LeadsService                 leadsService
 *
 * @method \YandexDirectSDK\Services\ReportsService                      reportsService(string $reportName, string $reportType='CUSTOM_REPORT')
 *
 * @package YandexDirectSDK
 */
class Session
{
    /**
     * YandexDirectSDK version.
     *
     * @var string
     */
    const version = '1.0.0';

    /**
     * API URL v5
     *
     * @var string
     */
    const api = 'https://api.direct.yandex.com/json/v5/';

    /**
     * URL API v5 for sandbox
     *
     * @var string
     */
    const sandboxApi = 'https://api-sandbox.direct.yandex.com/json/v5/';

    /**
     * The OAuth token of the Yandex.Direct user on whose
     * behalf the request to the API is made.
     *
     * @var string
     */
    protected $token = '';

    /**
     * The language of response messages.
     * In the selected language, textual explanations of the statuses of the objects,
     * the texts of errors and warnings are returned.
     *
     * @var string
     */
    protected $language = 'en';

    /**
     * Login advertiser - client advertising agency.
     * Mandatory if the request is made on behalf of the agency.
     *
     * @var string
     */
    protected $login = '';

    /**
     * The mode in which the points of the agency, and not the advertiser,
     * are spent when executing the request
     *
     * @var bool
     */
    protected $useOperatorUnits =  true;

    /**
     * Sandbox mode.
     *
     * @var bool
     */
    protected $sandbox = false;

    /**
     * Create Session instance.
     *
     * @param array $params
     * @return Session
     */
    public static function make(array $params){
        return new static($params);
    }

    /**
     * Create Session instance.
     *
     * @param array $params
     */
    public function __construct(array $params){
        if (!empty($params['token']) and is_string($params['token'])){
            $this->token = $params['token'];
        }

        if (!empty($params['client']) and is_string($params['client'])){
            $this->client = $params['client'];
        }

        if (!empty($params['language']) and is_string($params['language'])){
            $this->language = $params['language'];
        }

        if (isset($params['sandbox']) and $params['sandbox'] === true){
            $this->sandbox = true;
        }
    }

    /**
     * Dynamic gets of management objects for API services.
     *
     * @param string $serviceName service name
     * @return null
     */
    public function __get($serviceName)
    {
        $serviceName = __NAMESPACE__.'\Services\\' . ucfirst($serviceName);

        if (class_exists($serviceName)) {
            return new $serviceName($this);
        }
        return null;
    }

    /**
     * Dynamic call of management objects for API services.
     *
     * @param string $serviceName service name
     * @param array $arguments
     * @return null
     */
    public function __call($serviceName, $arguments)
    {
        $serviceName = __NAMESPACE__.'\Services\\' . ucfirst($serviceName);

        if (class_exists($serviceName)) {
            return new $serviceName($this, ...$arguments);
        }
        return null;
    }

    /**
     * Call to services API.
     *
     * @param string $service API service name
     * @param string $method API service method
     * @param array $params API service parameters
     * @return Result
     */
    public function call($service, $method, $params = array()){

        if (key_exists('SelectionCriteria', $params)){
            $params['SelectionCriteria'] = (object) $params['SelectionCriteria'];
        }

        $params = json_encode(
            ['method' => (string) $method,'params' => $params],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, ($this->sandbox ? static::sandboxApi : static::api).$service);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$this->token,
            'Accept-Language: '.$this->language,
            'Client-Login: '.$this->login,
            'Use-Operator-Units: '.$this->useOperatorUnits,
            'Content-Type: application/json; charset=utf-8'
        ));

        return new Result($curl);
    }
}