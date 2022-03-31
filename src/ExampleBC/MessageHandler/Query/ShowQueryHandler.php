<?php

namespace App\ExampleBC\MessageHandler\Query;

use App\ExampleBC\Message\Query\ShowQuery;
use App\ExampleBC\Repository\RepositoryInterface\ProductRepositoryInterface;

class ShowQueryHandler
{
    private $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(ShowQuery $query)
    {
        $product = $this->productRepository->getById($query->getId());
        if (! $product) {
            return null;
        }

        return $product->getDescription();
    }
}
