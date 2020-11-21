<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Request;

interface HttpRequestContext
{
    public function getUserToken(): string;
}
