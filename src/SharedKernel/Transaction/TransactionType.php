<?php
declare(strict_types=1);

namespace App\SharedKernel\Transaction;

use MyCLabs\Enum\Enum;

/**
 * @method static TransactionType REGULAR()
 * @method static TransactionType TRANSFER()
 */
final class TransactionType extends Enum
{
    private const REGULAR = 'regular';
    private const TRANSFER = 'transfer';
}
