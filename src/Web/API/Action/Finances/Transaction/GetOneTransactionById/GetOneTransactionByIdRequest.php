<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction\GetOneTransactionById;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetOneTransactionByIdRequest extends Request
{
    private int $transactionId;

    public function __construct(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $transactionId = $request->get('id');

        Assert::lazy()
            ->that($transactionId, 'id')->notEmpty()
            ->verifyNow();

        return new self(
            (int) $transactionId
        );
    }

    public function getTransactionId(): int
    {
        return $this->transactionId;
    }
}
