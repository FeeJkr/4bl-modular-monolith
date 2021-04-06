<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Delete;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

class DeleteCompanyRequest extends Request
{
    public function __construct(private int $companyId){}

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $companyId = (int) $request->get('id');

        Assert::lazy()
            ->that($companyId, 'companyId')->notEmpty()->numeric()
            ->verifyNow();

        return new self(
            $companyId,
        );
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }
}