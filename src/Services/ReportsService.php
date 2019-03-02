<?php

namespace YandexDirectSDK\Services;

use InvalidArgumentException;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Components\Service;
use YandexDirectSDK\Components\Result;

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

    protected $serviceName = 'reports';

    protected $reportName;

    protected $reportType;

    protected $selection = [];

    protected $dateFrom;

    protected $dateTo;

    protected $dateRangeType = 'AUTO';

    protected $criteria = [];

    protected $limit = 0;

    protected $orders = [];

    protected $goals;

    protected $attributionModels;

    protected $includeVAT = 'NO';

    protected $includeDiscount = 'NO';


    protected function initialize(...$arguments)
    {
        if (!is_string($arguments[0])){
            throw new InvalidArgumentException(static::class.". Failed method [report]. Invalid report name. Expected [string].");
        }

        if (isset($arguments[1])){
            if (!in_array($arguments[1], static::$validReportType)){
                throw new InvalidArgumentException(static::class.". Failed method [report]. Invalid report type. Expected [".implode('|', static::$validReportType)."].");
            }
        }

        $this->reportName = $arguments[0];
        $this->reportType = $arguments[1] ?? 'CUSTOM_REPORT';
    }

    /**
     * Setting the selection fields.
     *
     * @param string|string[] $fields
     * @return $this
     */
    public function select($fields)
    {
        if (empty($fields)){
            return $this;
        }

        if (is_string($fields)){
            $fields = preg_split('/\s*,\s*/is', trim($fields), null, PREG_SPLIT_NO_EMPTY);
        }

        if (!is_array($fields)){
            throw new InvalidArgumentException(static::class.". Failed method [select]. Invalid argument type [".gettype($fields)."]. Expected [string|array].");
        }

        $this->selection = array_unique(array_values($fields));

        return $this;
    }

    /**
     * Setting the period for which the report is generated.
     *
     * @param string $dateFromOrDateRange
     * @param string|null $dateTo
     * @return $this
     */
    public function dateRange(string $dateFromOrDateRange, string $dateTo = null){
        if (is_null($dateTo)){
            if (!in_array($dateFromOrDateRange, static::$validDateRange)){
                throw new InvalidArgumentException(static::class.". Failed method [dateRange]. Invalid date range type. Expected [".implode('|', static::$validDateRange)."].");
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
     */
    public function where(string $field, $operator, $values)
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
                    throw new InvalidArgumentException(static::class.". Failed method [where]. Invalid operator name. Expected [".implode('|', static::$validOperators)."].");
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
                    throw new InvalidArgumentException(static::class.". Failed method [where]. Invalid sorting types. Expected [".implode('|', static::$validSortingTypes)."].");
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
     */
    public function goals($goals)
    {
        if (is_string($goals)){
            $goals = preg_split('/\s*,\s*/is', trim($goals), null, PREG_SPLIT_NO_EMPTY);
        }

        if (!is_array($goals)){
            throw new InvalidArgumentException(static::class.". Failed method [goals]. Invalid argument type. Expected [string|array].");
        }

        $this->goals = array_unique(array_values($goals));
        return $this;
    }

    /**
     * Attribution models used in the calculation of data on goals Yandex.Metrics.
     *
     * @param string|string[] $attributionModels
     * @return $this
     */
    public function attributionModels($attributionModels)
    {
        if (is_string($attributionModels)){
            $attributionModels = preg_split('/\s*,\s*/is', trim($attributionModels), null, PREG_SPLIT_NO_EMPTY);
        }

        if (!is_array($attributionModels)){
            throw new InvalidArgumentException(static::class.". Failed method [attributionModels]. Invalid argument type. Expected [string|array].");
        }

        $this->attributionModels = array_unique(array_values($attributionModels));
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
     */
    public function get()
    {
        return $this->call('get', $this->toArray());
    }
}