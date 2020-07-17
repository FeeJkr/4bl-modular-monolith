<?php
declare(strict_types=1);

namespace App\SharedKernel\Category;

use MyCLabs\Enum\Enum;

/**
 * @method static CategoryType EXPENSE()
 * @method static CategoryType INCOME()
 */
final class CategoryType extends Enum
{
    private const EXPENSE = 'expense';
    private CONST INCOME = 'income';
}
