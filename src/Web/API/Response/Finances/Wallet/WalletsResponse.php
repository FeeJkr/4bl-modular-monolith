<?php
declare(strict_types=1);

namespace App\Web\API\Response\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\GetAll\WalletDTO;
use App\Modules\Finances\Application\Wallet\GetAll\WalletsCollection;

final class WalletsResponse
{
    private array $wallets;

    public function __construct(WalletResponse ...$wallets)
    {
        $this->wallets = $wallets;
    }

    public static function createFromCollection(WalletsCollection $collection): self
    {
        $data = [];

        /** @var WalletDTO $wallet */
        foreach($collection->getWallets() as $wallet) {
            $data[] = new WalletResponse(
                $wallet->getId(),
                $wallet->getName(),
                $wallet->getStartBalance(),
                $wallet->getUserId(),
                $wallet->getCreatedAt()
            );
        }

        return new self(...$data);
    }

    public function getResponse(): array
    {
        return array_map(
            static fn(WalletResponse $wallet) => $wallet->getResponse(),
            $this->wallets
        );
    }
}
