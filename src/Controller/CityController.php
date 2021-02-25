<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/fiche/{geonameId}", name="city_view", methods={"GET"})
     */
    public function view($geonameId): Response
    {
        $city = $this->getDoctrine()->getRepository(City::class)->findbyGeonameID($geonameId);
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

            $jsonStringImage = file_get_contents('https://api.teleport.org/api/urban_areas/slug:'. $cityName . '/images/');
            $objectResponseImage = json_decode($jsonStringImage);

            $jsonUnsplashStringImage = file_get_contents('https://api.unsplash.com/photos/random?query='. $cityName . '&client_id=BCXFUSjrXKrqgpLKLj6gN36cBB5qZ91T3lzsnrWQthI');
            $objectUnsplashImageResponse = json_decode($jsonUnsplashStringImage);

            $jsonTitleImage = file_get_contents('https://api.unsplash.com/search/photos/?query='. $cityName . '&client_id=BCXFUSjrXKrqgpLKLj6gN36cBB5qZ91T3lzsnrWQthI');
            $objectResponseTitleImage = json_decode($jsonTitleImage);
            $titleImage = $objectResponseTitleImage->results[0]->urls; 
            
        }else{
            $objectScoreResponse = null;
            $objectResponseImage = null; 
            $objectUnsplashImageResponse = null; 
            $objectResponseTitleImage = null;
        }




        return $this->render('city/view.html.twig', [
            'pageTitle' => $objectResponse->name,
            'city' => $city, 
            'cityScore' => $objectScoreResponse,
            'urbanArea' => $objectResponse,
            'image' => $objectResponseImage, 
            'images' => $objectUnsplashImageResponse,
            'titleImage' => $titleImage,
        ]);
    }


    /**
     * @Route("/new", name="city_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('city_index');
        }

        return $this->render('city/new.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="city_show", methods={"GET"})
     */
    public function show(City $city): Response
    {
        return $this->render('city/show.html.twig', [
            'city' => $city,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="city_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, City $city): Response
    {
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('city_index');
        }

        return $this->render('city/edit.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="city_delete", methods={"DELETE"})
     */
    public function delete(Request $request, City $city): Response
    {
        if ($this->isCsrfTokenValid('delete'.$city->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($city);
            $entityManager->flush();
        }

        return $this->redirectToRoute('city_index');
    }
}
