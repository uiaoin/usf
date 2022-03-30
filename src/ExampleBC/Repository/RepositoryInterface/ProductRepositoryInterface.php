<?php

namespace App\ExampleBC\Repository\RepositoryInterface;

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
