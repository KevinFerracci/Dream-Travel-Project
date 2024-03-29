<?php

namespace App\Controller;
use App\Service\Translate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class TranslationController extends AbstractController
{
    /**
     * @Route("/translate/", name="city_translate", methods={"POST"})
     */
    public function translateText(ObjectNormalizer $objetNormalizer, Request $request)
    {
        $content = $request->getContent();
        $arrayData = json_decode($content, true);

        //extract($arrayData);

        $translation = new Translate();

        $response = $translation->translateToFrench($arrayData);

        return $response;
    }
}
