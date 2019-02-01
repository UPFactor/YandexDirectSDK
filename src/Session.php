<?php

namespace YandexDirectSDK;

/**
 * Class Session
 *
 * @property-read \YandexDirectSDK\Services\ServiceCampaigns             campaigns
 * @property-read \YandexDirectSDK\Services\ServiceAdGroups              adGroups
 * @property-read \YandexDirectSDK\Services\ServiceAds                   ads
 * @property-read \YandexDirectSDK\Services\ServiceAds                   keywords
 * @property-read \YandexDirectSDK\Services\ServiceBids                  bids
 * @property-read \YandexDirectSDK\Services\ServiceKeywordBids           keywordBids
 * @property-read \YandexDirectSDK\Services\ServiceBidModifiers          bidModifiers
 * @property-read \YandexDirectSDK\Services\ServiceAudienceTargets       audienceTargets
 * @property-read \YandexDirectSDK\Services\ServiceRetargetingLists      retargetingLists
 * @property-read \YandexDirectSDK\Services\ServiceVCards                vCards
 * @property-read \YandexDirectSDK\Services\ServiceSitelinks             siteLinks
 * @property-read \YandexDirectSDK\Services\ServiceAdImages              adImages
 * @property-read \YandexDirectSDK\Services\ServiceAdExtensions          adExtensions
 * @property-read \YandexDirectSDK\Services\ServiceDynamicTextAdTargets  dynamicTextAdTargets
 * @property-read \YandexDirectSDK\Services\ServiceChanges               changes
 * @property-read \YandexDirectSDK\Services\ServiceDictionaries          dictionaries
 * @property-read \YandexDirectSDK\Services\ServiceClients               clients
 * @property-read \YandexDirectSDK\Services\ServiceAgencyClients         agencyClients
 * @property-read \YandexDirectSDK\Services\ServiceKeywordsResearch      keywordsResearch
 * @property-read \YandexDirectSDK\Services\ServiceLeads                 leads
 *
 * @package YandexDirectSDK
 */
class Session
{
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
     * @param string $name API service name
     * @return null
     */
    public function __get($name){
        $name = 'YandexDirectSDK\Services\Service'.ucfirst($name);
        if (class_exists($name)) {
            return new $name($this);
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
    public function call($service, $method, array $params = array()){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, ($this->sandbox ? static::sandboxApi : static::api).$service);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('method' => (string) $method,'params' => $params),JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
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