<?php

namespace App\ExampleBC\Repository\RepositoryContract;

use App\ExampleBC\Domain\Entity\Product;
use App\Repository\RepositoryContract;

interface ProductRepositoryContract extends RepositoryContract
{
    public function getById(
        int $id
    ): ?Product;

    public function deleteById(
        int $id
    ): bool;
}
