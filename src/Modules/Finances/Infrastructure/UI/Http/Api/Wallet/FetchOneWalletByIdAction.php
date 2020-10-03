<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Wallet;

use App\Modules\Finances\Application\Wallet\Query\FetchOneWalletByIdQuery;
use App\Modules\Finances\Application\Wallet\WalletService;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchOneWalletByIdAction extends AbstractController
{
    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchOneWalletByIdQuery(
            WalletId::fromInt((int) $request->get('id')),
            $request->get('user_id')
        );

        return $this->json(
            $this->walletService->fetchOneById($query)
        );
    }
}
