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
        }else{
            $objectScoreResponse = null;
            $objectResponseImage = null; 
        }

        return $this->render('city/view.html.twig', [
            'pageTitle' => 'Paris',
            'city' => $objectResponse,
            'urbanArea' => $objectScoreResponse,
            'image' => $objectResponseImage, 
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
