<?php

namespace YandexDirectSDK;

use Exception;
use YandexDirectSDK\Common\File;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;
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
use YandexDirectSDK\Services\CreativesService;
use YandexDirectSDK\Services\DictionariesService;
use YandexDirectSDK\Services\DynamicTextAdTargetsService;
use YandexDirectSDK\Services\KeywordBidsService;
use YandexDirectSDK\Services\KeywordsResearchService;
use YandexDirectSDK\Services\KeywordsService;
use YandexDirectSDK\Services\LeadsService;
use YandexDirectSDK\Services\ReportsService;
use YandexDirectSDK\Services\RetargetingListsService;
use YandexDirectSDK\Services\SitelinksService;
use YandexDirectSDK\Services\TurboPagesService;
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
     * @return static|null
     * @throws RuntimeException
     */
    public static function init()
    {
        $sessionConf = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'.YDSession';
        if (file_exists($sessionConf)){
            $sessionConf = json_decode(@file_get_contents($sessionConf));
            if (json_last_error() === JSON_ERROR_NONE){
                return new static(($sessionConf['token'] ?? ''), ($sessionConf['options'] ?? []));
            }
        }
        return null;
    }


    /**
     * Create Session instance.
     *
     * @param string $token
     * @param array $options
     * @return static
     * @throws RuntimeException
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
     * @throws RuntimeException
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
    public function getClient()
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
     * @throws RuntimeException
     */
    public function useLogFile(bool $switch, string $pathToFile = null)
    {
        if ($switch){
            try {
                $this->logFile = File::bind($pathToFile)->existsOrCreate();
            } catch (Exception $error){
                throw RuntimeException::make(static::class."::useLogFile. {$error->getMessage()}");
            }
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
    public function getCampaignsService(): CampaignsService
    {
        return (new CampaignsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [AdGroupsService].
     *
     * @return AdGroupsService
     */
    public function getAdGroupsService(): AdGroupsService
    {
        return (new AdGroupsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [AdsService].
     *
     * @return AdsService
     */
    public function getAdsService(): AdsService
    {
        return (new AdsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [KeywordsService].
     *
     * @return KeywordsService
     */
    public function getKeywordsService(): KeywordsService
    {
        return (new KeywordsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [BidsService].
     *
     * @return BidsService
     */
    public function getBidsService(): BidsService
    {
        return (new BidsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [KeywordBidsService].
     *
     * @return KeywordBidsService
     */
    public function getKeywordBidsService(): KeywordBidsService
    {
        return (new KeywordBidsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [BidModifiersService].
     *
     * @return BidModifiersService
     */
    public function getBidModifiersService(): BidModifiersService
    {
        return (new BidModifiersService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [AudienceTargetsService].
     *
     * @return AudienceTargetsService
     */
    public function getAudienceTargetsService(): AudienceTargetsService
    {
        return (new AudienceTargetsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [RetargetingListsService].
     *
     * @return RetargetingListsService
     */
    public function getRetargetingListsService(): RetargetingListsService
    {
        return (new RetargetingListsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [VCardsService].
     *
     * @return VCardsService
     */
    public function getVCardsService(): VCardsService
    {
        return (new VCardsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [SitelinksService].
     *
     * @return SitelinksService
     */
    public function getSitelinksService(): SitelinksService
    {
        return (new SitelinksService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [AdImagesService].
     *
     * @return AdImagesService
     */
    public function getAdImagesService(): AdImagesService
    {
        return (new AdImagesService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [AdExtensionsService].
     *
     * @return AdExtensionsService
     */
    public function getAdExtensionsService(): AdExtensionsService
    {
        return (new AdExtensionsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [DynamicTextAdTargetsService].
     *
     * @return DynamicTextAdTargetsService
     */
    public function getDynamicTextAdTargetsService(): DynamicTextAdTargetsService
    {
        return (new DynamicTextAdTargetsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [ChangesService].
     *
     * @return ChangesService
     */
    public function getChangesService(): ChangesService
    {
        return (new ChangesService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [DictionariesService].
     *
     * @return DictionariesService
     */
    public function getDictionariesService(): DictionariesService
    {
        return (new DictionariesService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [ClientsService].
     *
     * @return ClientsService
     */
    public function getClientsService(): ClientsService
    {
        return (new ClientsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [AgencyClientsService].
     *
     * @return AgencyClientsService
     */
    public function getAgencyClientsService(): AgencyClientsService
    {
        return (new AgencyClientsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [KeywordsResearchService].
     *
     * @return KeywordsResearchService
     */
    public function getKeywordsResearchService(): KeywordsResearchService
    {
        return (new KeywordsResearchService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [LeadsService].
     *
     * @return LeadsService
     */
    public function getLeadsService(): LeadsService
    {
        return (new LeadsService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [CreativesService].
     *
     * @return CreativesService
     */
    public function getCreativesService(): CreativesService
    {
        return (new CreativesService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [TurboPagesService].
     *
     * @return TurboPagesService
     */
    public function getTurboPagesService(): TurboPagesService
    {
        return (new TurboPagesService())->setSession($this);
    }

    /**
     * Returns a new instance of the service-provider [ReportsService].
     *
     * @param string $reportName
     * @param string $reportType
     * @return ReportsService
     */
    public function getReportsService(string $reportName, string $reportType='CUSTOM_REPORT'): ReportsService
    {
        return (new ReportsService($reportName, $reportType))->setSession($this);
    }

    /**
     * Call to services API.
     *
     * @param string $service API service name
     * @param string $method API service method
     * @param array $params API service parameters
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function call($service, $method, $params = []): Result
    {

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

        $requestID = str_replace(['.',' '], '', microtime());

        $this->requestLogging($requestID, $url, $params);

        try {
            $result = new Result($curl);
        } catch (RequestException $exception){
            $this->exceptionLogging($requestID, $exception);
            throw $exception;
        }

        $this->responseLogging($requestID, $result);
        $this->errorLogging($requestID, $result);
        $this->warningLogging($requestID, $result);

        return $result;
    }

    /**
     * Logging information about the request.
     *
     * @param string $requestID
     * @param string $url
     * @param string $params
     */
    protected function requestLogging($requestID, $url, $params): void
    {
        if (is_null($this->logFile)){
            return;
        }

        try {
            $this->logFile->append("{$requestID}\t" . date('Y-m-d H:i:s') . "\trequest\tsandbox:{$this->useSandbox}\tclient:{$this->client}\turl:{$url}\tparams:{$params}\n");
        } catch (Exception $error) {
            throw RuntimeException::make(static::class."::requestLogging. {$error->getMessage()}");
        }
    }

    /**
     * Logging information about the response.
     *
     * @param string $requestID
     * @param Result $result
     */
    protected function responseLogging($requestID, Result $result): void
    {
        if (is_null($this->logFile)){
            return;
        }

        try {
            $this->logFile->append("{$requestID}\t" . date('Y-m-d H:i:s') . "\tresponse\tsandbox:{$this->useSandbox}\tclient:{$this->client}\trequestId:{$result->requestId}\terrors:{$result->errors->count()}\twarnings:{$result->warnings->count()}\tunitsUsedLogin:{$result->unitsUsedLogin}\tunitsSpent:{$result->unitsSpent}\tunitsBalance:{$result->unitsBalance}\tunitsLimit:{$result->unitsLimit}\n");
        } catch (Exception $error) {
            throw RuntimeException::make(static::class."::responseLogging. {$error->getMessage()}");
        }
    }

    /**
     * Logging information about fatal errors.
     *
     * @param string $requestID
     * @param Exception $exception
     */
    protected function exceptionLogging($requestID, Exception $exception): void
    {
        if (is_null($this->logFile)){
            return;
        }

        try {
            $this->logFile->append("{$requestID}\t" . date('Y-m-d H:i:s') . "\tfatal error\tsandbox:{$this->useSandbox}\tclient:{$this->client}\tcode:{$exception->getCode()}\tmessage:{$exception->getMessage()}\n");
        } catch (Exception $error) {
            throw RuntimeException::make(static::class."::exceptionLogging. {$error->getMessage()}");
        }
    }

    /**
     * Logging error information when executing a request.
     *
     * @param string $requestID
     * @param Result $result
     */
    protected function errorLogging($requestID, Result $result): void
    {
        if (is_null($this->logFile) or $result->errors->isEmpty()){
            return;
        }

        $line = "{$requestID}\t" . date('Y-m-d H:i:s') . "\terror\tsandbox:{$this->useSandbox}\tclient:{$this->client}";
        $content = '';

        $result->errors->each(function($errors) use ($line, &$content){
            foreach ($errors as $error){
                $message = "{$error['message']}." . (empty($error['detail']) ? '' : "{$error['detail']}.");
                $content .= "{$line}\tcode:{$error['code']}\tmessage:{$message}\n";
            }
        });

        try {
            if (!empty($content)) {
                $this->logFile->append($content);
            }
        } catch (Exception $result) {
            throw RuntimeException::make(static::class."::errorLogging. {$result->getMessage()}");
        }
    }

    /**
     * Logging warning information when executing a request.
     *
     * @param string $requestID
     * @param Result $result
     */
    protected function warningLogging($requestID, Result $result): void
    {
        if (is_null($this->logFile) or $result->warnings->isEmpty()){
            return;
        }

        $line = "{$requestID}\t" . date('Y-m-d H:i:s') . "\twarning\tsandbox:{$this->useSandbox}\tclient:{$this->client}";
        $content = '';

        $result->warnings->each(function($warnings) use ($line, &$content){
            foreach ($warnings as $warning){
                $message = "{$warning['message']}." . (empty($warning['detail']) ? '' : "{$warning['detail']}.");
                $content .= "{$line}\tcode:{$warning['code']}\tmessage:{$message}\n";
            }
        });

        try {
            if (!empty($content)) {
                $this->logFile->append($content);
            }
        } catch (Exception $error) {
            throw RuntimeException::make(static::class."::warningLogging. {$error->getMessage()}");
        }
    }
}