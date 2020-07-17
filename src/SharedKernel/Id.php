<?php
declare(strict_types=1);

namespace App\SharedKernel;

abstract class Id
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function toInt(): int
    {
        return $this->id;
    }
}
