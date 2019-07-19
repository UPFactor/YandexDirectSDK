<?php

namespace YandexDirectSDK\Services;

use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;
use YandexDirectSDK\Exceptions\InvalidArgumentException;
use YandexDirectSDK\Exceptions\RequestException;
use YandexDirectSDK\Exceptions\RuntimeException;

/** 
 * Class ReportsService 
 * 
 * @package YandexDirectSDK\Services 
 */
class ReportsService extends Service
{
    const ACCOUNT_PERFORMANCE_REPORT = 'ACCOUNT_PERFORMANCE_REPORT';
    const CAMPAIGN_PERFORMANCE_REPORT = 'CAMPAIGN_PERFORMANCE_REPORT';
    const ADGROUP_PERFORMANCE_REPORT = 'ADGROUP_PERFORMANCE_REPORT';
    const AD_PERFORMANCE_REPORT = 'AD_PERFORMANCE_REPORT';
    const CRITERIA_PERFORMANCE_REPORT = 'CRITERIA_PERFORMANCE_REPORT	';
    const CUSTOM_REPORT = 'CUSTOM_REPORT';
    const REACH_AND_FREQUENCY_PERFORMANCE_REPORT = 'REACH_AND_FREQUENCY_PERFORMANCE_REPORT';
    const SEARCH_QUERY_PERFORMANCE_REPORT = 'SEARCH_QUERY_PERFORMANCE_REPORT';

    protected static $validOperators = [
        'EQUALS',
        'NOT_EQUALS',
        'IN',
        'NOT_IN',
        'LESS_THAN',
        'GREATER_THAN',
        'STARTS_WITH_IGNORE_CASE',
        'DOES_NOT_START_WITH_IGNORE_CASE',
        'STARTS_WITH_ANY_IGNORE_CASE',
        'DOES_NOT_START_WITH_ALL_IGNORE_CASE'
    ];

    protected static $validSortingTypes = [
        'ASCENDING',
        'DESCENDING'
    ];

    protected static $validReportType = [
        'ACCOUNT_PERFORMANCE_REPORT',
        'CAMPAIGN_PERFORMANCE_REPORT',
        'ADGROUP_PERFORMANCE_REPORT',
        'AD_PERFORMANCE_REPORT',
        'CRITERIA_PERFORMANCE_REPORT	',
        'CUSTOM_REPORT',
        'REACH_AND_FREQUENCY_PERFORMANCE_REPORT',
        'SEARCH_QUERY_PERFORMANCE_REPORT'
    ];

    protected static $validDateRange = [
        'TODAY',
        'YESTERDAY',
        'LAST_3_DAYS',
        'LAST_5_DAYS',
        'LAST_7_DAYS',
        'LAST_14_DAYS',
        'LAST_30_DAYS',
        'LAST_90_DAYS',
        'LAST_365_DAYS',
        'THIS_WEEK_MON_TODAY',
        'THIS_WEEK_SUN_TODAY',
        'LAST_WEEK',
        'LAST_BUSINESS_WEEK',
        'LAST_WEEK_SUN_SAT',
        'THIS_MONTH',
        'LAST_MONTH',
        'ALL_TIME',
        'CUSTOM_DATE',
        'AUTO'
    ];

    /**
     * The service name.
     *
     * @var string
     */
    protected static $name = 'reports';

    /**
     * Report name.
     *
     * @var string
     */
    protected $reportName;

    /**
     * Report type.
     *
     * @var string
     */
    protected $reportType;

    /**
     * Selection fields.
     *
     * @var array
     */
    protected $selection = [];

    /**
     * The starting date of the reporting period.
     *
     * @var string|null
     */
    protected $dateFrom;

    /**
     * End date of the reporting period.
     *
     * @var string|null
     */
    protected $dateTo;

    /**
     * Period for which the report is generated.
     *
     * @var string
     */
    protected $dateRangeType = 'AUTO';

    /**
     * Selection criteria.
     *
     * @var array
     */
    protected $criteria = [];

    /**
     * Selection limit.
     *
     * @var integer
     */
    protected $limit = 0;

    /**
     * Selection order.
     *
     * @var array
     */
    protected $orders = [];

    /**
     * Target identifiers Yandex.Metrics for which you want to get statistics.
     *
     * @var array|null
     */
    protected $goals;

    /**
     * Attribution models used in the calculation of data on goals Yandex.Metrics.
     *
     * @var array|null
     */
    protected $attributionModels;

    /**
     * Whether to include VAT in the amount of money in the report.
     *
     * @var string
     */
    protected $includeVAT = 'NO';

    /**
     * Whether to consider a discount for monetary amounts in the report.
     *
     * @var string
     */
    protected $includeDiscount = 'NO';

    /**
     * Create Service instance.
     *
     * @param string $reportName
     * @param string $reportType
     * @return static
     */
    public static function make(string $reportName, string $reportType = 'CUSTOM_REPORT')
    {
        return new static(...func_get_args());
    }

    /**
     * Create Service instance.
     *
     * @param string $reportName
     * @param string $reportType
     */
    public function __construct(string $reportName, string $reportType = 'CUSTOM_REPORT')
    {
        if (!in_array($reportType, static::$validReportType)){
            throw InvalidArgumentException::invalidType(static::class.'::report', 1, implode('|', static::$validReportType));
        }

        $this->reportName = $reportName;
        $this->reportType = $reportType;
    }

    /**
     * Setting the selection fields.
     *
     * @param string|string[] $fields
     * @return $this
     * @throws InvalidArgumentException
     */
    public function select($fields)
    {
        $this->selection = [];

        if (empty($fields)){
            return $this;
        }

        if (count($fields) === 1){
            $fields = is_array($fields[0]) ? $fields[0] : [$fields[0]];
        }

        foreach ($fields as $k => $field){
            if (!is_string($field)){
                throw InvalidArgumentException::invalidType(static::class.'::select', 1, 'string|string[]');
            }

            $this->selection[] = trim($field);
        }

        $this->selection = array_unique($this->selection);

        return $this;
    }

    /**
     * Setting the period for which the report is generated.
     *
     * @param string $dateFromOrDateRange
     * @param string|null $dateTo
     * @return $this
     * @throws InvalidArgumentException
     */
    public function dateRange(string $dateFromOrDateRange, string $dateTo = null){
        if (is_null($dateTo)){
            if (!in_array($dateFromOrDateRange, static::$validDateRange)){
                throw InvalidArgumentException::invalidType(static::class.'::dateRange', 1, implode('|', static::$validDateRange));
            }

            $this->dateFrom = null;
            $this->dateTo = null;
            $this->dateRangeType = $dateFromOrDateRange;

            return $this;
        }

        $this->dateFrom = date('Y-m-d', strtotime($dateFromOrDateRange));
        $this->dateTo = date('Y-m-d', strtotime($dateTo));
        $this->dateRangeType = 'CUSTOM_DATE';

        return $this;
    }

    /**
     * Setting the selection criteria.
     *
     * @param string $field
     * @param string $operator
     * @param mixed $values
     * @return $this
     * @throws InvalidArgumentException
     */
    public function where(string $field, string $operator, $values)
    {
        switch ($operator){
            case '>': $operator = 'GREATER_THAN'; break;
            case '<': $operator = 'LESS_THAN'; break;
            case '=':
            case '==': $operator = 'EQUALS'; break;
            case '!=':
            case '<>': $operator = 'NOT_EQUALS'; break;
            default:
                if (!in_array($operator, static::$validOperators)){
                    throw InvalidArgumentException::invalidType(static::class.'::where', 1, implode('|', static::$validOperators));
                }
        }

        $this->criteria[] = [
            'Field' => $field,
            'Operator' => $operator,
            'Values' => is_array($values) ? array_unique(array_values($values)) : [$values]
        ];

        return $this;
    }

    /**
     * The value [field] is equal to any value from [values].
     *
     * @param string $field
     * @param string|array $values
     * @return $this
     */
    public function whereIn(string $field, $values)
    {
        $this->criteria[] = [
            'Field' => $field,
            'Operator' => 'IN',
            'Values' => is_array($values) ? array_unique(array_values($values)) : [$values]
        ];

        return $this;
    }

    /**
     * The value [field] is not equal to any value of [values].
     *
     * @param string $field
     * @param string|array $values
     * @return $this
     */
    public function whereNotIn(string $field, $values)
    {
        $this->criteria[] = [
            'Field' => $field,
            'Operator' => 'NOT_IN',
            'Values' => is_array($values) ? array_unique(array_values($values)) : [$values]
        ];

        return $this;
    }

    /**
     * The value [field] begins with the value from [values].
     *
     * @param string $field
     * @param string|array $values
     * @return $this
     */
    public function whereWith(string $field, $values)
    {
        $this->criteria[] = [
            'Field' => $field,
            'Operator' => 'STARTS_WITH_IGNORE_CASE',
            'Values' => is_array($values) ? array_unique(array_values($values)) : [$values]
        ];

        return $this;
    }

    /**
     * The value [field] begins with any of the values specified in [values].
     *
     * @param string $field
     * @param string|array $values
     * @return $this
     */
    public function whereWithAny(string $field, $values)
    {
        $this->criteria[] = [
            'Field' => $field,
            'Operator' => 'STARTS_WITH_ANY_IGNORE_CASE',
            'Values' => is_array($values) ? array_unique(array_values($values)) : [$values]
        ];

        return $this;
    }

    /**
     * The value [field] does not begin with the value from [values].
     *
     * @param string $field
     * @param string|array $values
     * @return $this
     */
    public function whereNotWith(string $field, $values)
    {
        $this->criteria[] = [
            'Field' => $field,
            'Operator' => 'DOES_NOT_START_WITH_IGNORE_CASE',
            'Values' => is_array($values) ? array_unique(array_values($values)) : [$values]
        ];

        return $this;
    }

    /**
     * The value [field] does not begin with any of the values specified in [values].
     *
     * @param string $field
     * @param string|array $values
     * @return $this
     */
    public function whereWithNotAll(string $field, $values)
    {
        $this->criteria[] = [
            'Field' => $field,
            'Operator' => 'DOES_NOT_START_WITH_ALL_IGNORE_CASE',
            'Values' => is_array($values) ? array_unique(array_values($values)) : [$values]
        ];

        return $this;
    }

    /**
     * Setting the selection order.
     *
     * @param string $field
     * @param string|null $sortOrder
     * @return $this
     * @throws InvalidArgumentException
     */
    public function orderBy(string $field, string $sortOrder = null)
    {
        if (is_null($sortOrder)){
            $this->orders[] = [
                'Field' => $field
            ];
            return $this;
        }

        switch (strtoupper($sortOrder)){
            case 'ASC': $sortOrder = 'ASCENDING'; break;
            case 'DESC': $sortOrder = 'DESCENDING'; break;
            default:
                if (!in_array($sortOrder, static::$validSortingTypes)){
                    throw InvalidArgumentException::invalidType(static::class.'::orderBy', 2, implode('|', static::$validSortingTypes));
                }
        }

        $this->orders[] = [
            'Field' => $field,
            'SortOrder' => $sortOrder
        ];

        return $this;
    }

    /**
     * Setting the selection criteria.
     *
     * @param integer $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = intval($limit);
        return $this;
    }

    /**
     * Target identifiers Yandex.Metrics for which you want to get statistics.
     *
     * @param string|string[] $goals
     * @return $this
     * @throws InvalidArgumentException
     */
    public function goals($goals)
    {
        $this->goals = [];

        if (empty($goals)){
            return $this;
        }

        if (count($goals) === 1){
            $goals = is_array($goals[0]) ? $goals[0] : [$goals[0]];
        }

        foreach ($goals as $k => $goal){
            if (!is_string($goal)){
                throw InvalidArgumentException::invalidType(static::class.'::goals', 1, 'string|string[]');
            }

            $this->goals[] = trim($goal);
        }

        $this->goals = array_unique($this->goals);

        return $this;
    }

    /**
     * Attribution models used in the calculation of data on goals Yandex.Metrics.
     *
     * @param string|string[] $attributionModels
     * @return $this
     * @throws InvalidArgumentException
     */
    public function attributionModels($attributionModels)
    {
        $this->attributionModels = [];

        if (empty($attributionModels)){
            return $this;
        }

        if (count($attributionModels) === 1){
            $attributionModels = is_array($attributionModels[0]) ? $attributionModels[0] : [$attributionModels[0]];
        }

        foreach ($attributionModels as $k => $attributionModel){
            if (!is_string($attributionModel)){
                throw InvalidArgumentException::invalidType(static::class.'::attributionModels', 1, 'string|string[]');
            }

            $this->attributionModels[] = trim($attributionModel);
        }

        $this->attributionModels = array_unique($this->attributionModels);

        return $this;
    }

    /**
     * Switch. Whether to include VAT in the amount of money in the report.
     *
     * @param bool $switch
     * @return $this
     */
    public function includeVAT($switch = true)
    {
        $this->includeVAT = $switch === true ? 'YES' : 'NO';
        return $this;
    }

    /**
     * Switch. Whether to consider a discount for monetary amounts in the report.
     *
     * @param bool $switch
     * @return $this
     */
    public function includeDiscount($switch = true)
    {
        $this->includeDiscount = $switch === true ? 'YES' : 'NO';
        return $this;
    }

    /**
     * Convert request parameters to array.
     *
     * @return array
     */
    public function toArray()
    {
        $result = [
            'SelectionCriteria' => [],
            'ReportName' => $this->reportName,
            'ReportType' => $this->reportType,
            'DateRangeType' => $this->dateRangeType,
            'Format' => 'TSV',
            'IncludeVAT' => $this->includeVAT,
            'IncludeDiscount' => $this->includeDiscount
        ];

        foreach ($this->selection as $item){
            $result['FieldNames'][] = $item;
        }

        foreach ($this->criteria as $item){
            $result['SelectionCriteria']['Filter'][] = $item;
        }

        foreach ($this->orders as $item){
            $result['OrderBy'][] = $item;
        }

        if (!empty($this->goals)){
            $result['Goals'] = $this->goals;
        }

        if (!empty($this->attributionModels)){
            $result['AttributionModels'] = $this->attributionModels;
        }

        if (!empty($this->limit)){
            $result['Page']['Limit'] = $this->limit;
        }

        if ($this->dateRangeType === 'CUSTOM_DATE'){
            $result['SelectionCriteria']['DateFrom'] = $this->dateFrom;
            $result['SelectionCriteria']['DateTo'] = $this->dateTo;
        }

        return $result;
    }

    /**
     * Convert request parameters to JSON.
     *
     * @return string
     */
    public function toJson()
    {
        return Arr::toJson($this->toArray());
    }

    /**
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function get()
    {
        return $this->call('get', $this->toArray());
    }

    /**
     * Run an API request and wait for it to complete.
     *
     * @param int $attempts Maximum number of calls to the API server
     * @return Result
     * @throws InvalidArgumentException
     * @throws RequestException
     * @throws RuntimeException
     */
    public function getSync($attempts = 4)
    {
        $request = $this->toArray();
        $result = $this->call('get', $request);

        while (
            in_array($result->code, [201,202]) and
            ($result->header['retryIn'] ?? 0) > 0 and
            $attempts > 0
        ){
            sleep($result->header['retryIn']);
            $attempts = $attempts - 1;
            $result = $this->call('get', $request);
        }

        return $result;
    }
}