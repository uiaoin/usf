<?php

namespace App\Contract\Messenger\Middleware;

use App\Contract\Messenger\Stamp\UniqueIdStamp;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;

/**
 * Messenger Middleware, we can put stamp into envelop through it
 * and do other things likes logger
 * Class LoggerMiddleware
 * @package App\Contract\Messenger\Middleware
 */
class LoggerMiddleware implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private $messengerLogger;

    public function __construct(
        LoggerInterface $messengerLogger
    )
    {
        $this->messengerLogger = $messengerLogger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null === $envelope->last(UniqueIdStamp::class)) {
            $envelope = $envelope->with(new UniqueIdStamp());
        }

        $stamp = $envelope->last(UniqueIdStamp::class);

        $context = [
            'id' => $stamp->getUniqueId(),
            'class' => get_class($envelope->getMessage())
        ];

        $envelope = $stack->next()->handle($envelope, $stack);
        if ($envelope->last(ReceivedStamp::class)) {
            $this->messengerLogger->info('[{id}] Received {class}', $context);
        } elseif ($envelope->last(SentStamp::class)) {
            $this->messengerLogger->info('[{id}] Sent {class}', $context);
        } else {
            $this->messengerLogger->info('[{id}] Handling {class}', $context);
        }

        return $envelope;
    }
}
