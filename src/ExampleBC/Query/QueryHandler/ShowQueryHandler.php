<?php

namespace App\ExampleBC\Query\QueryHandler;

use App\ExampleBC\Query\ShowQuery;
use App\ExampleBC\Repository\RepositoryContract\ProductRepositoryContract;

class ShowQueryHandler
{
    private $productRepositoryContract;

    public function __construct(
        ProductRepositoryContract $productRepositoryContract
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
