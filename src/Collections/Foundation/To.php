<?php

namespace YandexDirectSDK\Collections\Foundation;

use UPTools\Arr;
use YandexDirectSDK\Interfaces\Model as ModelInterface;

trait To
{
    /**
     * @param integer|integer[]|string|string[] ...$ids
     * @return static
     */
    public static function to(...$ids)
    {
        if (count($ids) === 1){
            $ids = is_array($ids[0]) ? $ids[0] : [$ids[0]];
        }

        return static::wrap(Arr::map(array_unique($ids), function($id){
            /** @var ModelInterface $modelClass */
            $modelClass = static::getCompatibleModelClass();
            return $modelClass::make(['Id' => $id]);
        }));
    }
}