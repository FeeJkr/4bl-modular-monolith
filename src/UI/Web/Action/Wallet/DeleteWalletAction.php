<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Wallet;

use App\UI\Web\Action\Action;
use App\Wallet\Application\Command\DeleteWalletCommand;
use App\Wallet\Application\WalletService;
use App\Wallet\SharedKernel\WalletId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DeleteWalletAction extends Action
{
    private $walletService;

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
