<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use \App\Contract\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="test")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function test()
    {
        return $this->json([
            'code' => 0
        ]);
    }

}
