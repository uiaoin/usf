<?php

namespace App\Messenger;

use Symfony\Component\Messenger\Stamp\StampInterface;

/**
 * 邮票，可以在将邮票放进信封以添加一些信息
 * Class UniqueIdStamp
 * @package App\Messenger
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
