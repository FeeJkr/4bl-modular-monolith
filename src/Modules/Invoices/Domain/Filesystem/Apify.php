<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Filesystem;

interface Apify
{
    public function loadFile(string $resourceId, string $actionId, string $targetPath): void;
}