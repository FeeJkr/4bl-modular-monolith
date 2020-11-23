<?php
/** @noinspection PhpUnusedPrivateFieldInspection */
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

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
