<?php


namespace YandexDirectSDK\Models\Foundation;


use YandexDirectSDK\Models\AdImage;

trait SetAdImage
{
    public function setAdImage(string $name, string $filePath)
    {
        $adImage = AdImage::make()
            ->setName($name)
            ->setImageFile($filePath);

        $adImage->add();
        $this->data['adImageHash'] = $adImage->adImageHash;

        return $this;
    }
}