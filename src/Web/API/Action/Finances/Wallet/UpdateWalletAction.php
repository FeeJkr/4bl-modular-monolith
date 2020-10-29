<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet;

use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Wallet\UpdateWalletRequest;
use App\Web\API\Service\Finances\Wallet\WalletService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class UpdateWalletAction extends AbstractAction
{
    private WalletService $service;

    public function __construct(WalletService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $updateWalletRequest = UpdateWalletRequest::createFromServerRequest($request);

        $this->service->updateWallet($updateWalletRequest);

        return $this->noContentResponse();
    }
}
