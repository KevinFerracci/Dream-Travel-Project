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
     * @Route("/view", name="city_view")
     */
    public function view(CityRepository $cityRepository): Response
    {
        return $this->render('city/view.html.twig', [
            'pageTitle' => 'Fiche de ville',
            'cities' => $cityRepository->findAll(),
        ]);
    }
}
