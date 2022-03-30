<?php

namespace App\ExampleBC\Repository\RepositoryContract;

use App\Contract\Repository\RepositoryInterface;
use App\ExampleBC\Domain\Entity\Product;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getById(
        int $id
    ): ?Product;

    public function deleteById(
        int $id
    ): bool;
}
