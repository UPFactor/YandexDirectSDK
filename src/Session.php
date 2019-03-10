<?php

namespace YandexDirectSDK;

use Exception;
use YandexDirectSDK\Common\File;
use YandexDirectSDK\Components\Data;
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
    const version = '1.2.0';

    /**
     * API URL v5
     *
     * @var string
     */
    protected const api = 'https://api.direct.yandex.com/json/v5/';

    /**
     * URL API v5 for sandbox
     *
     * @var string
     */
    protected const sandboxApi = 'https://api-sandbox.direct.yandex.com/json/v5/';

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
    protected $client = '';

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
    protected $useSandbox = false;

    /**
     * Log file.
     *
     * @var File|null
     */
    protected $logFile;

    /**
     * Create Session instance.
     *
     * @param array $params
     * @return Session
     * @throws Exception
     */
    public static function make(array $params){
        return new static($params);
    }

    /**
     * Create Session instance.
     *
     * @param array $params
     * @throws Exception
     */
    public function __construct(array $params){
        if (!empty($params['token'])) $this->setToken($params['token']);
        if (!empty($params['client'])) $this->setClient($params['client']);
        if (!empty($params['language'])) $this->setLanguage($params['language']);
        if (!empty($params['sandbox'])) $this->useSandbox($params['sandbox']);
        if (!empty($params['operatorUnits'])) $this->useOperatorUnits($params['operatorUnits']);
        if (!empty($params['logFile'])) $this->useLogFile(true, $params['logFile']);
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
     * Sets OAuth token.
     *
     * @param string $token
     * @return $this
     */
    public function setToken(string $token){
        $this->token = $token;
        return $this;
    }

    /**
     * Sets login advertiser - client advertising agency.
     *
     * @param string $client
     * @return $this
     */
    public function setClient(string $client){
        $this->client = $client;
        return $this;
    }

    /**
     * Sets language of response messages.
     *
     * @param string $language
     * @return $this
     */
    public function setLanguage(string $language){
        $this->language = $language;
        return $this;
    }

    /**
     * Retrieve OAuth token.
     *
     * @return string
     */
    public function getToken(){
        return $this->token;
    }

    /**
     * Retrieve login advertiser - client advertising agency.
     *
     * @return string
     */
    public function getClientLogin(){
        return $this->client;
    }

    /**
     * Retrieve language of response messages.
     *
     * @return string
     */
    public function getLanguage(){
        return $this->language;
    }

    /**
     * Switch on/off sandbox mode.
     *
     * @param bool $switch
     * @return $this
     */
    public function useSandbox(bool $switch){
        $this->useSandbox = $switch;
        return $this;
    }

    /**
     * Switch on/off mode in which the points of the agency,
     * and not the advertiser are spent when executing the request.
     *
     * @param bool $switch
     * @return $this
     */
    public function useOperatorUnits(bool $switch){
        $this->useOperatorUnits = $switch;
        return $this;
    }

    /**
     * Switch on/off logging to file
     *
     * @param bool $switch
     * @param string|null $pathToFile
     * @return $this
     * @throws Exception
     */
    public function useLogFile(bool $switch, string $pathToFile = null){
        if ($switch){
            $this->logFile = File::bind($pathToFile)->existsOrCreate();
        } else {
            $this->logFile = null;
        }
        return $this;
    }

    /**
     * Get the value of all properties.
     *
     * @return array
     */
    public function fetch(){
        return [
            'token' => $this->token,
            'language' => $this->language,
            'client' => $this->client,
            'operatorUnits' => $this->useOperatorUnits,
            'sandbox' => $this->useSandbox,
            'logFile' => is_null($this->logFile) ? $this->logFile : $this->logFile->realPath
        ];
    }

    /**
     * Call to services API.
     *
     * @param string $service API service name
     * @param string $method API service method
     * @param array $params API service parameters
     * @return Result
     * @throws Exception
     */
    public function call($service, $method, $params = array()){

        if (key_exists('SelectionCriteria', $params)){
            $params['SelectionCriteria'] = (object) $params['SelectionCriteria'];
        }

        $url = ($this->useSandbox ? static::sandboxApi : static::api).$service;
        $params = json_encode(['method' => (string) $method,'params' => $params], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$this->token,
            'Accept-Language: '.$this->language,
            'Client-Login: '.$this->client,
            'Use-Operator-Units: '.$this->useOperatorUnits,
            'Content-Type: application/json; charset=utf-8'
        ));

        $this->requestLogging($url, $params);

        try {
            $result = new Result($curl);
        } catch (Exception $exception){
            $this->exceptionLogging($exception);
            throw $exception;
        }

        $this->errorLogging($result->errors);
        $this->warningLogging($result->warnings);

        return $result;
    }

    /**
     * Logging information about the request.
     *
     * @param string $url
     * @param string $params
     * @throws Exception
     */
    protected function requestLogging($url, $params)
    {
        if (is_null($this->logFile)){
            return;
        }

        $line = date('Y-m-d H:i:s') . "\t";
        $line .= "request\t";
        $line .= "sandbox:{$this->useSandbox}\t";
        $line .= "client:{$this->client}\t";
        $line .= "url:{$url}\t";
        $line .= "params:{$params}\n";

        $this->logFile->append($line);
    }

    /**
     * Logging information about fatal errors.
     *
     * @param Exception $exception
     * @throws Exception
     */
    protected function exceptionLogging(Exception $exception)
    {
        if (is_null($this->logFile)){
            return;
        }

        $line = date('Y-m-d H:i:s') . "\t";
        $line .= "fatal error\t";
        $line .= "sandbox:{$this->useSandbox}\t";
        $line .= "client:{$this->client}\t";
        $line .= "message:{$exception->getMessage()}\n";

        $this->logFile->append($line);
    }

    /**
     * Logging error information when executing a request.
     *
     * @param Data $error
     * @throws Exception
     */
    protected function errorLogging(Data $error)
    {
        if (is_null($this->logFile) or $error->isEmpty()){
            return;
        }

        $line = date('Y-m-d H:i:s') . "\t";
        $line .= "error\t";
        $line .= "sandbox:{$this->useSandbox}\t";
        $line .= "client:{$this->client}\t";

        $error->each(function($errors) use ($line){
            foreach ($errors as $error){
                $this->logFile->append($line."message:{$error['message']}.".(empty($error['detail']) ? "" : "{$error['detail']}.")."\n");
            }
        });
    }

    /**
     * Logging warning information when executing a request.
     *
     * @param Data $warning
     * @throws Exception
     */
    protected function warningLogging(Data $warning){
        if (is_null($this->logFile) or $warning->isEmpty()){
            return;
        }

        $line = date('Y-m-d H:i:s') . "\t";
        $line .= "warning\t";
        $line .= "sandbox:{$this->useSandbox}\t";
        $line .= "client:{$this->client}\t";

        $warning->each(function($warnings) use ($line){
            foreach ($warnings as $warning){
                $this->logFile->append($line."message:{$warning['message']}.".(empty($warning['detail']) ? "" : "{$warning['detail']}.")."\n");
            }
        });
    }
}