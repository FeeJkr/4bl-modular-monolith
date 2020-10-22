<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\GetAll;

final class WalletsCollection
{
    /** @param WalletDTO[] wallets */
    private array $wallets;

    public function __construct(array $wallets)
    {
        $this->wallets = $wallets;
    }

    public function getWallets(): array
    {
        return $this->wallets;
    }
}
