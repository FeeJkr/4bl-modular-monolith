<?php
declare(strict_types=1);

namespace App\SharedKernel;

abstract class Id
{
    private $id;

    private function __construct(?int $id)
    {
        $this->id = $id;
    }

    public static function fromInt(int $id): self
    {
        return new static($id);
    }

    public static function nullInstance(): self
    {
        return new static(null);
    }

    public function toInt(): int
    {
        return $this->id;
    }

    public function isNull(): bool
    {
        return $this->id === null;
    }
}
