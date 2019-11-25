<?php

namespace YandexDirectSDK\Models\Foundation;

use YandexDirectSDK\Collections\TrackingPixels;
use YandexDirectSDK\Components\Model;
use YandexDirectSDK\Components\ModelProperty;
use YandexDirectSDK\Exceptions\InvalidArgumentException;

trait SetTrackingPixels
{
    /**
     * Setter.
     *
     * @param $sourceValue
     * @param ModelProperty $property
     * @return TrackingPixels
     */
    protected function setterTrackingPixels($sourceValue, ModelProperty $property)
    {
        if (!($sourceValue instanceof TrackingPixels)){
            throw InvalidArgumentException::modelPropertyValue(
                static::class,
                $property->name,
                'object',
                $property->permissibleValues,
                $sourceValue
            );
        }

        return $sourceValue;
    }

    /**
     * Import handler.
     *
     * @param $sourceValue
     * @param $currentValue
     * @return TrackingPixels|null
     */
    protected function importTrackingPixels($sourceValue, $currentValue)
    {
        if (is_null($sourceValue)){
            return null;
        }

        if (!is_array($sourceValue)){
            $sourceValue = [['TrackingPixel' => $sourceValue]];
        } else {
            foreach ($sourceValue as $index => $item){
                $sourceValue[$index] = is_array($item) ? $item : ['TrackingPixel' => $item];
            }
        }

        if (!is_null($currentValue) and $currentValue instanceof TrackingPixels){
            return $currentValue->insert($sourceValue);
        }

        return (new TrackingPixels())->insert($sourceValue);
    }

    /**
     * Export handler.
     *
     * @param $currentValue
     * @param $currentFilter
     * @return TrackingPixels|array|null
     */
    protected function exportTrackingPixels($currentValue, $currentFilter)
    {
        if (is_null($currentValue) or !($currentValue instanceof TrackingPixels)){
            return null;
        }

        if ($currentFilter & Model::IS_ADDABLE or $currentFilter & Model::IS_UPDATABLE){
            return $currentValue->extract('trackingPixel');
        }

        return $currentValue;
    }
}