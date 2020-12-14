<?php
declare(strict_types=1);

namespace App\Common;

use JetBrains\PhpStorm\Pure;

abstract class Id
{
    private ?int $id;

    private function __construct(?int $id)
    {
        $this->id = $id;
    }

    #[Pure]
    public static function fromInt(int $id): static
    {
        return new static($id);
    }

    #[Pure]
    public static function nullInstance(): static
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
