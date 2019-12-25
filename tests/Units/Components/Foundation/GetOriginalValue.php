<?php

namespace YandexDirectSDKTest\Units\Components\Foundation;


use YandexDirectSDK\Interfaces\Model as ModelInterface;
use YandexDirectSDK\Interfaces\ModelCollection as ModelCollectionInterface;

trait GetOriginalValue
{
    protected function getOriginalValue($value)
    {
        if ($value instanceof ModelInterface){
            $result = [];
            $data = (function(){return $this->{'data'};})->bindTo($value, $value)();
            foreach ($data as $propertyName => $propertyValue){
                $result[$propertyName] = $this->getOriginalValue($propertyValue);
            }
            return $result;
        }

        if ($value instanceof ModelCollectionInterface){
            $result = [];
            foreach ($value->all() as $index => $item){
                $result[$index] = $this->getOriginalValue($item);
            }
            return $result;
        }

        return $value;
    }
}