<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

use MyCLabs\Enum\Enum;

/**
 * @method static CategoryType EXPENSES()
 * @method static CategoryType INCOME()
 * @method static CategoryType TRANSFER()
 */
final class CategoryType extends Enum
{
    private const EXPENSES = 'expenses';
    private const INCOME = 'income';
    private const TRANSFER = 'transfer';
}