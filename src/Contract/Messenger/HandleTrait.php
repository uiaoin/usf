<?php

namespace App\Contract\Messenger;

use Symfony\Component\Messenger\Exception\LogicException;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Customer handle class
 * Trait HandleTrait
 * @package App\Contract\Messenger
 */
trait HandleTrait
{
    use \Symfony\Component\Messenger\HandleTrait {
        \Symfony\Component\Messenger\HandleTrait::handle as sfh;
    }

    /** @var MessageBusInterface */
    private $messageBus;

    /** @var MessageBusInterface */
    private $eventBus;

    public function handle(object $message)
    {
        if ($message instanceof EventMessageInterface) {
            if (! $this->eventBus) {
                throw new LogicException(sprintf('You must provide a "%s" instance in the "%s::$eventBus" property, "%s" given.', MessageBusInterface::class, static::class, get_debug_type($this->eventBus)));
            }

            return $this->eventBus->dispatch($message);
        }

        if (!$this->messageBus instanceof MessageBusInterface) {
            throw new LogicException(sprintf('You must provide a "%s" instance in the "%s::$messageBus" property, "%s" given.', MessageBusInterface::class, static::class, get_debug_type($this->messageBus)));
        }

        if ($message instanceof AsyncMessageInterface) {
            return $this->messageBus->dispatch($message);
        }

        return $this->sfh($message);
    }
}
