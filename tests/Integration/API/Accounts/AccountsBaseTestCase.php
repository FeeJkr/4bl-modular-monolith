<?php
declare(strict_types=1);

namespace App\Tests\Integration\API\Accounts;

use App\Tests\Integration\BaseTestCase;

abstract class AccountsBaseTestCase extends BaseTestCase
{
    protected const URI = '/api/v1/accounts';
}
