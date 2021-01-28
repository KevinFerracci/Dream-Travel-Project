<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(): Response
    {
        $user = new User();
        
        return $this->render('main/home.html.twig', [
            'pageTitle' => 'Accueil',
            'user' => $user,
        ]);
    }
}
