<?php

namespace App\ExampleBC\Command\CommandHandler;

use App\ExampleBC\Command\CreateCommand;
use App\ExampleBC\Domain\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCommandHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    )
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function __invoke(CreateCommand $command)
    {
        $product = new Product(
            $command->getTitle(),
            $command->getDescription()
        );
        $errors = $this->validator->validate($product);
        if (count($errors) > 0) {
            throw new ResourceNotFoundException((string) $errors);
        }

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return true;
    }
}
