<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Wallet;

use App\Modules\Finances\Application\Wallet\Command\CreateWalletCommand;
use App\Modules\Finances\Application\Wallet\WalletService;
use App\SharedKernel\Money;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateWalletAction extends Action
{
    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->walletService->createNewWallet(
            new CreateWalletCommand(
                $request->get('wallet_name'),
                new Money((int) $request->get('wallet_start_balance')),
                $request->get('user_id')
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
