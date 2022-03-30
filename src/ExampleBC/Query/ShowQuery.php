<?php

namespace App\ExampleBC\Query;

use App\Contract\Message\QueryInterface;

class ShowQuery implements QueryInterface
{
    private $id;

    public function __construct(
        int $id
    )
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
