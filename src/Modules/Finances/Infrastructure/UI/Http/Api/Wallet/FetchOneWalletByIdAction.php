<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Wallet;

use App\Modules\Finances\Application\Wallet\Query\FetchOneWalletByIdQuery;
use App\Modules\Finances\Application\Wallet\WalletReadModel;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchOneWalletByIdAction extends Action
{
    private WalletReadModel $walletReadModel;

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
