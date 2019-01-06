<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 27/11/2018
 * Time: 11:38
 */

namespace AppBundle\Services\WikiImage;

use GuzzleHttp\Client;

class UploadImage
{
    /**
     * @param array $images
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function upload(array $images): array
    {
        $guzzle = new Client();
        foreach ($images as $href => $image) {
            $res = $guzzle->request("GET", $href);
            $content = (string) $res->getBody();

            $name = uniqid(time(), true);
            file_put_contents(__DIR__ . "/../../../web/image_wiki/{$name}.jpg", $content);

            $images[$href] = $name;
        }

        return $images;
    }
}