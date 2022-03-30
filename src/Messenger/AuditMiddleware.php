<?php

namespace App\Messenger;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;

/**
 * 中间件，通过中间件放邮票到信封
 * 或者做一些其他事
 * Class AuditMiddleware
 * @package App\Messenger
 */
class AuditMiddleware implements MiddlewareInterface
{
    private $messengerAuditLogger;

    public function __construct(
        LoggerInterface $messengerAuditLogger
    )
    {
        $this->messengerAuditLogger = $messengerAuditLogger;
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
            $this->messengerAuditLogger->info('[{id}] Received {class}', $context);
        } elseif ($envelope->last(SentStamp::class)) {
            $this->messengerAuditLogger->info('[{id}] Sent {class}', $context);
        } else {
            $this->messengerAuditLogger->info('[{id}] Handling {class}', $context);
        }

        return $envelope;
    }
}
