<?php

namespace App\ExampleBC\Controller;

use App\Controller\AbstractController;
use App\ExampleBC\Command\CreateCommand;
use App\ExampleBC\Query\ShowQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ExampleController extends AbstractController
{

    /**
     * @Route("/new", name="example_new")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(
        Request $request
    ): JsonResponse
    {

        // don't use serializer and messenger
//        EntityManagerInterface $manager,
//        ValidatorInterface $validator
//        $product = new Product(
//            'Test product', 'This ia niubility product'
//        );
//        $manager->persist($product);
//        $errors = $validator->validate($product);
//        if (count($errors) > 0) {
//            return new JsonResponse([
//                'errors' => (string) $errors
//            ]);
//        }
//        $manager->flush();

        // use serializer and messenger
        // and take the codes into command handler
//        $this->desHandle(
//            $request->getContent(),
//            CreateCommand::class
//        );



        return $this->json([
            'data' => 'ok'
        ]);
    }

    /**
     * @Route("/show/{id}", name="example_show")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(
        Request $request
    ): JsonResponse
    {
        // don't use serializer and messenger
//        $product = $productRepositoryContract->getById($id);
//        return $this->json([
//            'title' => $product ? $product->getTitle() : null
//        ]);

        // use serializer and messenger
        $data = $this->desHandle($request->getContent(), ShowQuery::class);

        return $this->json([
            'desc' => $data
        ]);
    }
}
