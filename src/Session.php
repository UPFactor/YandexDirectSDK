<?php

namespace YandexDirectSDK;

use Exception;
use YandexDirectSDK\Common\File;
use YandexDirectSDK\Components\Data;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Services\AdExtensionsService;
use YandexDirectSDK\Services\AdGroupsService;
use YandexDirectSDK\Services\AdImagesService;
use YandexDirectSDK\Services\AdsService;
use YandexDirectSDK\Services\AgencyClientsService;
use YandexDirectSDK\Services\AudienceTargetsService;
use YandexDirectSDK\Services\BidModifiersService;
use YandexDirectSDK\Services\BidsService;
use YandexDirectSDK\Services\CampaignsService;
use YandexDirectSDK\Services\ChangesService;
use YandexDirectSDK\Services\ClientsService;
use YandexDirectSDK\Services\DictionariesService;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;
use YandexDirectSDK\Services\KeywordBidsService;
use YandexDirectSDK\Services\KeywordsResearchService;
use YandexDirectSDK\Services\KeywordsService;
use YandexDirectSDK\Services\LeadsService;
use YandexDirectSDK\Services\ReportsService;
use YandexDirectSDK\Services\RetargetingListsService;
use YandexDirectSDK\Services\SitelinksService;
use YandexDirectSDK\Services\VCardsService;

/**
 * Class Session
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
     * @param string $token
     * @param array $options
     * @return Session
     * @throws Exception
     */
    public static function make(string $token, array $options = [])
    {
        return new static($token, $options);
    }

    /**
     * Create Session instance.
     *
     * @param string $token
     * @param array $options
     * @throws Exception
     */
    public function __construct(string $token, array $options = [])
    {
        $this->setToken($token);

        foreach ($options as $option => $value){
            switch ($option){
                case 'client': $this->setClient($value); break;
                case 'language': $this->setLanguage($value); break;
                case 'sandbox': $this->useSandbox($value); break;
                case 'operatorUnits': $this->useOperatorUnits($value); break;
                case 'logFile': $this->useLogFile(true, $value); break;
            }
        }
    }

    /**
     * Sets OAuth token.
     *
     * @param string $token
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Sets login advertiser - client advertising agency.
     *
     * @param string $client
     * @return $this
     */
    public function setClient(string $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Sets language of response messages.
     *
     * @param string $language
     * @return $this
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Retrieve OAuth token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Retrieve login advertiser - client advertising agency.
     *
     * @return string
     */
    public function getClientLogin()
    {
        return $this->client;
    }

    /**
     * Retrieve language of response messages.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Switch on/off sandbox mode.
     *
     * @param bool $switch
     * @return $this
     */
    public function useSandbox(bool $switch)
    {
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
    public function useOperatorUnits(bool $switch)
    {
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
    public function useLogFile(bool $switch, string $pathToFile = null)
    {
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
    public function fetch()
    {
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
     * Returns a new instance of the service-provider [CampaignsService].
     *
     * @return CampaignsService
     */
    public function getCampaignsService(){
        return new CampaignsService($this);
    }

    /**
     * Returns a new instance of the service-provider [AdGroupsService].
     *
     * @return AdGroupsService
     */
    public function getAdGroupsService(){
        return new AdGroupsService($this);
    }

    /**
     * Returns a new instance of the service-provider [AdsService].
     *
     * @return AdsService
     */
    public function getAdsService(){
        return new AdsService($this);
    }

    /**
     * Returns a new instance of the service-provider [KeywordsService].
     *
     * @return KeywordsService
     */
    public function getKeywordsService(){
        return new KeywordsService($this);
    }

    /**
     * Returns a new instance of the service-provider [BidsService].
     *
     * @return BidsService
     */
    public function getBidsService(){
        return new BidsService($this);
    }

    /**
     * Returns a new instance of the service-provider [KeywordBidsService].
     *
     * @return KeywordBidsService
     */
    public function getKeywordBidsService(){
        return new KeywordBidsService($this);
    }

    /**
     * Returns a new instance of the service-provider [BidModifiersService].
     *
     * @return BidModifiersService
     */
    public function getBidModifiersService(){
        return new BidModifiersService($this);
    }

    /**
     * Returns a new instance of the service-provider [AudienceTargetsService].
     *
     * @return AudienceTargetsService
     */
    public function getAudienceTargetsService(){
        return new AudienceTargetsService($this);
    }

    /**
     * Returns a new instance of the service-provider [RetargetingListsService].
     *
     * @return RetargetingListsService
     */
    public function getRetargetingListsService(){
        return new RetargetingListsService($this);
    }

    /**
     * Returns a new instance of the service-provider [VCardsService].
     *
     * @return VCardsService
     */
    public function getVCardsService(){
        return new VCardsService($this);
    }

    /**
     * Returns a new instance of the service-provider [SitelinksService].
     *
     * @return SitelinksService
     */
    public function getSitelinksService(){
        return new SitelinksService($this);
    }

    /**
     * Returns a new instance of the service-provider [AdImagesService].
     *
     * @return AdImagesService
     */
    public function getAdImagesService(){
        return new AdImagesService($this);
    }

    /**
     * Returns a new instance of the service-provider [AdExtensionsService].
     *
     * @return AdExtensionsService
     */
    public function getAdExtensionsService(){
        return new AdExtensionsService($this);
    }

    /**
     * Returns a new instance of the service-provider [DynamicTextAdTargetsService].
     *
     * @return DynamicTextAdTargetsService
     */
    public function getDynamicTextAdTargetsService(){
        return new DynamicTextAdTargetsService($this);
    }

    /**
     * Returns a new instance of the service-provider [ChangesService].
     *
     * @return ChangesService
     */
    public function getChangesService(){
        return new ChangesService($this);
    }

    /**
     * Returns a new instance of the service-provider [DictionariesService].
     *
     * @return DictionariesService
     */
    public function getDictionariesService(){
        return new DictionariesService($this);
    }

    /**
     * Returns a new instance of the service-provider [ClientsService].
     *
     * @return ClientsService
     */
    public function getClientsService(){
        return new ClientsService($this);
    }

    /**
     * Returns a new instance of the service-provider [AgencyClientsService].
     *
     * @return AgencyClientsService
     */
    public function getAgencyClientsService(){
        return new AgencyClientsService($this);
    }

    /**
     * Returns a new instance of the service-provider [KeywordsResearchService].
     *
     * @return KeywordsResearchService
     */
    public function getKeywordsResearchService(){
        return new KeywordsResearchService($this);
    }

    /**
     * Returns a new instance of the service-provider [LeadsService].
     *
     * @return LeadsService
     */
    public function getLeadsService(){
        return new LeadsService($this);
    }

    /**
     * Returns a new instance of the service-provider [ReportsService].
     *
     * @param string $reportName
     * @param string $reportType
     * @return ReportsService
     */
    public function getReportsService(string $reportName, string $reportType='CUSTOM_REPORT'){
        return new ReportsService($this, $reportName, $reportType);
    }

    /**
     * Call to services API.
     *
     * @param string $service API service name
     * @param string $method API service method
     * @param array $params API service parameters
     * @return Result
     * @throws RequestException
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
        } catch (RequestException $exception){
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