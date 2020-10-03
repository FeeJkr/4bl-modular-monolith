<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\FetchOneById;

use App\Modules\Finances\Domain\Wallet\WalletException;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class FetchOneWalletByIdHandler
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchOneWalletByIdQuery $query): WalletDTO
    {
        $walletDTO = $this->repository->fetchOneById($query->getWalletId(), $query->getUserId());

        if ($walletDTO === null) {
            throw WalletException::notFound($query->getWalletId(), $query->getUserId());
        }

        return $walletDTO;
    }
}
