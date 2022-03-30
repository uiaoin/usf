<?php

namespace App\ExampleBC\Query\QueryHandler;

use App\ExampleBC\Query\ShowQuery;
use App\ExampleBC\Repository\RepositoryContract\ProductRepositoryInterface;

class ShowQueryHandler
{
    private $productRepositoryContract;

    public function __construct(
        ProductRepositoryInterface $productRepositoryContract
    )
    {
        $this->productRepositoryContract = $productRepositoryContract;
    }

    public function __invoke(ShowQuery $query)
    {
        $product = $this->productRepositoryContract->getById($query->getId());
        if (! $product) {
            return null;
        }

        return $product->getDescription();
    }
}
