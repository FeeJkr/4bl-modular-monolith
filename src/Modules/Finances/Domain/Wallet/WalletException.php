<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Wallet;

use App\Modules\Finances\Domain\User\UserId;
use Exception;

final class WalletException extends Exception
{
    public static function notDeleted(WalletId $walletId, UserId $userId): self
    {
        return new self(
            sprintf('WalletResponse with ID %s for user %s can\'t be deleted.', $walletId->toInt(), $userId->toInt())
        );
    }

    public static function notFound(WalletId $walletId, UserId $userId): self
    {
        return new self(
            sprintf('WalletResponse with ID %s for user %s not found.', $walletId->toInt(), $userId->toInt())
        );
    }
}
