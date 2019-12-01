<?php


namespace YandexDirectSDK\Models\Foundation;


use YandexDirectSDK\Models\AdImage;
use YandexDirectSDK\Services\AdImagesService;

trait SetAdImage
{
    public function setAdImage(string $name, string $filePath)
    {
        $result = AdImagesService::create(
            AdImage::make()
                ->setName($name)
                ->setImageFile($filePath)
        );

        if (!is_null($result = $result->getResource())){
            $this->data['adImageHash'] = $result
                ->first()
                ->getPropertyValue('adImageHash');
        }

        return $this;
    }
}