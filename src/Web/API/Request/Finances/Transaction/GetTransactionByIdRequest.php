<?php
declare(strict_types=1);

namespace App\Web\API\Request\Finances\Transaction;

use App\Web\API\Request\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetTransactionByIdRequest extends Request
{
    private int $transactionId;
    private string $userToken;

    public function __construct(int $transactionId, string $userToken)
    {
        $this->transactionId = $transactionId;
        $this->userToken = $userToken;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $transactionId = $request->get('id');
        $userToken = self::extendUserTokenFromRequest($request);

        Assert::lazy()
            ->that($transactionId, 'id')->notEmpty()
            ->that($userToken, 'user_token')->notEmpty()
            ->verifyNow();

        return new self(
            (int) $transactionId,
            $userToken
        );
    }

    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    public function getUserToken(): string
    {
        return $this->userToken;
    }
}
