<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Filesystem\GetFileByName;

use App\Common\Application\Query\Query;

class GetFileByNameQuery implements Query
{
    public function __construct(private string $filename){}

    public function getFilename(): string
    {
        return $this->filename;
    }
}