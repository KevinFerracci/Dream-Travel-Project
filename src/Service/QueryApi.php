<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Weather;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;

class QueryApi
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function cityDataImage($cityNameUnsplash)
    {
        if (isset($cityNameUnsplash)) {
            dump($cityNameUnsplash);
            //$cityNameUnsplash = str_replace('\%C3%A3', 'ã', $cityNameUnsplash);
            //'https://api.unsplash.com/search/photos/?query=' . $cityNameUnsplash . '&client_id=' . $_ENV['API_KEY_UNSPLASH'];
            //landscape
            //$urlImageQuery = 'https://api.unsplash.com/search/photos/?orientation=landscape&query=' . $cityNameUnsplash . '&client_id=' . $_ENV['API_KEY_UNSPLASH'];
            $urlImageQuery = 'https://api.unsplash.com/search/photos/?query=' . $cityNameUnsplash . '&client_id=' . $_ENV['API_KEY_UNSPLASH'];
            $jsonStringUrlImage = file_get_contents($urlImageQuery);
            $objectResponseUrlImage = json_decode($jsonStringUrlImage);
            $urlImage = $objectResponseUrlImage->results[0]->urls;
        } else {
            $urlImage = null;
        }
        return $urlImage;
    }

}