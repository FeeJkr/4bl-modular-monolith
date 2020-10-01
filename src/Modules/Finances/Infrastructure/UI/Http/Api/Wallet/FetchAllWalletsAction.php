<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Wallet;

use App\Modules\Finances\Application\Wallet\Query\FetchAllWalletsQuery;
use App\Modules\Finances\Application\Wallet\WalletReadModel;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchAllWalletsAction extends Action
{
    private WalletReadModel $walletReadModel;

    public function __construct(WalletReadModel $walletReadModel)
    {
        $this->walletReadModel = $walletReadModel;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchAllWalletsQuery(
            $request->get('user_id')
        );

        return $this->json(
            $this->walletReadModel->fetchAll($query)->toArray()
        );
    }
}
