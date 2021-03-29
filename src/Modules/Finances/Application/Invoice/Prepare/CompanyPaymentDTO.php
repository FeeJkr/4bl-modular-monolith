<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Invoice\Prepare;

final class CompanyPaymentDTO
{
    public function __construct(
        private string $type,
        private string $date,
        private string $bank,
        private string $accountNumber,
        private float $totalPrice,
        private float $alreadyTakenPrice,
        private float $toPayPrice,
        private string $translatePrice,
    ){}
}