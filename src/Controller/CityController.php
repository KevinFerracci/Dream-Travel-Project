<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CityRepository;

/**
 * @Route("/city")
 */
class CityController extends AbstractController
{
    /**
     * @Route("/", name="city_index", methods={"GET"})
     */
    public function index(CityRepository $cityRepository): Response
    {
        return $this->render('city/index.html.twig', [
            'pageTitle' => 'Index',
            'cities' => $cityRepository->findAll(),
        ]);
    }

   /**
     * @Route("/{geonameId}", name="city_view", methods={"GET"})
     */
    public function view($geonameId ): Response
    {
        //4717560/ texas
        //http://localhost:8000/city/3489854 jamaica
        //https://api.teleport.org/api/cities/geonameid:2988507  paris
        $jsonString = file_get_contents('https://api.teleport.org/api/cities/geonameid:' . $geonameId);

        $objectResponse = json_decode($jsonString);
        $urbanArea = 'city:urban_area';
         if (isset($objectResponse->_links->$urbanArea)) {
            $cityName = strtolower($objectResponse->name);
            $jsonStringScores = file_get_contents('https://api.teleport.org/api/urban_areas/slug:'. $cityName . '/scores/');
            $objectScoreResponse = json_decode($jsonStringScores);
        }else{
            $objectScoreResponse = null;
        }

        return $this->render('city/view.html.twig', [
            'pageTitle' => 'Paris',
            'city' => $objectResponse,
            'urbanArea' => $objectScoreResponse
        ]);
    }
}

