<?php

namespace YandexDirectSDK\Components;

use Closure;
use InvalidArgumentException;
use YandexDirectSDK\Common\Arr;

class QueryBuilder
{
    /**
     * Selection fields.
     *
     * @var array
     */
    protected $selection = [];

    /**
     * Selection criteria.
     *
     * @var array
     */
    protected $criteria = [];

    /**
     * Selection limit.
     *
     * @var int
     */
    protected $limit = 0;

    /**
     * Selection offset.
     *
     * @var int
     */
    protected $offset = 0;

    /**
     * Callback function that retrieves data from the Yandex.Direct API.
     *
     * @var Closure|null
     */
    public $getter = null;

    /**
     * Create new QueryBuilder instance.
     *
     * @param Closure|null $getter
     */
    public function __construct(Closure $getter = null)
    {
        $this->getter = $getter;
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
     * Setting the selection criteria.
     *
     * @param string $field
     * @param mixed $value
     * @return $this
     */
    public function where($field, $value)
    {
        if (!is_string($field)){
            throw new InvalidArgumentException(static::class.". Failed method [where]. Invalid field name. Expected [string].");
        }

        $this->criteria[$field] = is_array($value) ? array_unique(array_values($value)) : [$value];

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
     * Setting the selection offset.
     *
     * @param integer $offset
     * @return $this
     */
    public function offset($offset)
    {
        $this->offset = intval($offset);
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
            'SelectionCriteria' => $this->criteria,
        ];

        if (!empty($this->limit)){
            $result['Page']['Limit'] = $this->limit;
        }

        if (!empty($this->offset)){
            $result['Page']['Offset'] = $this->offset;
        }

        foreach ($this->selection as $item){
            if (strpos($item, '.') === false){
                $result['FieldNames'][] = $item;
            } else {
                $item = explode('.', $item, 2);
                $result[$item[0].'FieldNames'][] = $item[1];
            }
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
     * Run an API request.
     * Available if the [$this->getter] parameter is set.
     *
     * @return Result|null|mixed
     */
    public function get()
    {
        $getter = $this->getter;

        if (is_null($getter)){
            throw new InvalidArgumentException(static::class.". Failed method [get]. Undefined Getter for request.");
        }

        return $getter($this);
    }
}