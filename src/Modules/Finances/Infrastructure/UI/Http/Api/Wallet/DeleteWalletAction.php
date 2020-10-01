<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Wallet;

use App\Modules\Finances\Application\Wallet\Command\DeleteWalletCommand;
use App\Modules\Finances\Application\Wallet\WalletService;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DeleteWalletAction extends Action
{
    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->walletService->deleteWallet(
            new DeleteWalletCommand(
                WalletId::fromInt((int) $request->get('id')),
                $request->get('user_id')
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
