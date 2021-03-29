<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Invoice;

interface PriceTransformer
{
    public function transformToText(float $price): string;
}
