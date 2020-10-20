<?php
declare(strict_types=1);

namespace App\Web\API\ViewModel\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\FetchAll\WalletsCollection;
use App\Modules\Finances\Application\Wallet\FetchOneById\WalletDTO;

final class ViewModelMapper
{
    public function map(WalletDTO $dto): Wallet
    {
        return new Wallet(
            $dto->getId(),
            $dto->getName(),
            $dto->getStartBalance(),
            $dto->getUserId(),
            $dto->getCreatedAt()
        );
    }

    public function mapCollection(WalletsCollection $walletsCollection): array
    {
        $wallets = [];

        /** @var \App\Modules\Finances\Application\Wallet\FetchAll\WalletDTO $wallet */
        foreach ($walletsCollection->getWallets() as $wallet) {
            $wallets[] = new Wallet(
                $wallet->getId(),
                $wallet->getName(),
                $wallet->getStartBalance(),
                $wallet->getUserId(),
                $wallet->getCreatedAt()
            );
        }

        return $wallets;
    }
}
