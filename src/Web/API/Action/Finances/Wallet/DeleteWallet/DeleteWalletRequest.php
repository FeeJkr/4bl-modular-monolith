<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\DeleteWallet;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class DeleteWalletRequest extends Request
{
    private int $walletId;

    public function __construct(int $walletId)
    {
        $this->walletId = $walletId;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $walletId = $request->get('id');

        Assert::lazy()
            ->that($walletId, 'id')->notEmpty()
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
