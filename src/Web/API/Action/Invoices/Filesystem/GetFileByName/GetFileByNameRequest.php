<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Filesystem\GetFileByName;

use App\Web\API\Action\Request;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

class GetFileByNameRequest extends Request
{
    public function __construct(private string $filename){}

    public static function createFromServerRequest(ServerRequest $request): self
    {
        return new self(
            $request->get('filename')
        );
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}