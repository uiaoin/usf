<?php

namespace App\ExampleBC\Controller;

use App\ExampleBC\Domain\Entity\Product;
use App\ExampleBC\Repository\RepositoryContract\ProductRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\expr;

class ExampleController extends AbstractController
{
    /**
     * @Route("/new", name="example_new")
     * @return JsonResponse
     */
    public function create(
        EntityManagerInterface $manager,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $product = new Product(
            '测试产品', '这是一个不错的测试产品'
        );
        $manager->persist($product);
        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new JsonResponse([
                'errors' => (string) $errors
            ]);
        }

        $manager->flush();

        return new JsonResponse([
            'data' => $product->getId()
        ]);
    }

    /**
     * @Route("/show/{id}", name="example_show")
     * @return JsonResponse
     */
    public function show(
        int $id,
        ProductRepositoryContract $productRepositoryContract
    ): JsonResponse
    {
        $product = $productRepositoryContract->getById($id);
        return $this->json([
            'title' => $product ? $product->getTitle() : null
        ]);
    }

    /**
     * @Route("/delete/{id}", method="GET", name="example_delete")
     * @return JsonResponse
     */
    public function delete(
        int $id,
        ProductRepositoryContract $productRepositoryContract
    ): JsonResponse
    {
        var_dump($productRepositoryContract->deleteById($id));
        exit();

        return $this->json([
            'data' => 'ok'
        ]);
    }
}
