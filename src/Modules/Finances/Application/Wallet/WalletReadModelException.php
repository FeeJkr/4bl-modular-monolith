<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Exception;

final class WalletReadModelException extends Exception
{
    public static function notFound(WalletId $walletId, UserId $userId): self
    {
        return new self(
            sprintf('Wallet with ID %s for user %s not found.', $walletId->toInt(), $userId->toInt())
        );
    }
}
