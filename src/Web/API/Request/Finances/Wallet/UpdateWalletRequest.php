<?php
declare(strict_types=1);

namespace App\Web\API\Request\Finances\Wallet;

use App\Web\API\Request\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class UpdateWalletRequest extends Request
{
    private int $walletId;
    private string $walletName;
    private int $walletStartBalance;
    private string $userToken;

    public function __construct(int $walletId, string $walletName, int $walletStartBalance, string $userToken)
    {
        $this->walletId = $walletId;
        $this->walletName = $walletName;
        $this->walletStartBalance = $walletStartBalance;
        $this->userToken = $userToken;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $walletId = $request->get('id');
        $walletName = $request->get('name');
        $walletStartBalance = $request->get('start_balance');
        $userToken = self::extendUserTokenFromRequest($request);

        Assert::lazy()
            ->that($walletId, 'id')->notEmpty()
            ->that($walletName, 'name')->notEmpty()
            ->that($walletStartBalance, 'start_balance')->notEmpty()
            ->that($userToken, 'user_token')->notEmpty()
            ->verifyNow();

        return new self(
            $walletId,
            $walletName,
            $walletStartBalance,
            $userToken
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

    public function getUserToken(): string
    {
        return $this->userToken;
    }
}
