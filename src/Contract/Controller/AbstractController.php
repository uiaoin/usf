<?php

namespace App\Contract\Controller;

use App\Contract\Messenger\HandleTrait;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController as Controller;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractController extends Controller
{
    use HandleTrait;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        MessageBusInterface $messageBus,
        SerializerInterface $serializer,
        MessageBusInterface $eventBus
    )
    {
        $this->messageBus = $messageBus;
        $this->serializer = $serializer;
        $this->eventBus = $eventBus;
    }

    /**
     * Deserialize request to an object
     * @param string $json
     * @param $type
     * @param string $format
     * @param array $context
     * @return object
     */
    public function deserialize(
        string $json,
        $type,
        $format = JsonEncoder::FORMAT,
        $context = [
            AbstractObjectNormalizer::PRESERVE_EMPTY_OBJECTS => true,
            AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
        ]
    ): object
    {
        try {
            $object = $this->serializer->deserialize($json, $type, $format, $context);
        } catch (\Exception $e) {
            throw new BadRequestException();
        }

        return $object;
    }

    /**
     * Deserialize and handle
     * @param string $json
     * @param $type
     * @return mixed
     */
    public function desHandle(
        string $json,
        $type
    )
    {
        $object = $this->deserialize($json, $type);

        return $this->handle($object);
    }
}
