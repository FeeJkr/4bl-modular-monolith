<?php
declare(strict_types=1);

namespace App\Web\API\Request\Finances\Wallet;

use App\Web\API\Request\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetOneWalletByIdRequest extends Request
{
    private int $walletId;
    private string $userToken;

    public function __construct(int $walletId, string $userToken)
    {
        $this->walletId = $walletId;
        $this->userToken = $userToken;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $walletId = $request->get('id');
        $userToken = self::extendUserTokenFromRequest($request);

        Assert::lazy()
            ->that($walletId, 'id')->notEmpty()
            ->that($userToken, 'user_token')->notEmpty()
            ->verifyNow();

        return new self(
            (int) $walletId,
            $userToken
        );
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }

    public function getUserToken(): string
    {
        return $this->userToken;
    }
}