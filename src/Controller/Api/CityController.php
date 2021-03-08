<?php 

namespace App\Controller\Api;

use App\Entity\City;
use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api", name="api")
 */

 class CityController extends AbstractController
 {
        /**
       * @Route("/city", name="list", methods={"GET"})
       */
      public function list(CityRepository $cityRepository, ObjectNormalizer $objetNormalizer, Request $request)
      {
          //$cities = $cityRepository->findAll();
          //$form->get('plainPassword')->getData()
          $search = $request->query->get("city_name");
  
          $cities = $this->getDoctrine()->getRepository(City::class)->findByPartialName($search);
          

  
          if(empty($cities)){
              
              return new Response('Pas de resultats', Response::HTTP_NO_CONTENT);
          }
  
          $serializer = new Serializer([ new DateTimeNormalizer(), $objetNormalizer ]);
  
          $json = $serializer->normalize($cities, null, ['groups' => 'api_city']);
  
          return $this->json($json);
      }

      /**
     * @Route("/country", name="country_list", methods={"GET"})
     */
    public function listCountries(CityRepository $cityRepository, ObjectNormalizer $objetNormalizer, Request $request)
    {

        $search = $request->query->get('country_name');

        $countries = $this->getDoctrine()->getRepository(City::class)->findByPartialCountryName($search);

        if (empty($countries)) {

            return new Response('Pas de resultats', Response::HTTP_NO_CONTENT);
        }

        $serializer = new Serializer([new DateTimeNormalizer(), $objetNormalizer]);

        $json = $serializer->normalize($countries, null, ['groups' => 'api_city']);

        return $this->json($json);
    }
  
 }