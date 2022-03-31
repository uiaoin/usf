<?php

namespace App\Contract\Exception;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ExceptionHandler
 * @package App\Contract\Exception
 */
class ExceptionHandler implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['processException', 10],
                ['logException', 0],
                ['notifyException', -10],
            ]
        ];
    }

    public function processException(ExceptionEvent $event)
    {
        //
        $throwable = $event->getThrowable();
        if ($throwable instanceof BadRequestHttpException) {
            $event->setResponse(
                new JsonResponse([
                    'code' => -1,
                    'msg' => 'Bad Request'
                ], Response::HTTP_BAD_REQUEST)
            );
        }
    }

    public function logException(ExceptionEvent $event)
    {
        //
    }

    public function notifyException(ExceptionEvent $event)
    {
        //
    }
}
