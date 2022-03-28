<?php

namespace App\ExampleBC\Repository;

use App\ExampleBC\Domain\Entity\Product;
use App\ExampleBC\Repository\RepositoryContract\ProductRepositoryContract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository implements ProductRepositoryContract
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param int $id
     * @return Product
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getById(int $id): Product
    {
        $query = $this->createQueryBuilder('p');
        $query->where($query->expr()->eq('p.id', ':id'))
            ->setParameter('id', $id);

        return $query->getQuery()
            ->getOneOrNullResult();
    }

    public function deleteById(int $id): bool
    {
        $query = $this->getEntityManager()
            ->createQuery(
                sprintf("DELETE FROM %s AS p WHERE p.id = :id", Product::class)
            )
            ->setParameter('id', $id);

        return $query->execute();
    }
}
