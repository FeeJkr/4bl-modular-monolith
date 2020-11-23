<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction\GetAllTransactionsByWalletId;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetAllTransactionsByWalletIdRequest extends Request
{
    private int $walletId;

    public function __construct(int $walletId)
    {
        $this->walletId = $walletId;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $walletId = $request->get('wallet_id');

        Assert::lazy()
            ->that($walletId, 'wallet_id')->notEmpty()
            ->verifyNow();

        return new self(
            (int) $walletId
        );
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }
}
