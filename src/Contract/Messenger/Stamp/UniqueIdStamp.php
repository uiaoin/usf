<?php

namespace App\Contract\Messenger\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

/**
 * Messenger stamp
 * Class UniqueIdStamp
 * @package App\Contract\Messenger\Stamp
 */
class UniqueIdStamp implements StampInterface
{
    private $uniqueId;

    public function __construct()
    {
        $this->uniqueId = uniqid();
    }

    /**
     * @return string
     */
    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }
}
