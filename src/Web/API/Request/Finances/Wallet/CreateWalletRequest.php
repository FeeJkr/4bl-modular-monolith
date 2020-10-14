<?php
declare(strict_types=1);

namespace App\Web\API\Request\Finances\Wallet;

use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\Token;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request;

final class CreateWalletRequest
{


    private string $walletName;
    private Money $walletStartBalance;
    private string $userToken;

    private function __construct(string $walletName, Money $walletStartBalance, string $userToken)
    {
        $this->walletName = $walletName;
        $this->walletStartBalance = $walletStartBalance;
        $this->userToken = $userToken;
    }

    public static function createFromServerRequest(Request $request): self
    {
        self::validate($request);

        return new self(
            $request->get('name'),
            $request->get('start_balance'),
            $request->headers->get('X-Authorization')
        );
    }

    private static function validate(Request $request): void
    {
        Assert::lazy()
            ->that($request->get('name'), 'name')->notEmpty()
            ->that($request->get('start_balance'), 'start_balance')->notEmpty()
            ->that($request->headers->get('X-Authorization'))->notEmpty()
            ->verifyNow();
    }

    public function getWalletName(): string
    {
        return $this->walletName;
    }

    public function getWalletStartBalance(): Money
    {
        return $this->walletStartBalance;
    }

    public function getUserToken(): string
    {
        return $this->userToken;
    }
}
