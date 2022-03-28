<?php

namespace App\ExampleBC\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExampleController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     * @return JsonResponse
     */
    public function test(): JsonResponse
    {
        return new JsonResponse([
            'data' => 'test'
        ]);
    }
}
