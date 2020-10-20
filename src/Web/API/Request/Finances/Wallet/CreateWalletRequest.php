<?php
declare(strict_types=1);

namespace App\Web\API\Request\Finances\Wallet;

use App\Web\API\Request\Request as RequestInterface;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request;

final class CreateWalletRequest extends RequestInterface
{
    private string $walletName;
    private int $walletStartBalance;
    private string $userToken;

    public function __construct(string $walletName, int $walletStartBalance, string $userToken)
    {
        $this->walletName = $walletName;
        $this->walletStartBalance = $walletStartBalance;
        $this->userToken = $userToken;
    }

    public static function createFromServerRequest(Request $request): self
    {
        $walletName = $request->get('name');
        $startBalance = $request->get('start_balance');
        $userToken = self::extendUserTokenFromRequest($request);

        Assert::lazy()
            ->that($walletName, 'name')->notEmpty()
            ->that($startBalance, 'start_balance')->notEmpty()
            ->that($userToken, 'user_token')->notEmpty()
            ->verifyNow();

        return new self(
            $walletName,
            (int) $startBalance,
            $userToken
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

    public function getUserToken(): string
    {
        return $this->userToken;
    }
}
