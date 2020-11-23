<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\UpdateWallet;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class UpdateWalletRequest extends Request
{
    private int $walletId;
    private string $walletName;
    private int $walletStartBalance;

    public function __construct(int $walletId, string $walletName, int $walletStartBalance)
    {
        $this->walletId = $walletId;
        $this->walletName = $walletName;
        $this->walletStartBalance = $walletStartBalance;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $walletId = $request->get('id');
        $walletName = $request->get('name');
        $walletStartBalance = $request->get('start_balance');

        Assert::lazy()
            ->that($walletId, 'id')->notEmpty()
            ->that($walletName, 'name')->notEmpty()
            ->that($walletStartBalance, 'start_balance')->notEmpty()
            ->verifyNow();

        return new self(
            $walletId,
            $walletName,
            $walletStartBalance
        );
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }

    public function getWalletName(): string
    {
        return $this->walletName;
    }

    public function getWalletStartBalance(): int
    {
        return $this->walletStartBalance;
    }
}
