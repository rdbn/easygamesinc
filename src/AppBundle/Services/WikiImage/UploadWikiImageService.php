<?php

namespace AppBundle\Services\WikiImage;

use AppBundle\Services\WikiImage\UploadImage;
use Doctrine\DBAL\Connection;

class UploadWikiImageService
{
    /**
     * @var Connection
     */
    private $dbal;

    /**
     * @var UploadImage
     */
    private $uploadImage;

    /**
     * UploadImageService constructor.
     * @param Connection $dbal
     * @param UploadImage $uploadImage
     */
    public function __construct(Connection $dbal, UploadImage $uploadImage)
    {
        $this->dbal = $dbal;
        $this->uploadImage = $uploadImage;
    }

    /**
     * @param array $wikiText
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function upload(array $wikiText)
    {
        foreach ($wikiText as $item) {
            preg_match_all('/src="([^"]+)"/i', $item['text'], $matches);
            $images = array_flip($matches);

            $images = $this->uploadImage->upload($images);
            foreach ($images as $url => $image) {

            }
        }
    }
}