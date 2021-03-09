<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\City;
use App\Entity\Picture; 
use App\Form\CityType;
use App\Form\ReviewType;
use App\Repository\CityRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/city")
 */
class CityController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

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
     * @Route("/fiche/{geonameId}", name="city_view", methods={"GET", "POST"})
     */
    public function view(Request $request, ImageUploader $imageUploader, $geonameId): Response
    {
        $city = $this->getDoctrine()->getRepository(City::class)->findbyGeonameID($geonameId);

        //form review
        $review = new Review();
        $formReview = $this->createForm(ReviewType::class, $review);
        $formReview->handleRequest($request);

        if ($formReview->isSubmitted() && $formReview->isValid()) {
            $review->setCity($city);
            // Active => 1| Inactive => 0
            $review->setStatus(1);
            $review->setNegativeVote(0);
            $review->setPositiveVote(0);
            // is not reported => 0 | is reported => 1
            $review->setReport(0);
            $review->setRate($formReview->get('rate')->getData());
            $review->setCreatedAt(new \DateTime());
            $review->setUser($this->getUser());

            $filename = $imageUploader->moveFile($formReview->get('imageFile')->getData(), 'images/uploads');
            $picture = new Picture();
            $entityManager = $this->getDoctrine()->getManager();
            if ($formReview->get('imageFile')->getData()) {
                if ($formReview->get('title')->getData() === null) {
                    $picture->setTitle($city->getCityName());
                } else {
                    $picture->setTitle($formReview->get('title')->getData());
                }
                $picture->setFilename($filename);
                $picture->setCreatedAt(new \DateTime());
                $picture->setReview($review);
                $review->addPicture($picture);
                $entityManager->persist($picture);
            }
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('city_view', ['geonameId' =>  $geonameId]);
        }
        
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
            $titleImage = null;
        }




        return $this->render('city/view.html.twig', [
            'pageTitle' => $objectResponse->name,
            'city' => $city, 
            'cityScore' => $objectScoreResponse,
            'urbanArea' => $objectResponse,
            'image' => $objectResponseImage, 
            'images' => $objectUnsplashImageResponse,
            'titleImage' => $titleImage,
            'randomImages' => $objectResponseTitleImage,
            'formReview' => $formReview->createView(), 
            'reviews' => $city->getReviews(),
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
