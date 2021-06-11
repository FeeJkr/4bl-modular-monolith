<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Filesystem\GetFileByName;

use App\Web\API\Action\Response;

final class GetFileByNameResponse extends Response
{
    public static function respond(string $file): self
    {
        return new self($file, headers: [
            'Content-Type' => 'application/octet-stream',
        ]);
    }
}
