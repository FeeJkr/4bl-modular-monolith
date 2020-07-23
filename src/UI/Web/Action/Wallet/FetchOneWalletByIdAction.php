<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Wallet;

use App\UI\Web\Action\Action;
use App\Wallet\ReadModel\Query\FetchOneWalletByIdQuery;
use App\Wallet\ReadModel\WalletReadModel;
use App\Wallet\SharedKernel\WalletId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchOneWalletByIdAction extends Action
{
    private $walletReadModel;

    public function __construct(WalletReadModel $walletReadModel)
    {
        $this->walletReadModel = $walletReadModel;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchOneWalletByIdQuery(
            WalletId::fromInt((int) $request->get('id')),
            $request->get('user_id')
        );

        return $this->json(
            $this->walletReadModel->fetchOneById($query)
        );
    }
}
