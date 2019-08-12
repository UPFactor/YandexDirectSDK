<?php

namespace YandexDirectSDK\Components;

use Exception;
use YandexDirectSDK\Common\Arr;
use YandexDirectSDK\Exceptions\ModelPropertyException;
use YandexDirectSDK\Interfaces\ModelCommon as ModelCommonInterface;

/**
 * Class ModelProperty
 *
 * @property-read string $name
 * @property-read string $type
 * @property-read array $permissibleValues
 * @property boolean $itemTag
 * @property boolean $readable
 * @property boolean $writable
 * @property boolean $addable
 * @property boolean $updatable
 *
 * @package YandexDirectSDK\Components
 */
class ModelProperty
{
    /**
     * Property name.
     *
     * @var string
     */
    protected $name;

    /**
     * Property type.
     *
     * @var string
     */
    protected $type = 'mixed';

    /**
     * Permissible values of property.
     *
     * @var array
     */
    protected $permissibleValues = [];

    /**
     * Property uses tag "item".
     *
     * @var bool
     */
    protected $itemTag = false;

    /**
     * Property is readable.
     *
     * @var bool
     */
    protected $readable = true;

    /**
     * Property is writable.
     *
     * @var bool
     */
    protected $writable = true;

    /**
     * Property is addable.
     *
     * @var bool
     */
    protected $addable = true;

    /**
     * Property is updatable.
     *
     * @var bool
     */
    protected $updatable = true;

    /**
     * ModelProperty constructor.
     *
     * @param string $name
     * @param string $signature
     */
    public function __construct(string $name, string $signature)
    {
        if (empty($signature)){
            throw ModelPropertyException::signatureIsEmpty();
        }

        $signature = explode(':', $signature, 2);

        $this->name = $name;
        $this->type = trim($signature[0]);
        $this->permissibleValues = empty($signature[1] = trim($signature[1] ?? '')) ? [] : explode(',', $signature[1]);

        switch ($this->type){
            case 'bool': $this->type = 'boolean'; break;
            case 'float': $this->type = 'double'; break;
            case 'int': $this->type = 'integer'; break;
            case 'stack': $this->type = 'array'; break;
            case 'array': $this->itemTag = true; break;
            case 'arrayOfEnum':
            case 'arrayOfSet':
                $this->type = 'set';
                $this->itemTag = true;
                break;
            case 'arrayOfObject':
                $this->type = 'object';
                $this->itemTag = true;
                break;
            case 'arrayOfCustom':
                $this->type = 'custom';
                $this->itemTag = true;
                break;
        }

        if (in_array($this->type, ['enum','set'], true)){
            if (empty($this->permissibleValues)){
                throw ModelPropertyException::inconsistentEnumTypeInSignature($signature[0] . ':' . $signature[1]);
            }
            return;
        }

        if ($this->type === 'object'){
            if (count($this->permissibleValues) !== 1 or !is_subclass_of($this->permissibleValues[0], ModelCommonInterface::class)){
                throw ModelPropertyException::inconsistentObjectTypeInSignature($signature[0] . ':' . $signature[1]);
            }
            return;
        }

        if (!in_array($this->type, ['string','boolean','double','integer','array','custom','mixed'])){
            throw ModelPropertyException::inconsistentTypeInSignature($signature[0] . ':' . $signature[1], $this->type);
        }
    }

    /**
     * Returns a string representation of the current object.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Overload object properties.
     *
     * @param $name
     * @param $value
     * @return array|bool
     */
    public function __set($name, $value)
    {
        if (in_array($name, ['itemTag', 'readable', 'writable', 'addable', 'updatable'])){
            return $this->{$name} = (boolean) $value;
        }
        throw ModelPropertyException::propertyNotWritable($name);
    }

    /**
     * Overload object properties.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        try {
            return $this->{$name};
        } catch (Exception $error){
            throw ModelPropertyException::propertyNotExist($name);
        }
    }

    /**
     * Retrieve object hash.
     *
     * @return string
     */
    public function hash()
    {
        return Arr::hash($this->toArray());
    }

    /**
     * Convert object to array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'permissibleValues' => $this->permissibleValues,
            'itemTag' => $this->itemTag,
            'readable' => $this->readable,
            'writable' => $this->writable,
            'addable' => $this->addable,
            'updatable' => $this->updatable
        ];
    }

    /**
     * Convert object to JSON.
     *
     * @return string
     */
    public function toJson()
    {
        return Arr::toJson($this->toArray());
    }

    /**
     * Checks the value against the property.
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value)
    {
        return $this->checkAs($this->type, $value);
    }

    /**
     * Checks the value against the specified property type.
     *
     * @param string $type
     * @param mixed $value
     * @return bool
     */
    public function checkAs(string $type, $value)
    {
        if (is_null($value)){
            return true;
        }

        switch ($type){
            case 'boolean': $this->checkAsBoolean($value); break;
            case 'string': $this->checkAsString($value); break;
            case 'double': $this->checkAsDouble($value); break;
            case 'integer': $this->checkAsInteger($value); break;
            case 'array': $this->checkAsArray($value); break;
            case 'enum': $this->checkAsEnum($value); break;
            case 'set': $this->checkAsSet($value); break;
            case 'object': $this->checkAsObject($value); break;
            case 'mixed': $this->checkAsMixed($value); break;
        }

        return true;
    }

    /**
     * Checks the value against a property with type - "Boolean".
     *
     * @param $value
     * @return bool
     */
    public function checkAsBoolean($value)
    {
        return is_bool($value);
    }

    /**
     * Checks the value against a property with type - "String".
     *
     * @param $value
     * @return bool
     */
    public function checkAsString($value)
    {
        if (!is_string($value)){
            return false;
        }

        if (!empty($this->permissibleValues) and !in_array($value, $this->permissibleValues)){
            return false;
        }

        return true;
    }

    /**
     * Checks the value against a property with type - "Double".
     *
     * @param $value
     * @return bool
     */
    public function checkAsDouble($value)
    {
        if (filter_var($value, FILTER_VALIDATE_FLOAT) === false){
            return false;
        }

        if (!empty($this->permissibleValues) and !in_array($value, $this->permissibleValues)){
            return false;
        }

        return true;
    }

    /**
     * Checks the value against a property with type - "Integer".
     *
     * @param $value
     * @return bool
     */
    public function checkAsInteger($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false){
            return false;
        }

        if (!empty($this->permissibleValues) and !in_array($value, $this->permissibleValues)){
            return false;
        }

        return true;
    }

    /**
     * Checks the value against a property with type - "Array".
     *
     * @param $value
     * @return bool
     */
    public function checkAsArray($value)
    {
        if (!is_array($value)){
            return false;
        }

        if (!empty($this->permissibleValues)){
            foreach ($value as $item){
                if (!in_array(gettype($item), $this->permissibleValues, true)) {
                    return false;
                }
            }
        }

        return false;
    }

    /**
     * Checks the value against a property with type - "Enum".
     *
     * @param $value
     * @return bool
     */
    public function checkAsEnum($value)
    {
        if (!in_array($value, $this->permissibleValues)){
            return false;
        }

        return true;
    }

    /**
     * Checks the value against a property with type - "Set".
     *
     * @param $value
     * @return bool
     */
    public function checkAsSet($value)
    {
        if (!is_array($value)) {
            return false;
        }

        foreach ($value as $item){
            if (!in_array($item,  $this->permissibleValues)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks the value against a property with type - "Object".
     *
     * @param $value
     * @return bool
     */
    public function checkAsObject($value)
    {
        if (is_object($value) and $value instanceof $this->permissibleValues[0]) {
            return true;
        }

        return false;
    }

    /**
     * Checks the value against a property with type - "Mixed".
     *
     * @param $value
     * @return bool
     */
    public function checkAsMixed($value)
    {
        if (!empty($this->permissibleValues) and !in_array($value, $this->permissibleValues)){
            return false;
        }

        return true;
    }
}