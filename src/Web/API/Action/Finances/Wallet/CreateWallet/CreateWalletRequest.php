<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\CreateWallet;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateWalletRequest extends Request
{
    private string $walletName;
    private int $walletStartBalance;

    public function __construct(string $walletName, int $walletStartBalance)
    {
        $this->walletName = $walletName;
        $this->walletStartBalance = $walletStartBalance;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $walletName = $request->get('name');
        $startBalance = $request->get('start_balance');

        Assert::lazy()
            ->that($walletName, 'name')->notEmpty()
            ->that($startBalance, 'start_balance')->notEmpty()
            ->verifyNow();

        return new self(
            $walletName,
            (int) $startBalance
        );
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
