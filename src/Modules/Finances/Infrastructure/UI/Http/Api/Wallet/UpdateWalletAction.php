<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Wallet;

use App\Common\User\UserId;
use App\Modules\Finances\Application\Wallet\Command\UpdateWalletCommand;
use App\Modules\Finances\Application\Wallet\WalletService;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UpdateWalletAction extends AbstractController
{
    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $userIds = new ArrayCollection();

        if (! empty($request->get('wallet_user_ids'))) {
            $userIds = (new ArrayCollection(explode(', ', $request->get('wallet_user_ids'))))
                ->map(static function (string $id): UserId { return UserId::fromInt((int) $id); });
        }

        $userIds->add($request->get('user_id'));

        $this->walletService->updateWallet(
            new UpdateWalletCommand(
                WalletId::fromInt((int) $request->get('id')),
                $request->get('user_id'),
                $request->get('wallet_name'),
                new Money((int) $request->get('wallet_start_balance')),
                $userIds
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
