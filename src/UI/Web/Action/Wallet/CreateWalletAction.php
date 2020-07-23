<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Wallet;

use App\SharedKernel\Money;
use App\UI\Web\Action\Action;
use App\Wallet\Application\Command\CreateWalletCommand;
use App\Wallet\Application\WalletService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateWalletAction extends Action
{
    private $walletService;

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
