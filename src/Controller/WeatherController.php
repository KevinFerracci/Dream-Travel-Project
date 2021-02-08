<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Form\WeatherType;
use App\Repository\WeatherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/weather")
 */
class WeatherController extends AbstractController
{
    /**
     * @Route("/", name="weather_index", methods={"GET"})
     */
    public function index(WeatherRepository $weatherRepository): Response
    {
        return $this->render('weather/index.html.twig', [
            'weather' => $weatherRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="weather_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $weather = new Weather();
        $form = $this->createForm(WeatherType::class, $weather);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($weather);
            $entityManager->flush();

            return $this->redirectToRoute('weather_index');
        }

        return $this->render('weather/new.html.twig', [
            'weather' => $weather,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="weather_show", methods={"GET"})
     */
    public function show(Weather $weather): Response
    {
        return $this->render('weather/show.html.twig', [
            'weather' => $weather,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="weather_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Weather $weather): Response
    {
        $form = $this->createForm(WeatherType::class, $weather);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('weather_index');
        }

        return $this->render('weather/edit.html.twig', [
            'weather' => $weather,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="weather_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Weather $weather): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weather->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($weather);
            $entityManager->flush();
        }

        return $this->redirectToRoute('weather_index');
    }
}
