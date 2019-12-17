<?php

namespace YandexDirectSDK\Components;

use Exception;
use UPTools\Arr;
use YandexDirectSDK\Exceptions\ModelPropertyException;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;
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

        if ($this->type === 'boolean'){
            $this->permissibleValues = [];
            return;
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

            if ($this->itemTag === true and !is_subclass_of($this->permissibleValues[0], ModelCollectionInterface::class)){
                throw ModelPropertyException::inconsistentArrayOfObjectTypeInSignature($signature[0] . ':' . $signature[1]);
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
     * Casting a value to the type specified in a property.
     *
     * @param $value
     * @return array|bool|float|int|object|string|null
     */
    public function cast($value)
    {
        return $this->castTo($this->type, $value);
    }

    /**
     * Casting a value to a given type.
     *
     * @param string $type
     * @param $value
     * @return array|bool|float|int|string|ModelCommonInterface|null
     */
    public function castTo(string $type, $value)
    {
        if (is_null($value)){
            return null;
        }

        switch ($type){
            case 'boolean': return $this->castToBoolean($value); break;
            case 'string': return $this->castToString($value); break;
            case 'double': return $this->castToDouble($value); break;
            case 'integer': return $this->castToInteger($value); break;
            case 'array': return $this->castToArray($value); break;
            case 'enum': return $this->castToEnum($value); break;
            case 'set': return $this->castToSet($value); break;
            case 'object': return $this->castToObject($value); break;
            case 'mixed': return $this->castToMixed($value); break;
        }

        return $value;
    }

    /**
     * Cast to type "boolean".
     *
     * @param $value
     * @return bool|null
     */
    public function castToBoolean($value)
    {
        if (in_array($value, [true,'true',1,'1'], true)){
            return true;
        }

        if (in_array($value, [false,'false',0,'0'], true)){
            return false;
        }

        return null;
    }

    /**
     * Cast to type "string".
     *
     * @param $value
     * @return string|null
     */
    public function castToString($value)
    {
        if (!in_array(gettype($value), ['string','integer','double','boolean'])){
            return null;
        }

        $value = (string) $value;

        if (!empty($this->permissibleValues)){
            $permissibleValues = [];
            foreach ($this->permissibleValues as $permissibleValue){
                if (!is_string($permissibleValue) and !is_numeric($permissibleValue)){
                    continue;
                }
                $permissibleValues[] = (string) $permissibleValue;
            }

            if (!in_array($value, $permissibleValues, true)){
                return null;
            }
        }

        return $value;
    }

    /**
     * Cast to type "double".
     *
     * @param $value
     * @return float|null
     */
    public function castToDouble($value)
    {
        if (!is_numeric($value)){
            return null;
        }

        if (($value = filter_var($value, FILTER_VALIDATE_FLOAT)) === false){
            return null;
        }

        if (!empty($this->permissibleValues)){
            $permissibleValues = [];
            foreach ($this->permissibleValues as $permissibleValue){
                if (($permissibleValue = filter_var($permissibleValue, FILTER_VALIDATE_FLOAT)) === false){
                    continue;
                }
                $permissibleValues[] = $permissibleValue;
            }

            if (!in_array($value, $permissibleValues, true)){
                return null;
            }
        }

        return $value;
    }

    /**
     * Cast to type "integer".
     *
     * @param $value
     * @return int|null
     */
    public function castToInteger($value)
    {
        if (!is_numeric($value)){
            return null;
        }

        $value = (int) $value;

        if (!empty($this->permissibleValues)){
            $permissibleValues = [];
            foreach ($this->permissibleValues as $permissibleValue){
                if (($permissibleValue = filter_var($permissibleValue, FILTER_VALIDATE_INT)) === false){
                    continue;
                }
                $permissibleValues[] = $permissibleValue;
            }

            if (!in_array($value, $permissibleValues, true)){
                return null;
            }
        }

        return $value;
    }

    /**
     * Cast to type "array".
     *
     * @param $value
     * @return array|null
     */
    public function castToArray($value)
    {
        if (!is_array($value)){
            return null;
        }

        if (!empty($this->permissibleValues)){
            foreach ($value as $item){
                if (!in_array(gettype($item), $this->permissibleValues, true)) {
                    return null;
                }
            }
        }

        return $value;
    }

    /**
     * Cast to type "enum".
     *
     * @param $value
     * @return mixed|null
     */
    public function castToEnum($value)
    {
        if ((!is_string($value) and !is_numeric($value)) or empty($this->permissibleValues)){
            return null;
        }

        $value = (string) $value;
        if (!in_array($value, $this->permissibleValues, true)){
            return null;
        }

        return $value;
    }

    /**
     * Cast to type "set".
     *
     * @param $value
     * @return array|null
     */
    public function castToSet($value)
    {
        if (!is_array($value) or empty($this->permissibleValues)) {
            return null;
        }

        foreach ($value as $index => $item){
            if (!is_string($item) and !is_numeric($item)){
                return null;
            }

            $item = (string) $item;
            if (!in_array($item, $this->permissibleValues, true)){
                return null;
            }

            $value[$index] = $item;
        }

        return $value;
    }

    /**
     * Cast to type "object".
     *
     * @param $value
     * @return ModelCommonInterface|null
     */
    public function castToObject($value)
    {
        if (is_object($value) and $value instanceof $this->permissibleValues[0]) {
            return $value;
        }

        return null;
    }

    /**
     * Cast to type "mixed".
     *
     * @param $value
     * @return mixed|null
     */
    public function castToMixed($value)
    {
        if (!empty($this->permissibleValues) and !in_array($value, $this->permissibleValues)){
            return null;
        }

        return $value;
    }

    /**
     * Checks the value against the property.
     *
     * @param mixed $value
     * @param mixed|null $cast
     * @return bool
     */
    public function check($value, &$cast = null)
    {
        return $this->checkAs($this->type, $value, $cast);
    }

    /**
     * Checks the value against the specified property type.
     *
     * @param string $type
     * @param mixed $value
     * @param mixed|null $cast
     * @return bool
     */
    public function checkAs(string $type, $value, &$cast = null)
    {
        if (is_null($cast = $value)){
            return true;
        }

        if (is_null($cast = $this->castTo($type, $value))){
            return false;
        }

        return true;
    }
}